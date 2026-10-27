<?php

namespace Database\Seeders;

use App\Models\ConsultationType;
use Illuminate\Database\Seeder;

class ConsultationTypeSeeder extends Seeder
{
    public function run(): void
    {
        ConsultationType::updateOrCreate(
            ['title' => 'استشارة نصف ساعة'],
            [
                'duration' => 30,
                'price' => 15.000,
                'is_active' => true,
            ]
        );

        ConsultationType::updateOrCreate(
            ['title' => 'استشارة ساعة كاملة'],
            [
                'duration' => 60,
                'price' => 25.000,
                'is_active' => true,
            ]
        );

        ConsultationType::updateOrCreate(
            ['title' => 'استشارة ساعة ونصف'],
            [
                'duration' => 90,
                'price' => 35.000,
                'is_active' => true,
            ]
        );
    }
}
