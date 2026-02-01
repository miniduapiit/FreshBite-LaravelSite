<x-guest-layout>
    <x-authentication-card>
        <x-slot name="logo">
            <x-authentication-card-logo />
        </x-slot>

        <div class="mb-6">
            <h2 class="text-2xl font-bold text-gray-900">Verify Email Address</h2>
            <p class="text-gray-600 mt-2 text-sm">
                {{ __('Before continuing, could you verify your email address by clicking on the link we just emailed to you? If you didn\'t receive the email, we will gladly send you another.') }}
            </p>
        </div>

        @if (session('status') == 'verification-link-sent')
            <div class="mb-4 font-medium text-sm text-green-600 bg-green-50 border-l-4 border-green-500 rounded-lg p-4 flex items-start">
                <svg class="w-5 h-5 text-green-500 mr-3 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                <span>{{ __('A new verification link has been sent to the email address you provided in your profile settings.') }}</span>
            </div>
        @endif

        <div class="mt-6">
            <form method="POST" action="{{ route('verification.send') }}">
                @csrf

                <button type="submit" class="w-full bg-gradient-to-r from-green-600 to-green-700 text-white px-6 py-3 rounded-lg hover:from-green-700 hover:to-green-800 transition-smooth font-semibold shadow-md hover:shadow-lg transform hover:scale-[1.02]">
                    {{ __('Resend Verification Email') }}
                </button>
            </form>
        </div>

        <div class="mt-6 flex items-center justify-center gap-4 text-sm">
            <a href="{{ route('profile.show') }}" class="text-green-600 hover:text-green-700 font-semibold transition-smooth">
                {{ __('Edit Profile') }}
            </a>
            
            <span class="text-gray-400">|</span>

            <form method="POST" action="{{ route('logout') }}" class="inline">
                @csrf
                <button type="submit" class="text-green-600 hover:text-green-700 font-semibold transition-smooth">
                    {{ __('Log Out') }}
                </button>
            </form>
        </div>
    </x-authentication-card>
</x-guest-layout>
