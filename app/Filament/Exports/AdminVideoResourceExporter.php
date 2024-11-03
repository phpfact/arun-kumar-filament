<?php

namespace App\Filament\Exports;

use App\Models\Artists;
use App\Models\VideoSong;
use Filament\Actions\Exports\Exporter;
use Filament\Actions\Exports\ExportColumn;
use Filament\Actions\Exports\Models\Export;

class AdminVideoResourceExporter extends Exporter
{
    protected static ?string $model = VideoSong::class;

    public static function getColumns(): array
    {
        return [
            ExportColumn::make('name')->label('Song Name'),
            ExportColumn::make('artists_id')->label('Artists Name')->state(function ($record): string {
                return implode(', ', array_filter(array_map(fn($id) => Artists::find($id)?->name, $record->artists_id)));
            }),
            ExportColumn::make('publisher')->label('Lyricists Name'),
            ExportColumn::make('composer')->label('Music/Composer'),
            ExportColumn::make('instagram')->label('Instagram'),
            ExportColumn::make('label.title')->label('Song Label'),
            ExportColumn::make('release_date')->label('Release Date'),
            ExportColumn::make('languages')->label('Song Languages'),
            ExportColumn::make('stream_store')->label('All Music Streaming Store')->state(function ($record): string {
                return $record->stream_store == 1 ? 'Yes' : 'No';
            }),
            ExportColumn::make('fb_ig_music')->label('Facebook and Instagram Music')->state(function ($record): string {
                return $record->fb_ig_music == 1 ? 'Yes' : 'No';
            }),
            ExportColumn::make('yt_content_id')->label('YouTube Content ID')->state(function ($record): string {
                return $record->yt_content_id == 1 ? 'Yes' : 'No';
            }),
            ExportColumn::make('explicit')->label('Explicit')->state(function ($record): string {
                return $record->explicit == 1 ? 'Yes' : 'No';
            }),
            ExportColumn::make('caller_tune')->label('Caller Tune')->state(function ($record): string {
                if ($record->caller_tune == 1) {
                    $tuneNames = $record->caller_tune_name ?? [];
                    $tuneDurations = $record->caller_tune_duration ?? [];
                    $tunes = array_map(fn($name, $duration) => "($name : $duration)", $tuneNames, $tuneDurations);
                    return implode(', ', $tunes);
                }
                return 'No';
            }),
            
            ExportColumn::make('isrc_code')->label('ISRC Code'),
            ExportColumn::make('cover_photo')->label('Artwork')->state(function ($record): string {
                return basename($record->cover_photo);
            }),
            ExportColumn::make('video_path')->label('Song')->state(function ($record): string {
                return basename($record->video_path);
            }),

            // ExportColumn::make('music_genre')->label('Primary Genre'),
            // ExportColumn::make('music_sub_genre')->label('Sub-Genre'),
            // ExportColumn::make('music_mood')->label('Mood/Feel'),
            // ExportColumn::make('status')->label('Status'),

        ];
    }

    public static function getCompletedNotificationBody(Export $export): string
    {
        $body = 'Your admin video resource export has completed and ' . number_format($export->successful_rows) . ' ' . str('row')->plural($export->successful_rows) . ' exported.';

        if ($failedRowsCount = $export->getFailedRowsCount()) {
            $body .= ' ' . number_format($failedRowsCount) . ' ' . str('row')->plural($failedRowsCount) . ' failed to export.';
        }

        return $body;
    }
}
