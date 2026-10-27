<?php

namespace App\Filament\Widgets;

use App\Models\Booking;
use Filament\Widgets\ChartWidget;

class BookingStatusChart extends ChartWidget
{
    protected static bool $isLazy = false;

    protected static ?int $sort = 3;

    protected ?string $heading = 'حالة الحجوزات';

    protected ?string $description = 'توزيع الطلبات الحالية';

    protected ?string $maxHeight = '280px';

    protected int | string | array $columnSpan = [
        'md' => 2,
        'xl' => 1,
    ];

    protected function getData(): array
    {
        $pending = Booking::query()->where('status', 'pending')->count();
        $confirmed = Booking::query()->where('status', 'confirmed')->count();
        $cancelled = Booking::query()->where('status', 'cancelled')->count();

        return [
            'datasets' => [
                [
                    'data' => [$pending, $confirmed, $cancelled],
                    'backgroundColor' => ['#f59e0b', '#22c55e', '#ef4444'],
                    'borderWidth' => 0,
                ],
            ],
            'labels' => ['قيد الانتظار', 'مؤكد', 'ملغي'],
        ];
    }

    protected function getType(): string
    {
        return 'doughnut';
    }
}
