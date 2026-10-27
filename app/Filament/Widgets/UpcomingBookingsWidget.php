<?php

namespace App\Filament\Widgets;

use App\Filament\Resources\BookingResource;
use App\Models\Booking;
use Filament\Actions\Action;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget;

class UpcomingBookingsWidget extends TableWidget
{
    protected static bool $isLazy = false;

    protected static ?int $sort = 5;

    protected int | string | array $columnSpan = 'full';

    public function table(Table $table): Table
    {
        return $table
            ->heading('الجلسات القادمة')
            ->description('حجوزات غير ملغاة من اليوم فصاعدًا')
            ->query(
                Booking::query()
                    ->with('consultationType')
                    ->where('status', '!=', 'cancelled')
                    ->whereDate('date', '>=', today())
                    ->orderBy('date')
                    ->orderBy('time')
            )
            ->columns([
                Tables\Columns\TextColumn::make('date')
                    ->label('التاريخ')
                    ->date()
                    ->sortable(),
                Tables\Columns\TextColumn::make('time')
                    ->label('الوقت'),
                Tables\Columns\TextColumn::make('name')
                    ->label('العميل'),
                Tables\Columns\TextColumn::make('phone')
                    ->label('الهاتف'),
                Tables\Columns\TextColumn::make('consultationType.title')
                    ->label('النوع')
                    ->placeholder('—'),
                Tables\Columns\TextColumn::make('status')
                    ->label('الحالة')
                    ->badge()
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        'pending' => 'قيد الانتظار',
                        'confirmed' => 'مؤكد',
                        default => $state,
                    })
                    ->color(fn (string $state): string => match ($state) {
                        'pending' => 'warning',
                        'confirmed' => 'success',
                        default => 'gray',
                    }),
            ])
            ->recordActions([
                Action::make('open')
                    ->label('فتح')
                    ->url(fn (Booking $record): string => BookingResource::getUrl('edit', ['record' => $record])),
            ])
            ->paginated([5, 10])
            ->defaultPaginationPageOption(5)
            ->emptyStateHeading('لا توجد جلسات قادمة')
            ->emptyStateDescription('عندما يصل حجز جديد سيظهر هنا.');
    }
}
