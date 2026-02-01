<x-guest-layout>
    <x-authentication-card>
        <x-slot name="logo">
            <x-authentication-card-logo />
        </x-slot>

        <div class="mb-6">
            <h2 class="text-2xl font-bold text-gray-900">Confirm Password</h2>
            <p class="text-gray-600 mt-2 text-sm">
                {{ __('This is a secure area of the application. Please confirm your password before continuing.') }}
            </p>
        </div>

        <x-validation-errors class="mb-4" />

        <form method="POST" action="{{ route('password.confirm') }}">
            @csrf

            <div>
                <x-label for="password" value="{{ __('Password') }}" class="text-gray-700 font-semibold" />
                <x-input id="password" class="block mt-2 w-full rounded-lg border-gray-300 focus:border-green-500 focus:ring-green-500 transition-smooth" type="password" name="password" required autocomplete="current-password" autofocus />
                <x-input-error for="password" class="mt-2" />
            </div>

            <div class="mt-6">
                <button type="submit" class="w-full bg-gradient-to-r from-green-600 to-green-700 text-white px-6 py-3 rounded-lg hover:from-green-700 hover:to-green-800 transition-smooth font-semibold shadow-md hover:shadow-lg transform hover:scale-[1.02]">
                    {{ __('Confirm') }}
                </button>
            </div>
        </form>
    </x-authentication-card>
</x-guest-layout>
