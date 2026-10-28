<?php

namespace App\Filament\Resources\FileSaleResource\Widgets;

use App\Models\FileSale;
use Filament\Widgets\ChartWidget;
use Illuminate\Support\Carbon;

class FileDownloadsChart extends ChartWidget
{
    protected static bool $isDiscovered = false;

    protected static bool $isLazy = false;

    protected ?string $heading = 'التنزيلات يوميًا';

    protected ?string $description = 'ضغطات وتنزيلات حسب اليوم';

    protected ?string $maxHeight = '220px';

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

        $clicks = FileSale::query()
            ->whereDate('created_at', '>=', $from->toDateString())
            ->selectRaw('DATE(created_at) as day, COUNT(*) as total')
            ->groupBy('day')
            ->pluck('total', 'day');

        $downloads = FileSale::query()
            ->whereDate('created_at', '>=', $from->toDateString())
            ->whereIn('type', ['download', 'sale'])
            ->selectRaw('DATE(created_at) as day, COUNT(*) as total')
            ->groupBy('day')
            ->pluck('total', 'day');

        $labels = [];
        $clickData = [];
        $downloadData = [];

        for ($i = 0; $i < $days; $i++) {
            $day = $from->copy()->addDays($i);
            $key = $day->toDateString();
            $labels[] = $day->translatedFormat('j M');
            $clickData[] = (int) ($clicks[$key] ?? 0);
            $downloadData[] = (int) ($downloads[$key] ?? 0);
        }

        return [
            'datasets' => [
                [
                    'label' => 'ضغطات',
                    'data' => $clickData,
                    'borderColor' => '#d97706',
                    'backgroundColor' => 'rgba(217, 119, 6, 0.16)',
                    'fill' => true,
                    'tension' => 0.35,
                ],
                [
                    'label' => 'تنزيلات',
                    'data' => $downloadData,
                    'borderColor' => '#111827',
                    'backgroundColor' => 'rgba(17, 24, 39, 0.08)',
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
