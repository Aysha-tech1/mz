<?php

namespace App\Filament\Widgets;

use App\Models\Payment;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget;

class PaidFilePaymentsWidget extends TableWidget
{
    protected static bool $isLazy = false;

    protected static ?int $sort = 2;

    protected int | string | array $columnSpan = 'full';

    public function table(Table $table): Table
    {
        $total = (float) Payment::query()
            ->where('status', Payment::STATUS_PAID)
            ->sum('amount');

        return $table
            ->heading('من دفعوا للملفات')
            ->description('العائد الإجمالي: '.number_format($total, 3).' ر.ع.')
            ->query(
                Payment::query()
                    ->with('digitalProduct')
                    ->where('status', Payment::STATUS_PAID)
                    ->latest('paid_at')
            )
            ->columns([
                Tables\Columns\TextColumn::make('email')
                    ->label('الإيميل')
                    ->searchable()
                    ->copyable(),
                Tables\Columns\TextColumn::make('digitalProduct.title')
                    ->label('الملف')
                    ->placeholder('—')
                    ->wrap(),
                Tables\Columns\TextColumn::make('amount')
                    ->label('العائد')
                    ->formatStateUsing(fn ($state, Payment $record): string => number_format((float) $state, 3).' '.$record->currency)
                    ->alignEnd(),
                Tables\Columns\TextColumn::make('paid_at')
                    ->label('تاريخ الدفع')
                    ->dateTime('Y-m-d H:i')
                    ->placeholder('—')
                    ->sortable(),
            ])
            ->emptyStateHeading('لا توجد مدفوعات بعد')
            ->emptyStateDescription('ستظهر هنا إيميلات من أكملوا الدفع مع الملف والعائد.')
            ->paginated([10, 25])
            ->defaultPaginationPageOption(10)
            ->defaultSort('paid_at', 'desc');
    }
}
