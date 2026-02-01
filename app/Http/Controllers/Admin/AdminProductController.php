<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class AdminProductController extends Controller
{
    /**
     * Display a listing of products
     */
    public function index(Request $request)
    {
        $query = Product::with(['supplier', 'category']);

        // Filter by approval status
        if ($request->has('status') && $request->status !== 'all') {
            $query->where('approval_status', $request->status);
        }

        $products = $query->orderBy('created_at', 'desc')->paginate(20);
        $pendingCount = Product::where('approval_status', 'pending')->count();

        return view('admin.products.index', compact('products', 'pendingCount'));
    }

    /**
     * Show the form for creating a new product
     */
    public function create()
    {
        $categories = Category::all();
        $suppliers = User::where('role', 'supplier')->get();

        return view('admin.products.create', compact('categories', 'suppliers'));
    }

    /**
     * Store a newly created product
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'category_id' => 'required|exists:categories,id',
            'supplier_id' => 'required|exists:users,id',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'image_url' => 'nullable|url',
            'stock_quantity' => 'required|integer|min:0',
            'is_active' => 'boolean',
            'approval_status' => 'required|in:pending,approved,rejected',
        ]);

        $product = new Product();
        $product->name = $request->name;
        
        // Generate unique slug
        $baseSlug = Str::slug($request->name);
        $slug = $baseSlug;
        $counter = 1;
        
        while (Product::where('slug', $slug)->exists()) {
            $counter++;
            $slug = $baseSlug . '-' . $counter;
        }
        
        $product->slug = $slug;
        
        $product->description = $request->description;
        $product->price = $request->price;
        $product->category_id = $request->category_id;
        $product->supplier_id = $request->supplier_id;
        
        // Handle image upload
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time() . '_' . $image->getClientOriginalName();
            $image->storeAs('public/products', $imageName);
            $product->image_url = '/storage/products/' . $imageName;
        } elseif ($request->image_url) {
            $product->image_url = $request->image_url;
        }
        
        $product->stock_quantity = $request->stock_quantity;
        $product->is_active = $request->has('is_active');
        $product->approval_status = $request->approval_status ?? 'approved';
        $product->approved_by = auth()->id();
        $product->approved_at = now();
        $product->save();

        return redirect()->route('admin.items')->with('success', 'Product created successfully!');
    }

    /**
     * Show the form for editing the specified product
     */
    public function edit($id)
    {
        $product = Product::findOrFail($id);
        $categories = Category::all();
        $suppliers = User::where('role', 'supplier')->get();

        return view('admin.products.edit', compact('product', 'categories', 'suppliers'));
    }

    /**
     * Update the specified product
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'category_id' => 'required|exists:categories,id',
            'supplier_id' => 'required|exists:users,id',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'image_url' => 'nullable|url',
            'stock_quantity' => 'required|integer|min:0',
            'is_active' => 'boolean',
            'approval_status' => 'required|in:pending,approved,rejected',
        ]);

        $product = Product::findOrFail($id);
        
        // Check if the name has actually changed before updating slug
        $nameChanged = $product->name !== $request->name;
        
        $product->name = $request->name;
        
        // Only update slug if the name has changed
        if ($nameChanged) {
            $baseSlug = Str::slug($request->name);
            $slug = $baseSlug;
            $counter = 1;
            
            // Check if slug exists (excluding current product) - with soft deletes
            while (Product::withTrashed()->where('slug', $slug)->where('id', '!=', $id)->exists()) {
                $slug = $baseSlug . '-' . $counter;
                $counter++;
            }
            
            $product->slug = $slug;
        }
        
        $product->description = $request->description;
        $product->price = $request->price;
        $product->category_id = $request->category_id;
        $product->supplier_id = $request->supplier_id;
        
        // Handle image upload
        if ($request->hasFile('image')) {
            // Delete old image if it exists and is stored locally
            if ($product->image_url && str_starts_with($product->image_url, '/storage/products/')) {
                $oldImagePath = storage_path('app/public/products/' . basename($product->image_url));
                if (file_exists($oldImagePath)) {
                    unlink($oldImagePath);
                }
            }
            
            $image = $request->file('image');
            $imageName = time() . '_' . $image->getClientOriginalName();
            $image->storeAs('public/products', $imageName);
            $product->image_url = '/storage/products/' . $imageName;
        } elseif ($request->image_url) {
            $product->image_url = $request->image_url;
        }
        
        $product->stock_quantity = $request->stock_quantity;
        $product->is_active = $request->has('is_active');
        $product->approval_status = $request->approval_status;
        $product->save();

        return redirect()->route('admin.items')->with('success', 'Product updated successfully!');
    }

    /**
     * Approve a product
     */
    public function approve($id)
    {
        $product = Product::findOrFail($id);
        $product->approval_status = 'approved';
        $product->approved_by = auth()->id();
        $product->approved_at = now();
        $product->save();

        return redirect()->back()->with('success', 'Product approved successfully!');
    }

    /**
     * Reject a product
     */
    public function reject($id)
    {
        $product = Product::findOrFail($id);
        $product->approval_status = 'rejected';
        $product->approved_by = auth()->id();
        $product->approved_at = now();
        $product->save();

        return redirect()->back()->with('success', 'Product rejected successfully!');
    }

    /**
     * Remove the specified product
     */
    public function destroy($id)
    {
        $product = Product::findOrFail($id);
        $product->delete();

        return redirect()->route('admin.products.index')->with('success', 'Product deleted successfully!');
    }
}
