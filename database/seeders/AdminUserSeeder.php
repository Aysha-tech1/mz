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

        if (User::query()->where('email', $email)->exists()) {
            $this->command?->info("حساب الأدمن موجود مسبقاً ({$email}) ولم تُغيَّر كلمة المرور.");

            return;
        }

        User::query()->create([
            'name' => 'محمود الدرعي',
            'email' => $email,
            'password' => Hash::make($password),
            'email_verified_at' => now(),
        ]);
    }
}
