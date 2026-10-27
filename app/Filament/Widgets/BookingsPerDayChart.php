<?php

namespace App\Filament\Widgets;

use App\Models\Booking;
use Filament\Widgets\ChartWidget;
use Illuminate\Support\Carbon;

class BookingsPerDayChart extends ChartWidget
{
    protected static bool $isLazy = false;

    protected static ?int $sort = 2;

    protected ?string $heading = 'الحجوزات الجديدة';

    protected ?string $description = 'عدد الطلبات حسب يوم الإنشاء';

    protected ?string $maxHeight = '280px';

    protected int | string | array $columnSpan = [
        'md' => 2,
        'xl' => 2,
    ];

    public ?string $filter = '14';

    protected function getFilters(): ?array
    {
        return [
            '7' => 'آخر 7 أيام',
            '14' => 'آخر 14 يوم',
            '30' => 'آخر 30 يوم',
        ];
    }

    protected function getData(): array
    {
        $days = (int) ($this->filter ?: 14);
        $from = Carbon::today()->subDays($days - 1);

        $counts = Booking::query()
            ->whereDate('created_at', '>=', $from->toDateString())
            ->selectRaw('DATE(created_at) as day, COUNT(*) as total')
            ->groupBy('day')
            ->pluck('total', 'day');

        $labels = [];
        $data = [];

        for ($i = 0; $i < $days; $i++) {
            $day = $from->copy()->addDays($i);
            $key = $day->toDateString();
            $labels[] = $day->translatedFormat('j M');
            $data[] = (int) ($counts[$key] ?? 0);
        }

        return [
            'datasets' => [
                [
                    'label' => 'حجوزات',
                    'data' => $data,
                    'borderColor' => '#f59e0b',
                    'backgroundColor' => 'rgba(245, 158, 11, 0.18)',
                    'fill' => true,
                    'tension' => 0.35,
                ],
            ],
            'labels' => $labels,
        ];
    }

    protected function getType(): string
    {
        return 'line';
    }
}
