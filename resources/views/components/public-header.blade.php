<!-- Public Header Navigation -->
<header class="w-full glass-effect sticky top-0 z-50 shadow-modern border-b border-gray-100" x-data="{ mobileMenuOpen: false }">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-center justify-between h-20">
            <!-- Logo -->
            <div class="flex items-center gap-2 flex-shrink-0">
                <a href="{{ route('home') }}" class="flex items-center gap-2 hover:opacity-80 transition-opacity">
                    <svg class="w-8 h-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                    </svg>
                    <span class="text-2xl font-bold text-gray-900">FreshBite</span>
                </a>
            </div>

            <!-- Desktop Navigation Links -->
            <nav class="hidden md:flex items-center gap-6">
                <a href="{{ route('home') }}" 
                   class="text-gray-700 hover:text-green-600 font-medium transition-colors px-2 py-1 {{ request()->routeIs('home') ? 'text-green-600 border-b-2 border-green-600' : '' }}">
                    Home
                </a>
                <a href="{{ route('about') }}" 
                   class="text-gray-700 hover:text-green-600 font-medium transition-colors px-2 py-1 {{ request()->routeIs('about') ? 'text-green-600 border-b-2 border-green-600' : '' }}">
                    About Us
                </a>
                <a href="{{ route('menu') }}" 
                   class="text-gray-700 hover:text-green-600 font-medium transition-colors px-2 py-1 {{ request()->routeIs('menu') || request()->routeIs('products.*') ? 'text-green-600 border-b-2 border-green-600' : '' }}">
                    Menu
                </a>
                <a href="{{ route('testimonials') }}" 
                   class="text-gray-700 hover:text-green-600 font-medium transition-colors px-2 py-1 {{ request()->routeIs('testimonials') ? 'text-green-600 border-b-2 border-green-600' : '' }}">
                    Testimonials
                </a>
                <a href="{{ route('reservation') }}" 
                   class="text-gray-700 hover:text-green-600 font-medium transition-colors px-2 py-1 {{ request()->routeIs('reservation') ? 'text-green-600 border-b-2 border-green-600' : '' }}">
                    Reservation
                </a>
                <a href="{{ route('contact') }}" 
                   class="text-gray-700 hover:text-green-600 font-medium transition-colors px-2 py-1 {{ request()->routeIs('contact') ? 'text-green-600 border-b-2 border-green-600' : '' }}">
                    Contact
                </a>
            </nav>

            <!-- Right Side Actions - Desktop -->
            <div class="hidden md:flex items-center gap-4">
                <!-- Cart Icon -->
                @php
                    $cart = session()->get('cart', []);
                    $cartCount = array_sum(array_column($cart, 'quantity'));
                @endphp
                <a href="{{ Auth::check() && Auth::user()->role === 'customer' ? route('customer.cart') : route('login') }}" 
                   class="relative p-2 text-gray-700 hover:text-green-600 hover:bg-green-50 rounded-lg transition-smooth group">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                    </svg>
                    @if($cartCount > 0)
                        <span class="absolute -top-1 -right-1 w-5 h-5 bg-gradient-to-r from-green-600 to-green-700 text-white text-xs font-bold rounded-full flex items-center justify-center shadow-lg group-hover:scale-110 transition-smooth">
                            {{ $cartCount > 9 ? '9+' : $cartCount }}
                        </span>
                    @endif
                </a>

                @auth
                    <!-- User Dropdown Menu -->
                    <div class="relative" x-data="{ userDropdownOpen: false }">
                        <button @click="userDropdownOpen = !userDropdownOpen"
                                @click.away="userDropdownOpen = false"
                                class="flex items-center gap-2 text-gray-700 hover:text-green-600 font-medium transition-smooth px-4 py-2 rounded-lg hover:bg-green-50 group">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                            </svg>
                            <span>{{ Auth::user()->name }}</span>
                            <svg class="w-4 h-4 transition-transform" :class="{'rotate-180': userDropdownOpen}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                            </svg>
                        </button>

                        <!-- Dropdown Menu -->
                        <div x-show="userDropdownOpen"
                             x-transition:enter="transition ease-out duration-200"
                             x-transition:enter-start="opacity-0 transform scale-95"
                             x-transition:enter-end="opacity-100 transform scale-100"
                             x-transition:leave="transition ease-in duration-75"
                             x-transition:leave-start="opacity-100 transform scale-100"
                             x-transition:leave-end="opacity-0 transform scale-95"
                             class="absolute right-0 mt-2 w-56 bg-white rounded-xl shadow-lg border border-gray-200 py-2 z-50"
                             style="display: none;">
                            
                            <div class="px-4 py-3 border-b border-gray-100">
                                <p class="text-sm font-semibold text-gray-900">{{ Auth::user()->name }}</p>
                                <p class="text-xs text-gray-500">{{ Auth::user()->email }}</p>
                            </div>

                            <a href="{{ route('dashboard') }}" 
                               class="flex items-center gap-3 px-4 py-3 text-gray-700 hover:bg-green-50 hover:text-green-600 transition-smooth">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                                </svg>
                                Dashboard
                            </a>

                            @if(Auth::user()->role === 'customer')
                                <a href="{{ route('customer.orders.index') }}" 
                                   class="flex items-center gap-3 px-4 py-3 text-gray-700 hover:bg-green-50 hover:text-green-600 transition-smooth">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"/>
                                    </svg>
                                    My Orders
                                </a>

                                <a href="{{ route('customer.reservations.index') }}" 
                                   class="flex items-center gap-3 px-4 py-3 text-gray-700 hover:bg-green-50 hover:text-green-600 transition-smooth">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                    </svg>
                                    My Reservations
                                </a>

                                <a href="{{ route('customer.cart') }}" 
                                   class="flex items-center gap-3 px-4 py-3 text-gray-700 hover:bg-green-50 hover:text-green-600 transition-smooth">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/>
                                    </svg>
                                    Shopping Cart
                                    @if($cartCount > 0)
                                        <span class="ml-auto px-2 py-1 bg-green-600 text-white text-xs font-bold rounded-full">{{ $cartCount }}</span>
                                    @endif
                                </a>
                            @endif

                            <a href="{{ route('profile.show') }}" 
                               class="flex items-center gap-3 px-4 py-3 text-gray-700 hover:bg-green-50 hover:text-green-600 transition-smooth">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                </svg>
                                Profile Settings
                            </a>

                            <div class="border-t border-gray-100 my-2"></div>

                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" 
                                        class="flex items-center gap-3 w-full px-4 py-3 text-left text-red-600 hover:bg-red-50 transition-smooth">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                                    </svg>
                                    Logout
                                </button>
                            </form>
                        </div>
                    </div>
                @else
                    <!-- Guest Actions -->
                    @if (Route::has('login'))
                        <a href="{{ route('login') }}" 
                           class="text-gray-700 hover:text-green-600 font-semibold transition-smooth px-4 py-2 rounded-lg hover:bg-green-50">
                            Login
                        </a>
                    @endif
                    @if (Route::has('register'))
                        <a href="{{ route('register') }}" 
                           class="bg-gradient-to-r from-green-600 to-green-700 text-white px-6 py-2.5 rounded-full font-semibold hover:from-green-700 hover:to-green-800 transition-smooth shadow-md hover:shadow-lg">
                            Register
                        </a>
                    @endif
                @endauth
            </div>

            <!-- Mobile Menu Button -->
            <div class="md:hidden flex items-center gap-3">
                <!-- Mobile Cart Icon -->
                @php
                    $cart = session()->get('cart', []);
                    $cartCount = array_sum(array_column($cart, 'quantity'));
                @endphp
                <a href="{{ Auth::check() && Auth::user()->role === 'customer' ? route('customer.cart') : route('login') }}" 
                   class="relative p-2 text-gray-700 hover:text-green-600 hover:bg-green-50 rounded-lg transition-smooth">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                    </svg>
                    @if($cartCount > 0)
                        <span class="absolute -top-1 -right-1 w-5 h-5 bg-gradient-to-r from-green-600 to-green-700 text-white text-xs font-bold rounded-full flex items-center justify-center shadow-lg">
                            {{ $cartCount > 9 ? '9+' : $cartCount }}
                        </span>
                    @endif
                </a>

                <button @click="mobileMenuOpen = !mobileMenuOpen" 
                        class="p-2 text-gray-700 hover:text-green-600 hover:bg-green-50 rounded-lg transition-smooth">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path x-show="!mobileMenuOpen" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path x-show="mobileMenuOpen" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>

        <!-- Mobile Menu -->
        <div x-show="mobileMenuOpen" 
             x-transition:enter="transition ease-out duration-200"
             x-transition:enter-start="opacity-0 transform -translate-y-2"
             x-transition:enter-end="opacity-100 transform translate-y-0"
             x-transition:leave="transition ease-in duration-150"
             x-transition:leave-start="opacity-100 transform translate-y-0"
             x-transition:leave-end="opacity-0 transform -translate-y-2"
             class="md:hidden border-t border-gray-200 bg-white"
             style="display: none;">
            <nav class="px-4 py-4 space-y-2">
                <a href="{{ route('home') }}" 
                   class="block px-4 py-3 rounded-lg text-gray-700 hover:text-green-600 hover:bg-green-50 font-medium transition-smooth {{ request()->routeIs('home') ? 'text-green-600 bg-green-50' : '' }}">
                    Home
                </a>
                <a href="{{ route('about') }}" 
                   class="block px-4 py-3 rounded-lg text-gray-700 hover:text-green-600 hover:bg-green-50 font-medium transition-smooth {{ request()->routeIs('about') ? 'text-green-600 bg-green-50' : '' }}">
                    About Us
                </a>
                <a href="{{ route('menu') }}" 
                   class="block px-4 py-3 rounded-lg text-gray-700 hover:text-green-600 hover:bg-green-50 font-medium transition-smooth {{ request()->routeIs('menu') || request()->routeIs('products.*') ? 'text-green-600 bg-green-50' : '' }}">
                    Menu
                </a>
                <a href="{{ route('testimonials') }}" 
                   class="block px-4 py-3 rounded-lg text-gray-700 hover:text-green-600 hover:bg-green-50 font-medium transition-smooth {{ request()->routeIs('testimonials') ? 'text-green-600 bg-green-50' : '' }}">
                    Testimonials
                </a>
                <a href="{{ route('reservation') }}" 
                   class="block px-4 py-3 rounded-lg text-gray-700 hover:text-green-600 hover:bg-green-50 font-medium transition-smooth {{ request()->routeIs('reservation') ? 'text-green-600 bg-green-50' : '' }}">
                    Reservation
                </a>
                <a href="{{ route('contact') }}" 
                   class="block px-4 py-3 rounded-lg text-gray-700 hover:text-green-600 hover:bg-green-50 font-medium transition-smooth {{ request()->routeIs('contact') ? 'text-green-600 bg-green-50' : '' }}">
                    Contact
                </a>

                <div class="border-t border-gray-200 my-2"></div>

                @auth
                    <a href="{{ route('dashboard') }}" 
                       class="flex items-center gap-3 px-4 py-3 rounded-lg text-gray-700 hover:text-green-600 hover:bg-green-50 font-medium transition-smooth">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                        </svg>
                        Dashboard
                    </a>

                    @if(Auth::user()->role === 'customer')
                        <a href="{{ route('customer.orders.index') }}" 
                           class="flex items-center gap-3 px-4 py-3 rounded-lg text-gray-700 hover:text-green-600 hover:bg-green-50 font-medium transition-smooth">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"/>
                            </svg>
                            My Orders
                        </a>

                        <a href="{{ route('customer.reservations.index') }}" 
                           class="flex items-center gap-3 px-4 py-3 rounded-lg text-gray-700 hover:text-green-600 hover:bg-green-50 font-medium transition-smooth">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                            </svg>
                            My Reservations
                        </a>
                    @endif

                    <a href="{{ route('profile.show') }}" 
                       class="flex items-center gap-3 px-4 py-3 rounded-lg text-gray-700 hover:text-green-600 hover:bg-green-50 font-medium transition-smooth">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                        </svg>
                        Profile Settings
                    </a>

                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" 
                                class="flex items-center gap-3 w-full text-left px-4 py-3 rounded-lg text-red-600 hover:bg-red-50 font-medium transition-smooth">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                            </svg>
                            Logout
                        </button>
                    </form>
                @else
                    @if (Route::has('login'))
                        <a href="{{ route('login') }}" 
                           class="block px-4 py-3 rounded-lg text-gray-700 hover:text-green-600 hover:bg-green-50 font-medium transition-smooth">
                            Login
                        </a>
                    @endif
                    @if (Route::has('register'))
                        <a href="{{ route('register') }}" 
                           class="block px-4 py-3 rounded-lg bg-gradient-to-r from-green-600 to-green-700 text-white font-semibold text-center hover:from-green-700 hover:to-green-800 transition-smooth">
                            Register
                        </a>
                    @endif
                @endauth
            </nav>
        </div>
    </div>
</header>
