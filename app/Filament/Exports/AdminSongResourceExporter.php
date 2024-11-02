<?php

namespace App\Filament\Exports;

use App\Models\Song;
use Filament\Actions\Exports\ExportColumn;
use Filament\Actions\Exports\Exporter;
use Filament\Actions\Exports\Models\Export;

class AdminSongResourceExporter extends Exporter
{
    protected static ?string $model = Song::class;

    public static function getColumns(): array
    {
        return [
            ExportColumn::make('name')->label('Song Name'),
            ExportColumn::make('instagram')->label('Instagram Handle'),
            ExportColumn::make('release_date')->label('Release Date'),
            ExportColumn::make('languages')->label('Languages'),
            ExportColumn::make('music_genre')->label('Primary Genre'),
            ExportColumn::make('music_sub_genre')->label('Sub-Genre'),
            ExportColumn::make('music_mood')->label('Mood/Feel'),
            ExportColumn::make('isrc_code')->label('ISRC Code'),
            ExportColumn::make('status')->label('Status'),
            ExportColumn::make('cover_photo')->label('Cover Art')->state(function ($record): string {
                return basename($record->cover_photo);
            }),
            ExportColumn::make('song_path')->label('Audio File')->state(function ($record): string {
                return basename($record->song_path);
            }),
        ];
    }

    public static function getCompletedNotificationBody(Export $export): string
    {
        $body = 'Your admin song resource export has completed and ' . number_format($export->successful_rows) . ' ' . str('row')->plural($export->successful_rows) . ' exported.';

        if ($failedRowsCount = $export->getFailedRowsCount()) {
            $body .= ' ' . number_format($failedRowsCount) . ' ' . str('row')->plural($failedRowsCount) . ' failed to export.';
        }

        return $body;
    }
}
