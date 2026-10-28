<?php

namespace App\Filament\Resources\FileSaleResource\Widgets;

use App\Models\DigitalProduct;
use App\Models\FileSale;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Illuminate\Support\Carbon;
use Illuminate\Support\Number;

class FileSaleStats extends StatsOverviewWidget
{
    protected static bool $isDiscovered = false;

    protected static bool $isLazy = false;

    protected ?string $pollingInterval = '10s';

    protected int | string | array $columnSpan = 'full';

    protected function getStats(): array
    {
        $clicks = FileSale::query()->count();
        $downloads = FileSale::query()->whereIn('type', ['download', 'sale'])->count();
        $emails = FileSale::query()
            ->whereNotNull('email')
            ->where('email', '!=', '')
            ->distinct()
            ->count('email');
        $files = DigitalProduct::query()->where('is_active', true)->count();
        $today = FileSale::query()->whereDate('created_at', today())->count();

        return [
            Stat::make('الضغطات', Number::format($clicks))
                ->description($today.' اليوم')
                ->descriptionIcon('heroicon-m-cursor-arrow-rays')
                ->chart($this->dailyCounts(7))
                ->color('warning'),
            Stat::make('التنزيلات', Number::format($downloads))
                ->description('ملفات وصلت للمستخدم')
                ->descriptionIcon('heroicon-m-arrow-down-tray')
                ->chart($this->dailyCounts(7, ['download', 'sale']))
                ->color('success'),
            Stat::make('الإيميلات', Number::format($emails))
                ->description('عناوين فريدة جُمعت')
                ->descriptionIcon('heroicon-m-envelope')
                ->color('primary'),
            Stat::make('الملفات الظاهرة', Number::format($files))
                ->description(DigitalProduct::query()->where('is_coming_soon', true)->count().' قريبًا')
                ->descriptionIcon('heroicon-m-document-duplicate')
                ->color('gray'),
        ];
    }

    /**
     * @param  array<int, string>|null  $types
     * @return array<int, int>
     */
    protected function dailyCounts(int $days, ?array $types = null): array
    {
        $from = Carbon::today()->subDays($days - 1);

        $query = FileSale::query()->whereDate('created_at', '>=', $from->toDateString());

        if ($types) {
            $query->whereIn('type', $types);
        }

        $counts = $query
            ->selectRaw('DATE(created_at) as day, COUNT(*) as total')
            ->groupBy('day')
            ->pluck('total', 'day');

        $data = [];

        for ($i = 0; $i < $days; $i++) {
            $key = $from->copy()->addDays($i)->toDateString();
            $data[] = (int) ($counts[$key] ?? 0);
        }

        return $data;
    }
}
