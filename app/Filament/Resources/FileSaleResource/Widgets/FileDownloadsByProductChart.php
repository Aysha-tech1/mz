<?php

namespace App\Filament\Resources\FileSaleResource\Widgets;

use App\Models\DigitalProduct;
use Filament\Widgets\ChartWidget;

class FileDownloadsByProductChart extends ChartWidget
{
    protected static bool $isDiscovered = false;

    protected static bool $isLazy = false;

    protected ?string $heading = 'حسب الملف';

    protected ?string $description = 'عدد التنزيلات لكل ملف';

    protected ?string $maxHeight = '220px';

    protected int | string | array $columnSpan = [
        'md' => 2,
        'xl' => 1,
    ];

    protected function getData(): array
    {
        $products = DigitalProduct::query()
            ->withCount('sales')
            ->orderByDesc('sales_count')
            ->orderBy('step_number')
            ->get(['id', 'title']);

        $labels = $products->map(function (DigitalProduct $product): string {
            $title = $product->title ?: 'ملف';

            return mb_strlen($title) > 18 ? mb_substr($title, 0, 18).'…' : $title;
        })->all();

        return [
            'datasets' => [
                [
                    'label' => 'تنزيلات',
                    'data' => $products->pluck('sales_count')->map(fn ($count) => (int) $count)->all(),
                    'backgroundColor' => '#f59e0b',
                    'borderRadius' => 8,
                    'maxBarThickness' => 28,
                ],
            ],
            'labels' => $labels,
        ];
    }

    protected function getType(): string
    {
        return 'bar';
    }

    protected function getOptions(): array
    {
        return [
            'indexAxis' => 'y',
            'plugins' => [
                'legend' => [
                    'display' => false,
                ],
            ],
            'scales' => [
                'x' => [
                    'beginAtZero' => true,
                    'ticks' => [
                        'precision' => 0,
                    ],
                ],
            ],
        ];
    }
}
