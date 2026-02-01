<x-guest-layout>
    <x-authentication-card>
        <x-slot name="logo">
            <x-authentication-card-logo />
        </x-slot>

        <div x-data="{ recovery: false }">
            <div class="mb-6">
                <h2 class="text-2xl font-bold text-gray-900">Two-Factor Authentication</h2>
                <p class="text-gray-600 mt-2 text-sm" x-show="! recovery">
                    {{ __('Please confirm access to your account by entering the authentication code provided by your authenticator application.') }}
                </p>
                <p class="text-gray-600 mt-2 text-sm" x-cloak x-show="recovery">
                    {{ __('Please confirm access to your account by entering one of your emergency recovery codes.') }}
                </p>
            </div>

            <x-validation-errors class="mb-4" />

            <form method="POST" action="{{ route('two-factor.login') }}">
                @csrf

                <div class="mt-4" x-show="! recovery">
                    <x-label for="code" value="{{ __('Code') }}" class="text-gray-700 font-semibold" />
                    <x-input id="code" class="block mt-2 w-full rounded-lg border-gray-300 focus:border-green-500 focus:ring-green-500 transition-smooth text-center text-2xl tracking-widest" type="text" inputmode="numeric" name="code" autofocus x-ref="code" autocomplete="one-time-code" />
                    <x-input-error for="code" class="mt-2" />
                </div>

                <div class="mt-4" x-cloak x-show="recovery">
                    <x-label for="recovery_code" value="{{ __('Recovery Code') }}" class="text-gray-700 font-semibold" />
                    <x-input id="recovery_code" class="block mt-2 w-full rounded-lg border-gray-300 focus:border-green-500 focus:ring-green-500 transition-smooth" type="text" name="recovery_code" x-ref="recovery_code" autocomplete="one-time-code" />
                    <x-input-error for="recovery_code" class="mt-2" />
                </div>

                <div class="mt-6">
                    <button type="submit" class="w-full bg-gradient-to-r from-green-600 to-green-700 text-white px-6 py-3 rounded-lg hover:from-green-700 hover:to-green-800 transition-smooth font-semibold shadow-md hover:shadow-lg transform hover:scale-[1.02]">
                        {{ __('Log in') }}
                    </button>
                </div>

                <div class="flex items-center justify-center mt-6">
                    <button type="button" class="text-sm text-green-600 hover:text-green-700 font-semibold transition-smooth"
                                    x-show="! recovery"
                                    x-on:click="
                                        recovery = true;
                                        $nextTick(() => { $refs.recovery_code.focus() })
                                    ">
                        {{ __('Use a recovery code') }}
                    </button>

                    <button type="button" class="text-sm text-green-600 hover:text-green-700 font-semibold transition-smooth"
                                    x-cloak
                                    x-show="recovery"
                                    x-on:click="
                                        recovery = false;
                                        $nextTick(() => { $refs.code.focus() })
                                    ">
                        {{ __('Use an authentication code') }}
                    </button>
                </div>
            </form>
        </div>
    </x-authentication-card>
</x-guest-layout>
