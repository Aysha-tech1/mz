<?php

namespace App\Providers;

use App\Notifications\AdminResetPassword;
use Filament\Auth\Notifications\ResetPassword as FilamentResetPassword;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(FilamentResetPassword::class, function ($app, array $params) {
            $notification = new AdminResetPassword($params['token'] ?? '');
            $notification->url = $params['url'] ?? '';

            return $notification;
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
