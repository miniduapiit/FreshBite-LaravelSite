<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use App\Models\Vendor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class VendorProductController extends Controller
{
    /**
     * Display a listing of the vendor's products.
     */
    public function index()
    {
        $user = Auth::user();
        $vendor = $user->vendors()->first();

        if (!$vendor) {
            return redirect()->route('vendor.dashboard')
                ->with('error', 'You need to create a vendor profile first.');
        }

        $products = Product::where('vendor_id', $vendor->id)
            ->with('category')
            ->latest()
            ->paginate(15);

        return view('vendor.products.index', compact('products', 'vendor'));
    }

    /**
     * Show the form for creating a new product.
     */
    public function create()
    {
        $user = Auth::user();
        $vendor = $user->vendors()->first();

        if (!$vendor) {
            return redirect()->route('vendor.dashboard')
                ->with('error', 'You need to create a vendor profile first.');
        }

        $categories = Category::where('is_active', true)->orderBy('name')->get();

        return view('vendor.products.create', compact('vendor', 'categories'));
    }

    /**
     * Store a newly created product in storage.
     */
    public function store(Request $request)
    {
        $user = Auth::user();
        $vendor = $user->vendors()->first();

        if (!$vendor) {
            return redirect()->route('vendor.dashboard')
                ->with('error', 'You need to create a vendor profile first.');
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'category_id' => 'nullable|exists:categories,id',
            'price' => 'required|numeric|min:0',
            'is_available' => 'boolean',
            'is_featured' => 'boolean',
            'stock_quantity' => 'nullable|integer|min:0',
            'preparation_time' => 'nullable|integer|min:0',
            'calories' => 'nullable|integer|min:0',
        ]);

        $validated['vendor_id'] = $vendor->id;
        $validated['slug'] = Str::slug($validated['name'] . '-' . time());
        $validated['is_available'] = $request->has('is_available');
        $validated['is_featured'] = $request->has('is_featured');

        Product::create($validated);

        return redirect()->route('vendor.products.index')
            ->with('success', 'Product created successfully.');
    }

    /**
     * Display the specified product.
     */
    public function show(string $id)
    {
        $user = Auth::user();
        $vendor = $user->vendors()->first();

        $product = Product::where('vendor_id', $vendor->id)
            ->with('category')
            ->findOrFail($id);

        return view('vendor.products.show', compact('product', 'vendor'));
    }

    /**
     * Show the form for editing the specified product.
     */
    public function edit(string $id)
    {
        $user = Auth::user();
        $vendor = $user->vendors()->first();

        $product = Product::where('vendor_id', $vendor->id)->findOrFail($id);
        $categories = Category::where('is_active', true)->orderBy('name')->get();

        return view('vendor.products.edit', compact('product', 'vendor', 'categories'));
    }

    /**
     * Update the specified product in storage.
     */
    public function update(Request $request, string $id)
    {
        $user = Auth::user();
        $vendor = $user->vendors()->first();

        $product = Product::where('vendor_id', $vendor->id)->findOrFail($id);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'category_id' => 'nullable|exists:categories,id',
            'price' => 'required|numeric|min:0',
            'is_available' => 'boolean',
            'is_featured' => 'boolean',
            'stock_quantity' => 'nullable|integer|min:0',
            'preparation_time' => 'nullable|integer|min:0',
            'calories' => 'nullable|integer|min:0',
        ]);

        $validated['is_available'] = $request->has('is_available');
        $validated['is_featured'] = $request->has('is_featured');

        // Update slug if name changed
        if ($product->name !== $validated['name']) {
            $validated['slug'] = Str::slug($validated['name'] . '-' . $product->id);
        }

        $product->update($validated);

        return redirect()->route('vendor.products.index')
            ->with('success', 'Product updated successfully.');
    }

    /**
     * Remove the specified product from storage.
     */
    public function destroy(string $id)
    {
        $user = Auth::user();
        $vendor = $user->vendors()->first();

        $product = Product::where('vendor_id', $vendor->id)->findOrFail($id);
        $product->delete();

        return redirect()->route('vendor.products.index')
            ->with('success', 'Product deleted successfully.');
    }
}
