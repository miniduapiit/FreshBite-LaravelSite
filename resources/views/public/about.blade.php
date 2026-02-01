<x-guest-layout>
    <x-public-header />

    <!-- About Us Section -->
    <section class="bg-gradient-to-br from-green-50 via-white to-green-50 min-h-screen py-20">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Hero Section -->
            <div class="text-center mb-16 animate-fade-in-up">
                <h1 class="text-5xl lg:text-6xl font-extrabold mb-4">
                    About <span class="bg-gradient-to-r from-green-600 to-green-700 bg-clip-text text-transparent">FreshBite</span>
                </h1>
                <p class="text-xl text-gray-600 max-w-3xl mx-auto">
                    We're passionate about bringing you the freshest, most delicious food experience
                </p>
            </div>

            <!-- Story Section -->
            <div class="grid lg:grid-cols-2 gap-12 items-center mb-16">
                <div class="animate-fade-in-up">
                    <h2 class="text-3xl font-bold text-gray-900 mb-6">Our Story</h2>
                    <p class="text-gray-600 mb-4 leading-relaxed">
                        FreshBite was born from a simple idea: great food should be accessible, fresh, and made with love. 
                        Founded in 2024, we've been on a mission to revolutionize the food ordering experience.
                    </p>
                    <p class="text-gray-600 mb-4 leading-relaxed">
                        Our team of passionate chefs and food enthusiasts work tirelessly to ensure every meal 
                        meets our high standards of quality and taste. We source our ingredients from local 
                        suppliers whenever possible, supporting our community while delivering exceptional flavor.
                    </p>
                    <p class="text-gray-600 leading-relaxed">
                        Whether you're craving a juicy burger, fresh salads, or comfort food classics, 
                        FreshBite is here to satisfy your appetite with meals made just for you.
                    </p>
                </div>
                <div class="glass-effect rounded-2xl shadow-modern p-8 animate-slide-in-right card-hover">
                    <div class="aspect-square bg-gradient-to-br from-green-200 to-yellow-200 rounded-xl flex items-center justify-center">
                        <svg class="w-64 h-64 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                        </svg>
                    </div>
                </div>
            </div>

            <!-- Values Section -->
            <div class="mb-16">
                <h2 class="text-3xl lg:text-4xl font-extrabold bg-gradient-to-r from-green-600 to-green-700 bg-clip-text text-transparent mb-8 text-center">Our Values</h2>
                <div class="grid md:grid-cols-3 gap-8">
                    <div class="glass-effect rounded-2xl p-6 shadow-modern text-center card-hover">
                        <div class="w-16 h-16 bg-gradient-to-br from-green-100 to-green-200 rounded-full flex items-center justify-center mx-auto mb-4">
                            <svg class="w-8 h-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                        </div>
                        <h3 class="text-xl font-bold text-gray-900 mb-2">Quality First</h3>
                        <p class="text-gray-600">We never compromise on quality. Every ingredient is carefully selected and every dish is prepared with attention to detail.</p>
                    </div>
                    <div class="bg-white rounded-xl p-6 shadow-lg text-center">
                        <div class="w-16 h-16 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-4">
                            <svg class="w-8 h-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/>
                            </svg>
                        </div>
                        <h3 class="text-xl font-bold text-gray-900 mb-2">Made with Love</h3>
                        <p class="text-gray-600">Every meal is crafted with passion and care. We believe food is an expression of love and community.</p>
                    </div>
                    <div class="bg-white rounded-xl p-6 shadow-lg text-center">
                        <div class="w-16 h-16 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-4">
                            <svg class="w-8 h-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                        </div>
                        <h3 class="text-xl font-bold text-gray-900 mb-2">Fast & Fresh</h3>
                        <p class="text-gray-600">We understand your time is valuable. That's why we deliver fresh, delicious meals quickly without sacrificing quality.</p>
                    </div>
                </div>
            </div>

            <!-- CTA Section -->
            <div class="bg-green-600 rounded-2xl p-12 text-center text-white">
                <h2 class="text-3xl font-bold mb-4">Ready to Experience FreshBite?</h2>
                <p class="text-green-100 mb-6 text-lg">Browse our menu and place your first order today!</p>
                <a href="{{ route('menu') }}" class="inline-block bg-white text-green-600 px-8 py-3 rounded-full font-semibold hover:bg-gray-100 transition-colors">
                    View Menu
                </a>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <x-public-footer />

</x-guest-layout>
