<?php

namespace Database\Seeders;

use App\Models\Booking;
use App\Models\ConsultationType;
use Illuminate\Database\Seeder;

class BookingSeeder extends Seeder
{
    public function run(): void
    {
        $consultationType = ConsultationType::first();

        if ($consultationType) {
            Booking::create([
                'consultation_type_id' => $consultationType->id,
                'name' => 'أحمد المعمري',
                'email' => 'ahmed@example.com',
                'phone' => '968 91234567',
                'topic' => 'أريد استشارة حول اختيار منصة للتجارة الإلكترونية',
                'date' => now()->addDays(2)->format('Y-m-d'),
                'time' => '10:00:00',
                'status' => 'pending',
            ]);

            Booking::create([
                'consultation_type_id' => $consultationType->id,
                'name' => 'سالم العبري',
                'email' => 'salem@example.com',
                'phone' => '968 98765432',
                'topic' => 'أحتاج مساعدة في إعداد متجر إلكتروني',
                'date' => now()->addDays(3)->format('Y-m-d'),
                'time' => '14:00:00',
                'status' => 'confirmed',
            ]);
        }
    }
}
