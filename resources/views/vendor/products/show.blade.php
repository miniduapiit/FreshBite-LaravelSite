<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            <a href="{{ route('vendor.products.index') }}" class="text-blue-600 hover:text-blue-800">My Products</a> / {{ $product->name }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-sm rounded-lg p-6">
                <div class="flex justify-between items-start mb-6">
                    <div>
                        <h1 class="text-3xl font-bold mb-2">{{ $product->name }}</h1>
                        <p class="text-gray-600">Created: {{ $product->created_at->format('M d, Y') }}</p>
                    </div>
                    <div class="flex gap-2">
                        <a href="{{ route('vendor.products.edit', $product->id) }}" class="bg-blue-500 text-white px-4 py-2 rounded-md hover:bg-blue-600">
                            Edit
                        </a>
                        <a href="{{ route('vendor.products.index') }}" class="bg-gray-500 text-white px-4 py-2 rounded-md hover:bg-gray-600">
                            Back
                        </a>
                    </div>
                </div>

                <div class="grid md:grid-cols-2 gap-6 mb-6">
                    <div>
                        <h3 class="font-semibold mb-2">Product Details</h3>
                        <dl class="space-y-2">
                            <div>
                                <dt class="text-gray-600">Price:</dt>
                                <dd class="font-semibold text-lg">${{ number_format($product->price, 2) }}</dd>
                            </div>
                            <div>
                                <dt class="text-gray-600">Category:</dt>
                                <dd>{{ $product->category->name ?? 'Uncategorized' }}</dd>
                            </div>
                            @if($product->preparation_time)
                                <div>
                                    <dt class="text-gray-600">Preparation Time:</dt>
                                    <dd>{{ $product->preparation_time }} minutes</dd>
                                </div>
                            @endif
                            @if($product->calories)
                                <div>
                                    <dt class="text-gray-600">Calories:</dt>
                                    <dd>{{ $product->calories }}</dd>
                                </div>
                            @endif
                            @if($product->stock_quantity !== null)
                                <div>
                                    <dt class="text-gray-600">Stock Quantity:</dt>
                                    <dd>{{ $product->stock_quantity }}</dd>
                                </div>
                            @endif
                        </dl>
                    </div>
                    <div>
                        <h3 class="font-semibold mb-2">Status</h3>
                        <div class="space-y-2">
                            @if($product->is_available)
                                <span class="inline-block px-3 py-1 bg-green-100 text-green-800 rounded-full text-sm">Available</span>
                            @else
                                <span class="inline-block px-3 py-1 bg-red-100 text-red-800 rounded-full text-sm">Unavailable</span>
                            @endif
                            @if($product->is_featured)
                                <span class="inline-block px-3 py-1 bg-yellow-100 text-yellow-800 rounded-full text-sm ml-2">Featured</span>
                            @endif
                        </div>
                    </div>
                </div>

                @if($product->description)
                    <div class="mb-6">
                        <h3 class="font-semibold mb-2">Description</h3>
                        <p class="text-gray-700">{{ $product->description }}</p>
                    </div>
                @endif

                <div class="border-t pt-6">
                    <h3 class="font-semibold mb-4">Order Statistics</h3>
                    <p class="text-gray-600">This product has been ordered {{ $product->orderItems->count() }} times.</p>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
