<x-guest-layout>
    <x-public-header />

    <!-- Testimonials Section -->
    <section class="bg-gradient-to-br from-green-50 via-yellow-50 to-green-100 min-h-screen py-20">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Hero Section -->
            <div class="text-center mb-16">
                <h1 class="text-5xl lg:text-6xl font-bold text-gray-900 mb-4">
                    What Our <span class="text-green-600">Customers</span> Say
                </h1>
                <p class="text-xl text-gray-600 max-w-3xl mx-auto">
                    Don't just take our word for it - hear from our satisfied customers
                </p>
            </div>

            <!-- Testimonials Grid -->
            <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8 mb-16">
                <!-- Testimonial 1 -->
                <div class="bg-white rounded-2xl p-6 shadow-lg">
                    <div class="flex items-center mb-4">
                        <div class="flex text-yellow-400">
                            @for($i = 0; $i < 5; $i++)
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                </svg>
                            @endfor
                        </div>
                    </div>
                    <p class="text-gray-600 mb-4 italic">
                        "FreshBite has completely changed my lunch routine! The burgers are always fresh, 
                        the fries are perfectly crispy, and the delivery is lightning fast. Highly recommend!"
                    </p>
                    <div class="flex items-center">
                        <div class="w-12 h-12 bg-green-200 rounded-full flex items-center justify-center mr-3">
                            <span class="text-green-600 font-bold">JS</span>
                        </div>
                        <div>
                            <p class="font-semibold text-gray-900">John Smith</p>
                            <p class="text-sm text-gray-500">Regular Customer</p>
                        </div>
                    </div>
                </div>

                <!-- Testimonial 2 -->
                <div class="bg-white rounded-2xl p-6 shadow-lg">
                    <div class="flex items-center mb-4">
                        <div class="flex text-yellow-400">
                            @for($i = 0; $i < 5; $i++)
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                </svg>
                            @endfor
                        </div>
                    </div>
                    <p class="text-gray-600 mb-4 italic">
                        "As a busy professional, I love how easy it is to order from FreshBite. 
                        The food quality is consistently excellent, and I appreciate their commitment to using fresh ingredients."
                    </p>
                    <div class="flex items-center">
                        <div class="w-12 h-12 bg-blue-200 rounded-full flex items-center justify-center mr-3">
                            <span class="text-blue-600 font-bold">MJ</span>
                        </div>
                        <div>
                            <p class="font-semibold text-gray-900">Maria Johnson</p>
                            <p class="text-sm text-gray-500">Business Professional</p>
                        </div>
                    </div>
                </div>

                <!-- Testimonial 3 -->
                <div class="bg-white rounded-2xl p-6 shadow-lg">
                    <div class="flex items-center mb-4">
                        <div class="flex text-yellow-400">
                            @for($i = 0; $i < 5; $i++)
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                </svg>
                            @endfor
                        </div>
                    </div>
                    <p class="text-gray-600 mb-4 italic">
                        "The best food ordering experience I've had! The app is user-friendly, 
                        the food arrives hot and fresh, and the customer service is outstanding."
                    </p>
                    <div class="flex items-center">
                        <div class="w-12 h-12 bg-purple-200 rounded-full flex items-center justify-center mr-3">
                            <span class="text-purple-600 font-bold">DW</span>
                        </div>
                        <div>
                            <p class="font-semibold text-gray-900">David Williams</p>
                            <p class="text-sm text-gray-500">Food Enthusiast</p>
                        </div>
                    </div>
                </div>

                <!-- Testimonial 4 -->
                <div class="bg-white rounded-2xl p-6 shadow-lg">
                    <div class="flex items-center mb-4">
                        <div class="flex text-yellow-400">
                            @for($i = 0; $i < 5; $i++)
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                </svg>
                            @endfor
                        </div>
                    </div>
                    <p class="text-gray-600 mb-4 italic">
                        "I've tried many food delivery services, but FreshBite stands out. 
                        The quality is unmatched, and I love supporting a local business that cares about their customers."
                    </p>
                    <div class="flex items-center">
                        <div class="w-12 h-12 bg-pink-200 rounded-full flex items-center justify-center mr-3">
                            <span class="text-pink-600 font-bold">SB</span>
                        </div>
                        <div>
                            <p class="font-semibold text-gray-900">Sarah Brown</p>
                            <p class="text-sm text-gray-500">Local Resident</p>
                        </div>
                    </div>
                </div>

                <!-- Testimonial 5 -->
                <div class="bg-white rounded-2xl p-6 shadow-lg">
                    <div class="flex items-center mb-4">
                        <div class="flex text-yellow-400">
                            @for($i = 0; $i < 5; $i++)
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                </svg>
                            @endfor
                        </div>
                    </div>
                    <p class="text-gray-600 mb-4 italic">
                        "The variety of options is amazing, and everything I've tried has been delicious. 
                        FreshBite has become my go-to for quick, quality meals!"
                    </p>
                    <div class="flex items-center">
                        <div class="w-12 h-12 bg-yellow-200 rounded-full flex items-center justify-center mr-3">
                            <span class="text-yellow-600 font-bold">RT</span>
                        </div>
                        <div>
                            <p class="font-semibold text-gray-900">Robert Taylor</p>
                            <p class="text-sm text-gray-500">Frequent Customer</p>
                        </div>
                    </div>
                </div>

                <!-- Testimonial 6 -->
                <div class="bg-white rounded-2xl p-6 shadow-lg">
                    <div class="flex items-center mb-4">
                        <div class="flex text-yellow-400">
                            @for($i = 0; $i < 5; $i++)
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                </svg>
                            @endfor
                        </div>
                    </div>
                    <p class="text-gray-600 mb-4 italic">
                        "Outstanding service and even better food! The team at FreshBite really knows 
                        how to deliver a great experience from order to delivery."
                    </p>
                    <div class="flex items-center">
                        <div class="w-12 h-12 bg-indigo-200 rounded-full flex items-center justify-center mr-3">
                            <span class="text-indigo-600 font-bold">LM</span>
                        </div>
                        <div>
                            <p class="font-semibold text-gray-900">Lisa Martinez</p>
                            <p class="text-sm text-gray-500">Happy Customer</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- CTA Section -->
            <div class="bg-green-600 rounded-2xl p-12 text-center text-white">
                <h2 class="text-3xl font-bold mb-4">Join Our Happy Customers!</h2>
                <p class="text-green-100 mb-6 text-lg">Experience the FreshBite difference today</p>
                <a href="{{ route('menu') }}" class="inline-block bg-white text-green-600 px-8 py-3 rounded-full font-semibold hover:bg-gray-100 transition-colors">
                    Order Now
                </a>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <x-public-footer />

</x-guest-layout>
