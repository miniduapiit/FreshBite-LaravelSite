<x-guest-layout>
    <x-authentication-card>
        <x-slot name="logo">
            <x-authentication-card-logo />
        </x-slot>

        <div class="mb-6">
            <h2 class="text-2xl font-bold text-gray-900">Welcome Back!</h2>
            <p class="text-gray-600 mt-1">Sign in to your account to continue</p>
        </div>

        <x-validation-errors class="mb-4" />

        @session('status')
            <div class="mb-4 font-medium text-sm text-green-600 bg-green-50 border border-green-200 rounded-lg p-3">
                {{ $value }}
            </div>
        @endsession

        <form method="POST" action="{{ route('login') }}">
            @csrf

            <div>
                <x-label for="email" value="{{ __('Email') }}" class="text-gray-700 font-semibold" />
                <x-input id="email" class="block mt-2 w-full rounded-lg border-gray-300 focus:border-green-500 focus:ring-green-500 transition-smooth" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" />
                <x-input-error for="email" class="mt-2" />
            </div>

            <div class="mt-4">
                <x-label for="password" value="{{ __('Password') }}" class="text-gray-700 font-semibold" />
                <x-input id="password" class="block mt-2 w-full rounded-lg border-gray-300 focus:border-green-500 focus:ring-green-500 transition-smooth" type="password" name="password" required autocomplete="current-password" />
                <x-input-error for="password" class="mt-2" />
            </div>

            <div class="flex items-center justify-between mt-4">
                <label for="remember_me" class="flex items-center cursor-pointer">
                    <x-checkbox id="remember_me" name="remember" class="rounded border-gray-300 text-green-600 focus:ring-green-500" />
                    <span class="ms-2 text-sm text-gray-600 font-medium">{{ __('Remember me') }}</span>
                </label>

                @if (Route::has('password.request'))
                    <a class="text-sm text-green-600 hover:text-green-700 font-semibold transition-smooth" href="{{ route('password.request') }}">
                        {{ __('Forgot password?') }}
                    </a>
                @endif
            </div>

            <div class="mt-6">
                <button type="submit" class="w-full bg-gradient-to-r from-green-600 to-green-700 text-white px-6 py-3 rounded-lg hover:from-green-700 hover:to-green-800 transition-smooth font-semibold shadow-md hover:shadow-lg transform hover:scale-[1.02]">
                    {{ __('Log in') }}
                </button>
            </div>

            @if (Route::has('register'))
                <div class="mt-6 text-center">
                    <span class="text-sm text-gray-600">Don't have an account?</span>
                    <a href="{{ route('register') }}" class="text-sm text-green-600 hover:text-green-700 font-semibold ml-1 transition-smooth">
                        {{ __('Sign up') }}
                    </a>
                </div>
            @endif
        </form>
    </x-authentication-card>
</x-guest-layout>
