<?php

namespace App\Providers;

use App\Actions\Fortify\CreateNewUser;
use App\Actions\Fortify\ResetUserPassword;
use App\Actions\Fortify\UpdateUserPassword;
use App\Actions\Fortify\UpdateUserProfileInformation;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Str;
use Laravel\Fortify\Contracts\LoginResponse;
use Laravel\Fortify\Contracts\RegisterResponse;
use Laravel\Fortify\Contracts\TwoFactorLoginResponse;
use Laravel\Fortify\Fortify;

class FortifyServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        // Custom registration response for role-based redirects
        $this->app->instance(RegisterResponse::class, new class implements RegisterResponse {
            public function toResponse($request)
            {
                $user = $request->user();
                
                // Redirect based on user role
                if ($user->hasRole('customer')) {
                    return redirect('/');
                } elseif ($user->hasRole('supplier')) {
                    return redirect('/vendor/products');
                } elseif ($user->hasRole('admin')) {
                    return redirect('/admin/dashboard');
                }
                
                return redirect('/');
            }
        });

        // Custom login response for role-based redirects
        $this->app->instance(LoginResponse::class, new class implements LoginResponse {
            public function toResponse($request)
            {
                $user = $request->user();
                
                // Redirect based on user role
                if ($user->hasRole('customer')) {
                    return redirect('/');
                } elseif ($user->hasRole('supplier')) {
                    return redirect('/vendor/products');
                } elseif ($user->hasRole('admin')) {
                    return redirect('/admin/dashboard');
                }
                
                return redirect('/');
            }
        });

        // Custom two-factor authentication response for role-based redirects
        $this->app->instance(TwoFactorLoginResponse::class, new class implements TwoFactorLoginResponse {
            public function toResponse($request)
            {
                $user = $request->user();
                
                // Redirect based on user role
                if ($user->hasRole('customer')) {
                    return redirect('/');
                } elseif ($user->hasRole('supplier')) {
                    return redirect('/vendor/products');
                } elseif ($user->hasRole('admin')) {
                    return redirect('/admin/dashboard');
                }
                
                return redirect('/');
            }
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Fortify::createUsersUsing(CreateNewUser::class);
        Fortify::updateUserProfileInformationUsing(UpdateUserProfileInformation::class);
        Fortify::updateUserPasswordsUsing(UpdateUserPassword::class);
        Fortify::resetUserPasswordsUsing(ResetUserPassword::class);

        RateLimiter::for('login', function (Request $request) {
            $throttleKey = Str::transliterate(Str::lower($request->input(Fortify::username())).'|'.$request->ip());

            return Limit::perMinute(5)->by($throttleKey);
        });

        RateLimiter::for('two-factor', function (Request $request) {
            return Limit::perMinute(5)->by($request->session()->get('login.id'));
        });
    }
}
