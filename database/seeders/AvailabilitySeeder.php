<?php

namespace Database\Seeders;

use App\Models\Availability;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AvailabilitySeeder extends Seeder
{
    public function run(): void
    {
        // Clear existing availabilities to avoid duplicates
        DB::table('availabilities')->truncate();

        // Generate availabilities for the next 30 days
        $startDate = Carbon::now()->startOfDay();
        $endDate = $startDate->copy()->addDays(30);

        // Time slots: 9:00 AM to 9:00 PM
        $timeSlots = [
            '09:00:00',
            '10:00:00',
            '11:00:00',
            '12:00:00',
            '13:00:00',
            '14:00:00',
            '15:00:00',
            '16:00:00',
            '17:00:00',
            '18:00:00',
            '19:00:00',
            '20:00:00',
        ];

        for ($date = $startDate; $date->lte($endDate); $date->addDay()) {
            // Skip Friday (day 5 in Carbon)
            if ($date->dayOfWeek === 5) {
                continue;
            }

            foreach ($timeSlots as $index => $startTime) {
                // Calculate end time (1 hour later)
                $endTime = Carbon::parse($startTime)->addHour()->format('H:i:s');

                DB::table('availabilities')->insert([
                    'date' => $date->format('Y-m-d'),
                    'start_time' => $startTime,
                    'end_time' => $endTime,
                    'is_booked' => false,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }
    }
}
