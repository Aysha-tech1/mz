<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    public function run(): void
    {
        $email = config('admin.email');
        $password = config('admin.password');

        if (! is_string($email) || $email === '' || ! is_string($password) || $password === '') {
            $this->command?->warn('تخطي إنشاء الأدمن: عيّن ADMIN_EMAIL و ADMIN_PASSWORD في ملف .env');

            return;
        }

        User::query()->where('email', 'admin@example.com')->delete();

        User::query()->updateOrCreate(
            ['email' => $email],
            [
                'name' => 'محمود الدرعي',
                'password' => Hash::make($password),
                'email_verified_at' => now(),
            ]
        );

        $this->command?->info("تم ضبط حساب الأدمن: {$email}");
    }
}
