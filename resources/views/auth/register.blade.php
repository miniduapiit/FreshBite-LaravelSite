<x-guest-layout>
    <x-authentication-card>
        <x-slot name="logo">
            <x-authentication-card-logo />
        </x-slot>

        <div class="mb-6">
            <h2 class="text-2xl font-bold text-gray-900">Create Account</h2>
            <p class="text-gray-600 mt-1">Join FreshBite today and enjoy fresh meals</p>
        </div>

        <x-validation-errors class="mb-4" />

        <form method="POST" action="{{ route('register') }}">
            @csrf

            <div>
                <x-label for="name" value="{{ __('Name') }}" class="text-gray-700 font-semibold" />
                <x-input id="name" class="block mt-2 w-full rounded-lg border-gray-300 focus:border-green-500 focus:ring-green-500 transition-smooth" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" />
                <x-input-error for="name" class="mt-2" />
            </div>

            <div class="mt-4">
                <x-label for="email" value="{{ __('Email') }}" class="text-gray-700 font-semibold" />
                <x-input id="email" class="block mt-2 w-full rounded-lg border-gray-300 focus:border-green-500 focus:ring-green-500 transition-smooth" type="email" name="email" :value="old('email')" required autocomplete="username" />
                <x-input-error for="email" class="mt-2" />
            </div>

            <div class="mt-4">
                <x-label for="password" value="{{ __('Password') }}" class="text-gray-700 font-semibold" />
                <x-input id="password" class="block mt-2 w-full rounded-lg border-gray-300 focus:border-green-500 focus:ring-green-500 transition-smooth" type="password" name="password" required autocomplete="new-password" />
                <x-input-error for="password" class="mt-2" />
            </div>

            <div class="mt-4">
                <x-label for="password_confirmation" value="{{ __('Confirm Password') }}" class="text-gray-700 font-semibold" />
                <x-input id="password_confirmation" class="block mt-2 w-full rounded-lg border-gray-300 focus:border-green-500 focus:ring-green-500 transition-smooth" type="password" name="password_confirmation" required autocomplete="new-password" />
                <x-input-error for="password_confirmation" class="mt-2" />
            </div>

            @if (Laravel\Jetstream\Jetstream::hasTermsAndPrivacyPolicyFeature())
                <div class="mt-4">
                    <label for="terms" class="flex items-start cursor-pointer">
                        <x-checkbox name="terms" id="terms" required class="rounded border-gray-300 text-green-600 focus:ring-green-500 mt-1" />
                        <div class="ms-2 text-sm text-gray-600">
                            {!! __('I agree to the :terms_of_service and :privacy_policy', [
                                    'terms_of_service' => '<a target="_blank" href="'.route('terms.show').'" class="text-green-600 hover:text-green-700 font-semibold transition-smooth">'.__('Terms of Service').'</a>',
                                    'privacy_policy' => '<a target="_blank" href="'.route('policy.show').'" class="text-green-600 hover:text-green-700 font-semibold transition-smooth">'.__('Privacy Policy').'</a>',
                            ]) !!}
                        </div>
                    </label>
                </div>
            @endif

            <div class="mt-6">
                <button type="submit" class="w-full bg-gradient-to-r from-green-600 to-green-700 text-white px-6 py-3 rounded-lg hover:from-green-700 hover:to-green-800 transition-smooth font-semibold shadow-md hover:shadow-lg transform hover:scale-[1.02]">
                    {{ __('Register') }}
                </button>
            </div>

            <div class="mt-6 text-center">
                <span class="text-sm text-gray-600">Already have an account?</span>
                <a href="{{ route('login') }}" class="text-sm text-green-600 hover:text-green-700 font-semibold ml-1 transition-smooth">
                    {{ __('Sign in') }}
                </a>
            </div>
        </form>
    </x-authentication-card>
</x-guest-layout>
