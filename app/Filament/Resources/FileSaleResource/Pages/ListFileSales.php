<?php

namespace App\Filament\Resources\FileSaleResource\Pages;

use App\Filament\Resources\FileSaleResource;
use App\Filament\Resources\FileSaleResource\Widgets\FileDownloadsByProductChart;
use App\Filament\Resources\FileSaleResource\Widgets\FileDownloadsChart;
use App\Filament\Resources\FileSaleResource\Widgets\FileSaleStats;
use Filament\Resources\Pages\ListRecords;

class ListFileSales extends ListRecords
{
    protected static string $resource = FileSaleResource::class;

    protected function getHeaderWidgets(): array
    {
        return [
            FileSaleStats::class,
            FileDownloadsChart::class,
            FileDownloadsByProductChart::class,
        ];
    }

    /**
     * @return int | array<string, ?int>
     */
    public function getHeaderWidgetsColumns(): int | array
    {
        return [
            'md' => 2,
            'xl' => 3,
        ];
    }
}
