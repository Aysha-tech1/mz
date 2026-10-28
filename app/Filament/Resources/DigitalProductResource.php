<?php

namespace App\Filament\Resources;

use App\Filament\Resources\DigitalProductResource\Pages;
use App\Models\DigitalProduct;
use Filament\Actions\BulkActionGroup;
use Illuminate\Support\Str;
use Livewire\Features\SupportFileUploads\TemporaryUploadedFile;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components as Components;
use Filament\Resources\Resource;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Components\Utilities\Set;
use Filament\Schemas\Schema;
use Filament\Tables;
use Filament\Tables\Table;

class DigitalProductResource extends Resource
{
    protected static ?string $model = DigitalProduct::class;

    protected static string|\BackedEnum|null $navigationIcon = 'heroicon-o-document-text';

    protected static ?string $navigationLabel = 'الملفات';

    protected static ?string $modelLabel = 'ملف';

    protected static ?string $pluralModelLabel = 'الملفات';

    protected static ?int $navigationSort = 1;

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Components\TextInput::make('step_number')
                    ->label('الرقم')
                    ->required()
                    ->numeric()
                    ->minValue(1)
                    ->default(1),
                Components\TextInput::make('label')
                    ->label('اسم الملف القصير')
                    ->helperText('يظهر بجانب التفاصيل، مثل: ملف اختيار المجال')
                    ->required()
                    ->maxLength(255),
                Components\TextInput::make('title')
                    ->label('اسم الملف')
                    ->required()
                    ->maxLength(255)
                    ->live(onBlur: true)
                    ->afterStateUpdated(function (?string $state, Set $set): void {
                        if (filled($state)) {
                            $set('slug', DigitalProduct::slugFromTitle($state));
                        }
                    })
                    ->columnSpanFull(),
                Components\TextInput::make('slug')
                    ->label('رابط الصفحة')
                    ->helperText('يظهر في الرابط، ويُستخدم كاسم ملف التحميل بالإنجليزي، مثل: select فيصير select.docx')
                    ->prefix('/files/')
                    ->required()
                    ->unique(ignoreRecord: true)
                    ->maxLength(255)
                    ->columnSpanFull(),
                Components\Textarea::make('description')
                    ->label('وصف قصير')
                    ->rows(3)
                    ->required()
                    ->columnSpanFull(),
                Components\Textarea::make('full_description')
                    ->label('الوصف الكامل')
                    ->helperText('يظهر في صفحة التفاصيل')
                    ->rows(10)
                    ->columnSpanFull(),
                Components\Toggle::make('is_free')
                    ->label('مجاني')
                    ->helperText('إذا كان مدفوعًا، أدخل السعر أدناه')
                    ->live()
                    ->afterStateUpdated(function (?bool $state, Set $set): void {
                        if ($state) {
                            $set('price', 0);
                            $set('old_price', null);
                        }
                    }),
                Components\Toggle::make('is_coming_soon')
                    ->label('قريبًا'),
                Components\Toggle::make('is_featured')
                    ->label('عرض مميز'),
                Components\Toggle::make('is_active')
                    ->label('ظاهر في الموقع')
                    ->required()
                    ->default(true),
                Components\TextInput::make('price')
                    ->label('السعر')
                    ->numeric()
                    ->prefix('ر.ع.')
                    ->default(0)
                    ->visible(fn (Get $get): bool => ! $get('is_free'))
                    ->required(fn (Get $get): bool => ! $get('is_free')),
                Components\TextInput::make('old_price')
                    ->label('السعر السابق')
                    ->numeric()
                    ->prefix('ر.ع.')
                    ->helperText('اختياري للعروض')
                    ->visible(fn (Get $get): bool => ! $get('is_free')),
                Components\TextInput::make('downloads_count')
                    ->label('عدد التنزيلات')
                    ->disabled()
                    ->dehydrated(false)
                    ->numeric()
                    ->default(0),
                Components\FileUpload::make('file_path')
                    ->label('ملف التحميل')
                    ->helperText('PDF، Word، Excel، PowerPoint، CSV، TXT، ZIP')
                    ->disk('public')
                    ->directory('digital-products')
                    ->acceptedFileTypes(DigitalProduct::UPLOAD_MIME_TYPES)
                    ->rule('mimes:'.implode(',', DigitalProduct::UPLOAD_EXTENSIONS))
                    ->maxSize(51200)
                    ->getUploadedFileNameForStorageUsing(function (TemporaryUploadedFile $file): string {
                        $extension = strtolower($file->getClientOriginalExtension() ?: ($file->guessExtension() ?: ''));

                        if (! in_array($extension, DigitalProduct::UPLOAD_EXTENSIONS, true)) {
                            $extension = 'bin';
                        }

                        return Str::uuid().'.'.$extension;
                    })
                    ->downloadable()
                    ->openable()
                    ->columnSpanFull(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('step_number')
                    ->label('الرقم')
                    ->sortable(),
                Tables\Columns\TextColumn::make('title')
                    ->label('اسم الملف')
                    ->searchable()
                    ->wrap()
                    ->description(fn (DigitalProduct $record): string => $record->displaySales()),
                Tables\Columns\TextColumn::make('downloads_count')
                    ->label('المبيعات')
                    ->sortable()
                    ->alignCenter()
                    ->badge()
                    ->color('warning'),
                Tables\Columns\TextColumn::make('slug')
                    ->label('الرابط')
                    ->formatStateUsing(fn (?string $state): string => $state ? '/files/'.$state : '—')
                    ->copyable()
                    ->toggleable(),
                Tables\Columns\TextColumn::make('description')
                    ->label('الوصف القصير')
                    ->limit(40)
                    ->toggleable(),
                Tables\Columns\TextColumn::make('price')
                    ->label('السعر')
                    ->formatStateUsing(fn ($state, DigitalProduct $record): string => $record->displayPrice())
                    ->sortable(),
                Tables\Columns\IconColumn::make('is_free')
                    ->label('مجاني')
                    ->boolean(),
                Tables\Columns\IconColumn::make('is_coming_soon')
                    ->label('قريبًا')
                    ->boolean(),
                Tables\Columns\IconColumn::make('is_active')
                    ->label('ظاهر')
                    ->boolean(),
            ])
            ->defaultSort('step_number')
            ->filters([
                Tables\Filters\TernaryFilter::make('is_active')->label('ظاهر'),
                Tables\Filters\TernaryFilter::make('is_free')->label('مجاني'),
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
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListDigitalProducts::route('/'),
            'create' => Pages\CreateDigitalProduct::route('/create'),
            'edit' => Pages\EditDigitalProduct::route('/{record}/edit'),
        ];
    }
}
