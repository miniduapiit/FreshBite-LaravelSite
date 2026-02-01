<x-guest-layout>
    <x-public-header />

    <!-- Hero Banner Section -->
    <section class="relative min-h-screen bg-gradient-to-br from-green-50 via-white to-green-50 overflow-hidden">
        <!-- Background Decorative Elements -->
        <div class="absolute top-20 right-10 w-72 h-72 bg-green-200 rounded-full mix-blend-multiply filter blur-3xl opacity-30 animate-blob"></div>
        <div class="absolute top-40 left-10 w-72 h-72 bg-yellow-200 rounded-full mix-blend-multiply filter blur-3xl opacity-30 animate-blob animation-delay-2000"></div>
        <div class="absolute bottom-20 right-1/4 w-72 h-72 bg-green-300 rounded-full mix-blend-multiply filter blur-3xl opacity-30 animate-blob animation-delay-4000"></div>
        
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12 lg:py-20 relative z-10">
            <div class="grid lg:grid-cols-2 gap-8 lg:gap-12 items-center">
                <!-- Left Content -->
                <div class="relative z-10 animate-fade-in-up">
                    <!-- Headline -->
                    <h1 class="text-5xl lg:text-6xl xl:text-7xl font-extrabold mb-6 leading-tight">
                        <span class="bg-gradient-to-r from-green-600 to-green-700 bg-clip-text text-transparent">Burgers</span>
                        <span class="text-gray-900"> Made Better Every Day</span>
                    </h1>

                    <!-- Small Burger Icon -->
                    <div class="mb-6">
                        <svg class="w-20 h-20 text-yellow-500" viewBox="0 0 100 100" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <!-- Bun Top -->
                            <ellipse cx="50" cy="30" rx="35" ry="10" fill="#F4D03F"/>
                            <!-- Patty -->
                            <ellipse cx="50" cy="50" rx="32" ry="8" fill="#8B4513"/>
                            <!-- Lettuce -->
                            <path d="M20 45 Q35 40 50 45 Q65 40 80 45" stroke="#27AE60" stroke-width="3" fill="none"/>
                            <!-- Bun Bottom -->
                            <ellipse cx="50" cy="70" rx="35" ry="12" fill="#F4D03F"/>
                                    </svg>
                    </div>

                    <!-- Description Text -->
                    <p class="text-lg text-gray-600 mb-8 leading-relaxed">
                        Explore tasty recipes, fresh ingredients,<br>
                        And cooking inspiration for everyone
                    </p>

                    <!-- CTA Buttons -->
                    <div class="flex items-center gap-6">
                        <a href="{{ route('products.index') }}" class="bg-gradient-to-r from-gray-900 to-gray-800 text-white px-8 py-4 rounded-full font-semibold hover:from-gray-800 hover:to-gray-700 transition-smooth shadow-xl hover:shadow-2xl transform hover:scale-105">
                            Grab Your Order
                        </a>
                        <!-- Play Button -->
                        <button class="w-14 h-14 bg-gradient-to-r from-green-600 to-green-700 rounded-full flex items-center justify-center hover:from-green-700 hover:to-green-800 transition-smooth shadow-lg hover:shadow-xl transform hover:scale-110">
                            <svg class="w-6 h-6 text-white ml-1" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M8 5v14l11-7z"/>
                            </svg>
                        </button>
                    </div>
                </div>

                <!-- Right Content - Burger Image -->
                <div class="relative lg:mt-0 mt-8 animate-slide-in-right">
                    <!-- Main Burger Image Container -->
                    <div class="relative">
                        <!-- Placeholder for burger image - replace with actual image -->
                        <div class="relative bg-white rounded-3xl shadow-2xl p-6 transform hover:rotate-3 transition-smooth">
                            <div class="aspect-square bg-gradient-to-br from-yellow-100 to-orange-100 rounded-2xl flex items-center justify-center overflow-hidden">
                                <!-- Burger SVG Placeholder -->
                                <svg class="w-full h-full" viewBox="0 0 400 400" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <!-- Bun Top -->
                                    <ellipse cx="200" cy="120" rx="140" ry="40" fill="#F4D03F"/>
                                    <ellipse cx="200" cy="100" rx="140" ry="40" fill="#F7DC6F"/>
                                    
                                    <!-- Lettuce -->
                                    <path d="M100 160 Q150 140 200 160 Q250 140 300 160" stroke="#27AE60" stroke-width="8" fill="none" stroke-linecap="round"/>
                                    <path d="M100 170 Q150 150 200 170 Q250 150 300 170" stroke="#27AE60" stroke-width="6" fill="none" stroke-linecap="round"/>
                                    
                                    <!-- Patty -->
                                    <ellipse cx="200" cy="200" rx="130" ry="30" fill="#8B4513"/>
                                    <ellipse cx="200" cy="195" rx="130" ry="30" fill="#A0522D"/>
                                    
                                    <!-- Tomato -->
                                    <ellipse cx="200" cy="230" rx="120" ry="25" fill="#E74C3C"/>
                                    
                                    <!-- Bun Bottom -->
                                    <ellipse cx="200" cy="280" rx="140" ry="50" fill="#F4D03F"/>
                                    <ellipse cx="200" cy="300" rx="140" ry="40" fill="#F7DC6F"/>
                                    
                                    <!-- Sesame Seeds -->
                                    <circle cx="150" cy="100" r="4" fill="#FFF8DC"/>
                                    <circle cx="200" cy="95" r="4" fill="#FFF8DC"/>
                                    <circle cx="250" cy="100" r="4" fill="#FFF8DC"/>
                                    <circle cx="170" cy="110" r="3" fill="#FFF8DC"/>
                                    <circle cx="230" cy="110" r="3" fill="#FFF8DC"/>
                                </svg>
                            </div>
                        </div>

                        <!-- Fries Container with HOT DEAL Tag -->
                        <div class="absolute -bottom-8 -right-8 bg-gradient-to-br from-red-500 to-red-600 rounded-2xl p-6 shadow-2xl transform -rotate-6 hover:rotate-0 transition-smooth">
                            <div class="bg-gradient-to-br from-yellow-300 to-yellow-400 rounded-xl p-4">
                                <!-- Fries SVG -->
                                <svg class="w-24 h-24" viewBox="0 0 100 100" fill="none">
                                    <rect x="20" y="10" width="8" height="60" rx="2" fill="#FFD700"/>
                                    <rect x="35" y="10" width="8" height="60" rx="2" fill="#FFD700"/>
                                    <rect x="50" y="10" width="8" height="60" rx="2" fill="#FFD700"/>
                                    <rect x="65" y="10" width="8" height="60" rx="2" fill="#FFD700"/>
                                </svg>
                            </div>
                            <!-- HOT DEAL Tag -->
                            <div class="absolute -top-3 -left-3 bg-red-600 text-white px-3 py-1 rounded-full text-xs font-bold shadow-lg">
                                HOT DEAL
                            </div>
                            <p class="text-white text-xs mt-2 font-semibold text-center">grab your burger now</p>
                        </div>

                        <!-- 50% OFF Badge -->
                        <div class="absolute -top-6 -right-6 bg-gradient-to-br from-green-600 to-green-700 text-white w-24 h-24 rounded-full flex flex-col items-center justify-center shadow-2xl z-20 animate-pulse">
                            <span class="text-2xl font-bold">50%</span>
                            <span class="text-xs font-semibold">OFF</span>
                        </div>

                        <!-- Customer Rating Badge -->
                        <div class="absolute top-8 left-8 glass-effect rounded-2xl p-4 shadow-xl hover:shadow-2xl transition-smooth">
                            <div class="flex items-center gap-2 mb-2">
                                <div class="flex items-center">
                                    <svg class="w-5 h-5 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                    </svg>
                                    <span class="text-sm font-bold text-gray-900 ml-1">4.6</span>
                                </div>
                            </div>
                            <p class="text-xs text-gray-600 font-medium">50+ Happy Customer</p>
                            <!-- Profile Icons -->
                            <div class="flex -space-x-2 mt-2">
                                <div class="w-6 h-6 bg-blue-400 rounded-full border-2 border-white"></div>
                                <div class="w-6 h-6 bg-purple-400 rounded-full border-2 border-white"></div>
                                <div class="w-6 h-6 bg-pink-400 rounded-full border-2 border-white"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Bottom Section with Salad and Cards -->
            <div class="grid md:grid-cols-3 gap-6 mt-16 lg:mt-24">
                <!-- Salad Bowl -->
                <div class="flex items-center justify-center md:justify-start">
                    <div class="relative">
                        <div class="w-32 h-32 bg-gradient-to-br from-green-200 to-green-300 rounded-full flex items-center justify-center shadow-lg">
                            <!-- Salad Bowl SVG -->
                            <svg class="w-24 h-24" viewBox="0 0 100 100" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <!-- Bowl -->
                                <ellipse cx="50" cy="70" rx="35" ry="15" fill="#8B7355"/>
                                <ellipse cx="50" cy="65" rx="35" ry="15" fill="#A0826D"/>
                                <!-- Salad Items -->
                                <circle cx="35" cy="50" r="6" fill="#27AE60"/>
                                <circle cx="50" cy="45" r="5" fill="#F39C12"/>
                                <circle cx="65" cy="50" r="5" fill="#E74C3C"/>
                                <circle cx="45" cy="60" r="4" fill="#F39C12"/>
                                <circle cx="60" cy="58" r="4" fill="#27AE60"/>
                    </svg>
                        </div>
                        <!-- Chili Pepper -->
                        <div class="absolute -bottom-2 -right-2 w-6 h-10 bg-gradient-to-b from-red-500 to-red-600 rounded-full transform rotate-12 shadow-md">
                            <div class="w-2 h-2 bg-green-500 rounded-full absolute top-1 left-1/2 transform -translate-x-1/2"></div>
                        </div>
                    </div>
                </div>

                <!-- Feature Cards -->
                <div class="space-y-4">
                    <!-- From Sourced Meat Card -->
                    <div class="glass-effect rounded-2xl p-6 shadow-modern hover:shadow-2xl transition-smooth card-hover">
                        <div class="flex items-start gap-4">
                            <div class="w-12 h-12 bg-gradient-to-br from-green-100 to-green-200 rounded-xl flex items-center justify-center">
                                <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4"/>
                    </svg>
                            </div>
                            <div>
                                <h3 class="font-bold text-gray-900 mb-1">From Sourced Meat</h3>
                                <p class="text-sm text-gray-600">Premium quality ingredients</p>
                            </div>
                        </div>
                    </div>

                    <!-- Freshly Row Papered Card -->
                    <div class="glass-effect rounded-2xl p-6 shadow-modern hover:shadow-2xl transition-smooth card-hover">
                        <div class="flex items-start gap-4">
                            <div class="w-12 h-12 bg-gradient-to-br from-green-100 to-green-200 rounded-xl flex items-center justify-center">
                                <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                            </div>
                            <div>
                                <h3 class="font-bold text-gray-900 mb-1">Freshly Prepared</h3>
                                <p class="text-sm text-gray-600">Made fresh daily for you</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <x-public-footer />

</x-guest-layout>
