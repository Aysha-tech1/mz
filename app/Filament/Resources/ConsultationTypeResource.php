<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ConsultationTypeResource\Pages;
use App\Models\ConsultationType;
use Filament\Schemas\Schema;
use Filament\Forms\Components as Components;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Actions\EditAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\BulkActionGroup;

class ConsultationTypeResource extends Resource
{
    protected static ?string $model = ConsultationType::class;

    protected static string|\BackedEnum|null $navigationIcon = 'heroicon-o-list-bullet';

    protected static ?string $navigationLabel = 'أنواع الاستشارة';

    protected static ?string $modelLabel = 'نوع استشارة';

    protected static ?string $pluralModelLabel = 'أنواع الاستشارة';

    protected static ?int $navigationSort = 4;

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Components\TextInput::make('title')
                    ->label('العنوان')
                    ->required()
                    ->maxLength(255),
                Components\TextInput::make('duration')
                    ->label('المدة')
                    ->required()
                    ->numeric()
                    ->suffix('دقيقة'),
                Components\TextInput::make('price')
                    ->label('السعر')
                    ->required()
                    ->numeric()
                    ->prefix('ر.ع.'),
                Components\Toggle::make('is_active')
                    ->label('نشط')
                    ->required()
                    ->default(true),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('title')
                    ->label('العنوان')
                    ->searchable(),
                Tables\Columns\TextColumn::make('duration')
                    ->label('المدة')
                    ->numeric()
                    ->suffix(' د')
                    ->sortable(),
                Tables\Columns\TextColumn::make('price')
                    ->label('السعر')
                    ->money('OMR')
                    ->sortable(),
                Tables\Columns\IconColumn::make('is_active')
                    ->label('نشط')
                    ->boolean(),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('أُنشئ')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->label('عُدّل')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->actions([
                EditAction::make(),
            ])
            ->bulkActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListConsultationTypes::route('/'),
            'create' => Pages\CreateConsultationType::route('/create'),
            'edit' => Pages\EditConsultationType::route('/{record}/edit'),
        ];
    }
}
