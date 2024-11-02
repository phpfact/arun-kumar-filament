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
            // ExportColumn::make('name')->label('Artists Name'),      
            ExportColumn::make('publisher')->label('Lyricists Name'),
            ExportColumn::make('composer')->label('Music/Composer'),
            ExportColumn::make('instagram')->label('Instagram'),
            ExportColumn::make('label.title')->label('Song Label'),            // check
            ExportColumn::make('release_date')->label('Release Date'),
            ExportColumn::make('languages')->label('Song Languages'),
            ExportColumn::make('stream_store')->label('All Music Streaming Store'),
            ExportColumn::make('fb_ig_music')->label('Facebook and Instagram Music'),
            ExportColumn::make('yt_content_id')->label('YouTube Content ID'),
            ExportColumn::make('explicit')->label('Explicit'),
            ExportColumn::make('caller_tune')->label('Caller Tune'),
            ExportColumn::make('isrc_code')->label('ISRC Code'),
            ExportColumn::make('cover_photo')->label('Artwork')->state(function ($record): string {
                return basename($record->cover_photo);
            }),
            ExportColumn::make('song_path')->label('Song')->state(function ($record): string {
                return basename($record->song_path);
            }),

            // ExportColumn::make('music_genre')->label('Primary Genre'),
            // ExportColumn::make('music_sub_genre')->label('Sub-Genre'),
            // ExportColumn::make('music_mood')->label('Mood/Feel'),
            // ExportColumn::make('status')->label('Status'),

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
