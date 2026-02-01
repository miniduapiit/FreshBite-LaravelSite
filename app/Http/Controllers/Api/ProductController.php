<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ProductResource;
use App\Models\Category;
use App\Models\Product;
use App\Models\Vendor;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Display a listing of products.
     * 
     * @param Request $request
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function index(Request $request)
    {
        $query = Product::with(['vendor', 'category'])
            ->where('is_available', true);

        // Filter by category
        if ($request->has('category') && $request->category) {
            $query->whereHas('category', function ($q) use ($request) {
                $q->where('slug', $request->category);
            });
        }

        // Filter by vendor
        if ($request->has('vendor') && $request->vendor) {
            $query->whereHas('vendor', function ($q) use ($request) {
                $q->where('slug', $request->vendor);
            });
        }

        // Search by name
        if ($request->has('search') && $request->search) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        // Pagination
        $perPage = $request->get('per_page', 15);
        $perPage = min($perPage, 100); // Max 100 per page

        $products = $query->latest()->paginate($perPage);

        return ProductResource::collection($products);
    }

    /**
     * Display the specified product.
     * 
     * @param string $id
     * @return ProductResource
     */
    public function show(string $id)
    {
        $product = Product::with(['vendor', 'category'])
            ->where('is_available', true)
            ->findOrFail($id);

        return new ProductResource($product);
    }
}
