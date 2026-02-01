@extends('layouts.admin')

@section('content')
<div class="mb-6 flex items-center justify-between">
    <div>
        <h1 class="text-2xl font-bold text-gray-900">Products Management</h1>
        <p class="text-gray-600 mt-1">Manage menu items and approve supplier products</p>
    </div>
    <a href="{{ route('admin.products.create') }}" class="inline-flex items-center gap-2 px-6 py-3 bg-gradient-to-r from-yellow-500 to-orange-500 text-white rounded-lg font-semibold hover:from-yellow-600 hover:to-orange-600 transition-all shadow-lg">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
        Add New Product
    </a>
</div>

@if(session('success'))
    <div class="mb-6 bg-green-50 border border-green-200 text-green-800 px-4 py-3 rounded-lg">
        {{ session('success') }}
    </div>
@endif

<!-- Filters -->
<div class="mb-6 flex items-center gap-4">
    <div class="flex items-center gap-2">
        <label class="text-sm font-medium text-gray-700">Filter by Status:</label>
        <select onchange="window.location.href='?status='+this.value" class="px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-orange-500">
            <option value="all" {{ request('status') === 'all' ? 'selected' : '' }}>All Products</option>
            <option value="pending" {{ request('status') === 'pending' ? 'selected' : '' }}>Pending ({{ $pendingCount }})</option>
            <option value="approved" {{ request('status') === 'approved' ? 'selected' : '' }}>Approved</option>
            <option value="rejected" {{ request('status') === 'rejected' ? 'selected' : '' }}>Rejected</option>
        </select>
    </div>
</div>

<div class="bg-white rounded-2xl shadow-sm border border-gray-200">
    <div class="overflow-x-auto">
        <table class="w-full table-fixed">
            <colgroup>
                <col class="w-72">
                <col class="w-40">
                <col class="w-44">
                <col class="w-32">
                <col class="w-24">
                <col class="w-40">
                <col class="w-32">
            </colgroup>
            <thead class="bg-gray-50 border-b border-gray-200">
                <tr>
                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Product</th>
                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Category</th>
                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Supplier</th>
                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Price</th>
                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Stock</th>
                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Status</th>
                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                @forelse($products as $product)
                <tr class="hover:bg-gray-50">
                    <td class="px-6 py-4" style="max-width: 300px;">
                        <div style="display: flex; align-items: center; gap: 12px;">
                            @if($product->image_url)
                                <img src="{{ $product->image_url }}" alt="{{ $product->name }}" style="width: 48px; height: 48px; border-radius: 8px; object-fit: cover; flex-shrink: 0;">
                            @else
                                <div style="width: 48px; height: 48px; background-color: #e5e7eb; border-radius: 8px; display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
                                    <svg class="w-6 h-6 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                </div>
                            @endif
                            <div style="flex: 1; min-width: 0;">
                                <div style="font-weight: 500; color: #111827; font-size: 14px; line-height: 1.5; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;">
                                    {{ $product->name }}
                                </div>
                                <div style="font-size: 12px; color: #6b7280; line-height: 1.5; overflow: hidden; text-overflow: ellipsis; white-space: nowrap; margin-top: 2px;">
                                    {{ Str::limit($product->description, 40) }}
                                </div>
                            </div>
                        </div>
                    </td>
                    <td class="px-6 py-4">
                        <span style="display: block; font-size: 14px; color: #111827; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;">{{ $product->category->name ?? 'N/A' }}</span>
                    </td>
                    <td class="px-6 py-4">
                        <span style="display: block; font-size: 14px; color: #111827; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;">{{ $product->supplier->name ?? 'N/A' }}</span>
                    </td>
                    <td class="px-6 py-4">
                        <span style="display: block; font-size: 14px; font-weight: 600; color: #111827; white-space: nowrap;">{{ number_format($product->price, 2) }} SAR</span>
                    </td>
                    <td class="px-6 py-4">
                        <span class="text-sm text-gray-900">{{ $product->stock_quantity }}</span>
                    </td>
                    <td class="px-6 py-4">
                        <div class="flex flex-col gap-1">
                            @if($product->approval_status === 'approved')
                                <span class="inline-flex items-center justify-center px-3 py-1 text-xs font-semibold text-green-800 bg-green-100 rounded-full whitespace-nowrap">Approved</span>
                            @elseif($product->approval_status === 'pending')
                                <span class="inline-flex items-center justify-center px-3 py-1 text-xs font-semibold text-yellow-800 bg-yellow-100 rounded-full whitespace-nowrap">Pending</span>
                            @else
                                <span class="inline-flex items-center justify-center px-3 py-1 text-xs font-semibold text-red-800 bg-red-100 rounded-full whitespace-nowrap">Rejected</span>
                            @endif
                            @if($product->is_active)
                                <span class="inline-flex items-center justify-center px-2 py-0.5 text-xs text-blue-800 bg-blue-100 rounded-full whitespace-nowrap">Active</span>
                            @else
                                <span class="inline-flex items-center justify-center px-2 py-0.5 text-xs text-gray-800 bg-gray-100 rounded-full whitespace-nowrap">Inactive</span>
                            @endif
                        </div>
                    </td>
                    <td class="px-6 py-4">
                        <div class="flex items-center gap-2">
                            @if($product->approval_status === 'pending')
                                <form action="{{ route('admin.products.approve', $product->id) }}" method="POST" class="inline-block">
                                    @csrf
                                    <button type="submit" class="text-green-600 hover:text-green-800 transition-colors" title="Approve">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                                    </button>
                                </form>
                                <form action="{{ route('admin.products.reject', $product->id) }}" method="POST" class="inline-block">
                                    @csrf
                                    <button type="submit" class="text-red-600 hover:text-red-800 transition-colors" title="Reject">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                                    </button>
                                </form>
                            @endif
                            <a href="{{ route('admin.products.edit', $product->id) }}" class="text-blue-600 hover:text-blue-800 transition-colors" title="Edit">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                            </a>
                            <form action="{{ route('admin.products.destroy', $product->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this product?')" class="inline-block">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600 hover:text-red-800 transition-colors" title="Delete">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="px-6 py-12 text-center text-gray-500">No products found</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    
    @if($products->hasPages())
    <div class="px-6 py-4 border-t border-gray-200">
        {{ $products->links() }}
    </div>
    @endif
</div>
@endsection
