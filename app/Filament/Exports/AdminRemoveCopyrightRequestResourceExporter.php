<?php

namespace App\Filament\Exports;

use App\Models\RemoveCopyrightRequest;
use Filament\Actions\Exports\ExportColumn;
use Filament\Actions\Exports\Exporter;
use Filament\Actions\Exports\Models\Export;

class AdminRemoveCopyrightRequestResourceExporter extends Exporter
{
    protected static ?string $model = RemoveCopyrightRequest::class;

    public static function getColumns(): array
    {
        return [
            ExportColumn::make('song_name')->label('Song Name'),
            ExportColumn::make('yt_video_link')->label('YouTube Video Link'),
            ExportColumn::make('customer.email')->label('Requested By'),
            ExportColumn::make('provider')->label('Provider'),
            ExportColumn::make('status')->label('Status')
        ];
    }

    public static function getCompletedNotificationBody(Export $export): string
    {
        $body = 'Your admin remove copyright request resource export has completed and ' . number_format($export->successful_rows) . ' ' . str('row')->plural($export->successful_rows) . ' exported.';

        if ($failedRowsCount = $export->getFailedRowsCount()) {
            $body .= ' ' . number_format($failedRowsCount) . ' ' . str('row')->plural($failedRowsCount) . ' failed to export.';
        }

        return $body;
    }
}
