<x-guest-layout>
    <x-authentication-card>
        <x-slot name="logo">
            <x-authentication-card-logo />
        </x-slot>

        <div class="mb-6">
            <h2 class="text-2xl font-bold text-gray-900">Forgot Password?</h2>
            <p class="text-gray-600 mt-2 text-sm">
                {{ __('No problem. Just let us know your email address and we will email you a password reset link that will allow you to choose a new one.') }}
            </p>
        </div>

        @session('status')
            <div class="mb-4 font-medium text-sm text-green-600 bg-green-50 border border-green-200 rounded-lg p-3">
                {{ $value }}
            </div>
        @endsession

        <x-validation-errors class="mb-4" />

        <form method="POST" action="{{ route('password.email') }}">
            @csrf

            <div class="block">
                <x-label for="email" value="{{ __('Email') }}" class="text-gray-700 font-semibold" />
                <x-input id="email" class="block mt-2 w-full rounded-lg border-gray-300 focus:border-green-500 focus:ring-green-500 transition-smooth" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" />
                <x-input-error for="email" class="mt-2" />
            </div>

            <div class="mt-6">
                <button type="submit" class="w-full bg-gradient-to-r from-green-600 to-green-700 text-white px-6 py-3 rounded-lg hover:from-green-700 hover:to-green-800 transition-smooth font-semibold shadow-md hover:shadow-lg transform hover:scale-[1.02]">
                    {{ __('Email Password Reset Link') }}
                </button>
            </div>

            <div class="mt-6 text-center">
                <a href="{{ route('login') }}" class="text-sm text-green-600 hover:text-green-700 font-semibold transition-smooth">
                    {{ __('Back to login') }}
                </a>
            </div>
        </form>
    </x-authentication-card>
</x-guest-layout>
