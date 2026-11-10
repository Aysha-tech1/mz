<?php

namespace App\Providers;

use App\Notifications\AdminResetPassword;
use Filament\Auth\Notifications\ResetPassword as FilamentResetPassword;
use Illuminate\Support\Facades\URL;
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
        if (str_starts_with((string) config('app.url'), 'https://')) {
            URL::forceScheme('https');
        }

        config([
            'livewire.temporary_file_upload.rules' => ['required', 'file', 'max:30720'],
            'livewire.temporary_file_upload.max_upload_time' => 10,
        ]);
    }
}
