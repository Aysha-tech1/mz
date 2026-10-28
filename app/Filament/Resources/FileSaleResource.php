<?php

namespace App\Filament\Resources;

use App\Filament\Resources\FileSaleResource\Pages;
use App\Models\FileSale;
use Filament\Actions\ViewAction;
use Filament\Infolists\Components\TextEntry;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables;
use Filament\Tables\Table;

class FileSaleResource extends Resource
{
    protected static ?string $model = FileSale::class;

    protected static string|\BackedEnum|null $navigationIcon = 'heroicon-o-chart-bar';

    protected static ?string $navigationLabel = 'مبيعات الملفات';

    protected static ?string $modelLabel = 'عملية';

    protected static ?string $pluralModelLabel = 'مبيعات الملفات';

    protected static ?int $navigationSort = 3;

    public static function canCreate(): bool
    {
        return false;
    }

    public static function infolist(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('digitalProduct.title')
                    ->label('الملف'),
                TextEntry::make('digitalProduct.slug')
                    ->label('رابط الصفحة'),
                TextEntry::make('type')
                    ->label('النوع')
                    ->formatStateUsing(fn (FileSale $record): string => $record->typeLabel()),
                TextEntry::make('filename')
                    ->label('اسم التنزيل'),
                TextEntry::make('ip')
                    ->label('عنوان IP'),
                TextEntry::make('user_agent')
                    ->label('المتصفح')
                    ->columnSpanFull(),
                TextEntry::make('created_at')
                    ->label('التاريخ والوقت')
                    ->dateTime('Y-m-d H:i'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('created_at')
                    ->label('التاريخ')
                    ->dateTime('Y-m-d H:i')
                    ->sortable(),
                Tables\Columns\TextColumn::make('digitalProduct.title')
                    ->label('الملف')
                    ->searchable()
                    ->wrap(),
                Tables\Columns\TextColumn::make('type')
                    ->label('النوع')
                    ->badge()
                    ->formatStateUsing(fn (FileSale $record): string => $record->typeLabel())
                    ->color(fn (string $state): string => $state === 'sale' ? 'success' : 'warning'),
                Tables\Columns\TextColumn::make('filename')
                    ->label('اسم التنزيل')
                    ->toggleable(),
                Tables\Columns\TextColumn::make('ip')
                    ->label('IP')
                    ->toggleable(),
            ])
            ->defaultSort('created_at', 'desc')
            ->filters([
                Tables\Filters\SelectFilter::make('digital_product_id')
                    ->label('الملف')
                    ->relationship('digitalProduct', 'title'),
                Tables\Filters\SelectFilter::make('type')
                    ->label('النوع')
                    ->options([
                        'download' => 'تنزيل',
                        'sale' => 'بيع',
                    ]),
            ])
            ->actions([
                ViewAction::make(),
            ])
            ->bulkActions([]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListFileSales::route('/'),
            'view' => Pages\ViewFileSale::route('/{record}'),
        ];
    }
}
