<?php

declare(strict_types=1);

namespace App\Providers;

use App\Models\User;
use App\Policies\UserPolicy;
use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Auth\Notifications\VerifyEmail;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        $this->configureUrlTemplate();
        $this->configurePolicies();
    }

    private function configureUrlTemplate(): void
    {
        VerifyEmail::createUrlUsing(function ($notifiable) {
            $url = URL::temporarySignedRoute(
                'verification.verify',
                now()->addMinutes(60), [
                    'id' => $notifiable->getKey(),
                    'hash' => sha1($notifiable->getEmailForVerification()),
                ]
            );

            return config('app.frontend_url').'/email-verification?url='.urlencode($url);
        });

        ResetPassword::createUrlUsing(
            fn ($user, string $token) => config('app.frontend_url').'/reset-password?email='.$user->email.'&token='.$token
        );
    }

    private function configurePolicies(): void
    {
        Gate::policy(User::class, UserPolicy::class);
    }
}
