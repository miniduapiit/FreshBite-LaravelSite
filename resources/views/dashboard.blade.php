<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-4">
            <a href="{{ url()->previous() !== url()->current() ? url()->previous() : route('home') }}" 
               class="flex items-center justify-center w-10 h-10 rounded-lg bg-white hover:bg-green-50 text-gray-600 hover:text-green-600 transition-smooth shadow-sm group">
                <svg class="w-5 h-5 group-hover:-translate-x-0.5 transition-smooth" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                </svg>
            </a>
            <h2 class="text-2xl font-extrabold bg-gradient-to-r from-green-600 to-green-700 bg-clip-text text-transparent">
                {{ __('Dashboard') }}
            </h2>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="glass-effect overflow-hidden shadow-modern sm:rounded-2xl p-8 animate-fade-in-up">
                <div class="mb-8">
                    <h3 class="text-3xl font-extrabold text-gray-900 mb-2">
                        Welcome back, {{ Auth::user()->name }}! 👋
                    </h3>
                    <p class="text-gray-600 text-lg">
                        This is your FreshBite dashboard. Manage your account and explore our features.
                    </p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    <!-- Quick Actions Card -->
                    <div class="glass-effect rounded-2xl p-6 shadow-modern card-hover border border-green-100">
                        <div class="flex items-center gap-3 mb-4">
                            <div class="w-10 h-10 bg-gradient-to-br from-green-600 to-green-700 rounded-lg flex items-center justify-center">
                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                                </svg>
                            </div>
                            <h4 class="font-bold text-gray-900 text-lg">Quick Actions</h4>
                        </div>
                        <ul class="space-y-3 text-sm text-gray-700">
                            <li>
                                <a href="{{ route('products.index') }}" class="flex items-center gap-2 text-gray-700 hover:text-green-600 transition-smooth hover:translate-x-1 font-medium">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"/></svg>
                                    Browse Products
                                </a>
                            </li>
                            @if(Auth::user()->hasRole('customer'))
                            <li>
                                <a href="{{ route('customer.cart') }}" class="flex items-center gap-2 text-gray-700 hover:text-green-600 transition-smooth hover:translate-x-1 font-medium">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"/></svg>
                                    View Cart
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('customer.orders.index') }}" class="flex items-center gap-2 text-gray-700 hover:text-green-600 transition-smooth hover:translate-x-1 font-medium">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"/></svg>
                                    My Orders
                                </a>
                            </li>
                            @endif
                            @if(Auth::user()->hasRole('supplier'))
                            <li>
                                <a href="{{ route('vendor.products.index') }}" class="flex items-center gap-2 text-gray-700 hover:text-green-600 transition-smooth hover:translate-x-1 font-medium">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"/></svg>
                                    Manage Products
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('vendor.orders') }}" class="flex items-center gap-2 text-gray-700 hover:text-green-600 transition-smooth hover:translate-x-1 font-medium">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"/></svg>
                                    View Orders
                                </a>
                            </li>
                            @endif
                            @if(Auth::user()->hasRole('admin'))
                            <li>
                                <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-2 text-gray-700 hover:text-green-600 transition-smooth hover:translate-x-1 font-medium">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"/></svg>
                                    Admin Panel
                                </a>
                            </li>
                            @endif
                        </ul>
                    </div>

                    <!-- Account Info Card -->
                    <div class="glass-effect rounded-2xl p-6 shadow-modern card-hover border border-blue-100">
                        <div class="flex items-center gap-3 mb-4">
                            <div class="w-10 h-10 bg-gradient-to-br from-blue-600 to-blue-700 rounded-lg flex items-center justify-center">
                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                </svg>
                            </div>
                            <h4 class="font-bold text-gray-900 text-lg">Account Information</h4>
                        </div>
                        <div class="space-y-3 text-sm text-gray-700">
                            <div class="flex items-start gap-2">
                                <svg class="w-5 h-5 text-blue-600 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                                <div>
                                    <p class="text-xs text-gray-500">Email</p>
                                    <p class="font-medium text-gray-900">{{ Auth::user()->email }}</p>
                                </div>
                            </div>
                            <div class="flex items-start gap-2">
                                <svg class="w-5 h-5 text-blue-600 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                                <div>
                                    <p class="text-xs text-gray-500">Role</p>
                                    <p class="font-medium">
                                        @if(Auth::user()->hasRole('admin'))
                                            <span class="px-2 py-1 bg-purple-100 text-purple-800 rounded-md text-xs font-semibold">Administrator</span>
                                        @elseif(Auth::user()->hasRole('supplier'))
                                            <span class="px-2 py-1 bg-blue-100 text-blue-800 rounded-md text-xs font-semibold">Supplier</span>
                                        @elseif(Auth::user()->hasRole('customer'))
                                            <span class="px-2 py-1 bg-green-100 text-green-800 rounded-md text-xs font-semibold">Customer</span>
                                        @else
                                            <span class="px-2 py-1 bg-gray-100 text-gray-800 rounded-md text-xs font-semibold">User</span>
                                        @endif
                                    </p>
                                </div>
                            </div>
                            <a href="{{ route('profile.show') }}" class="inline-flex items-center gap-2 mt-4 text-blue-600 hover:text-blue-700 transition-smooth font-semibold group">
                                <svg class="w-4 h-4 group-hover:translate-x-1 transition-smooth" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"/></svg>
                                Edit Profile
                            </a>
                        </div>
                    </div>

                    <!-- Stats Card -->
                    <div class="glass-effect rounded-2xl p-6 shadow-modern card-hover border border-yellow-100">
                        <div class="flex items-center gap-3 mb-4">
                            <div class="w-10 h-10 bg-gradient-to-br from-yellow-500 to-yellow-600 rounded-lg flex items-center justify-center">
                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                                </svg>
                            </div>
                            <h4 class="font-bold text-gray-900 text-lg">Statistics</h4>
                        </div>
                        <div class="space-y-3 text-sm">
                            @if(Auth::user()->hasRole('customer'))
                            <div class="flex items-center justify-between p-3 bg-white rounded-lg">
                                <span class="text-gray-600">Total Orders</span>
                                <span class="font-bold text-gray-900 text-lg">-</span>
                            </div>
                            @endif
                            @if(Auth::user()->hasRole('supplier'))
                            <div class="flex items-center justify-between p-3 bg-white rounded-lg">
                                <span class="text-gray-600">Products Listed</span>
                                <span class="font-bold text-gray-900 text-lg">-</span>
                            </div>
                            <div class="flex items-center justify-between p-3 bg-white rounded-lg">
                                <span class="text-gray-600">Pending Orders</span>
                                <span class="font-bold text-gray-900 text-lg">-</span>
                            </div>
                            @endif
                            <p class="text-xs text-gray-500 mt-4 italic text-center">📊 More stats coming soon...</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
