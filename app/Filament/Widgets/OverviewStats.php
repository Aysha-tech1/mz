<?php

namespace App\Filament\Widgets;

use App\Filament\Resources\AvailabilityResource;
use App\Filament\Resources\BookingResource;
use App\Filament\Resources\DigitalProductResource;
use App\Models\Availability;
use App\Models\Booking;
use App\Models\DigitalProduct;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Illuminate\Support\Number;

class OverviewStats extends StatsOverviewWidget
{
    protected static bool $isLazy = false;

    protected static ?int $sort = 1;

    protected ?string $heading = 'نظرة سريعة';

    protected function getStats(): array
    {
        $todayBookings = Booking::query()->whereDate('date', today())->count();
        $pending = Booking::query()->where('status', 'pending')->count();
        $confirmedMonth = Booking::query()
            ->where('status', 'confirmed')
            ->whereMonth('date', now()->month)
            ->whereYear('date', now()->year)
            ->count();

        $confirmedRevenue = (float) Booking::query()
            ->where('status', 'confirmed')
            ->join('consultation_types', 'consultation_types.id', '=', 'bookings.consultation_type_id')
            ->sum('consultation_types.price');

        $openSlots = Availability::query()
            ->where('is_booked', false)
            ->whereBetween('date', [today()->toDateString(), today()->addDays(7)->toDateString()])
            ->count();

        $activeFiles = DigitalProduct::query()->where('is_active', true)->count();
        $comingSoon = DigitalProduct::query()->where('is_coming_soon', true)->count();
        $fileDownloads = (int) DigitalProduct::query()->sum('downloads_count');

        return [
            Stat::make('حجوزات اليوم', Number::format($todayBookings))
                ->description('حسب تاريخ الجلسة')
                ->descriptionIcon('heroicon-m-calendar-days')
                ->color($todayBookings > 0 ? 'warning' : 'gray')
                ->url(BookingResource::getUrl('index')),
            Stat::make('بانتظار التأكيد', Number::format($pending))
                ->description('تحتاج مراجعة')
                ->descriptionIcon('heroicon-m-clock')
                ->color($pending > 0 ? 'danger' : 'success')
                ->url(BookingResource::getUrl('index')),
            Stat::make('مؤكدة هذا الشهر', Number::format($confirmedMonth))
                ->description(number_format($confirmedRevenue, 3).' ر.ع. من المؤكد')
                ->descriptionIcon('heroicon-m-banknotes')
                ->color('success')
                ->url(BookingResource::getUrl('index')),
            Stat::make('مواعيد متاحة خلال 7 أيام', Number::format($openSlots))
                ->description('غير محجوزة')
                ->descriptionIcon('heroicon-m-check-circle')
                ->color('primary')
                ->url(AvailabilityResource::getUrl('index')),
            Stat::make('الملفات الظاهرة', Number::format($activeFiles))
                ->description($comingSoon.' قريبًا · '.Number::format($fileDownloads).' تنزيل')
                ->descriptionIcon('heroicon-m-document-text')
                ->color('warning')
                ->url(DigitalProductResource::getUrl('index')),
        ];
    }
}
