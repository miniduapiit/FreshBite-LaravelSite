<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use App\Models\Vendor;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Display a listing of products.
     */
    public function index(Request $request)
    {
        $query = Product::with(['supplier', 'category'])
            ->where('is_active', true);

        // Filter by categories (multiple)
        if ($request->has('categories') && is_array($request->categories) && !in_array('all', $request->categories)) {
            $query->whereHas('category', function ($q) use ($request) {
                $q->whereIn('slug', $request->categories);
            });
        }

        // Filter by price range
        if ($request->has('price_range') && is_array($request->price_range)) {
            $query->where(function ($q) use ($request) {
                foreach ($request->price_range as $range) {
                    if ($range === '5-10') {
                        $q->orWhereBetween('price', [5, 10]);
                    } elseif ($range === '10-20') {
                        $q->orWhereBetween('price', [10, 20]);
                    } elseif ($range === '20-30') {
                        $q->orWhereBetween('price', [20, 30]);
                    } elseif ($range === 'above-30') {
                        $q->orWhere('price', '>', 30);
                    }
                }
            });
        }

        // Search by name
        if ($request->has('search') && $request->search) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        // Sort by
        $sortBy = $request->get('sort_by', 'popular');
        switch ($sortBy) {
            case 'price_low':
                $query->orderBy('price', 'asc');
                break;
            case 'price_high':
                $query->orderBy('price', 'desc');
                break;
            case 'newest':
                $query->latest();
                break;
            default:
                $query->latest(); // Default to popular (newest for now)
                break;
        }

        $products = $query->paginate(12)->withQueryString();
        $categories = Category::where('is_active', true)->orderBy('sort_order')->orderBy('name')->get();

        return view('products.index', compact('products', 'categories'));
    }

    /**
     * Display the specified product.
     */
    public function show($slug)
    {
        $product = Product::with(['supplier', 'category'])
            ->where('slug', $slug)
            ->where('is_active', true)
            ->firstOrFail();

        // Get related products from same supplier
        $relatedProducts = Product::where('supplier_id', $product->supplier_id)
            ->where('id', '!=', $product->id)
            ->where('is_active', true)
            ->limit(4)
            ->get();

        return view('products.show', compact('product', 'relatedProducts'));
    }
}
