<?php

namespace App\Filament\Exports;

use App\Models\Release;
use Filament\Actions\Exports\Exporter;
use Filament\Actions\Exports\ExportColumn;
use Filament\Actions\Exports\Models\Export;

class TrackExporter extends Exporter
{
    protected static ?string $model = Release::class;

    public static function getColumns(): array
    {
        return [
            ExportColumn::make('album_title')->label('Album Title'),
            ExportColumn::make('album_artists_id')->label('Album Artists'),
            ExportColumn::make('album_music_genre')->label('Genre'),
            ExportColumn::make('track_song_name')->label('Track Name'),
            ExportColumn::make('isrc')->label('ISRC Code'),
            ExportColumn::make('track_music_mood')->label('Track Mood'),
            ExportColumn::make('explicit')->label('Explicit'),
            ExportColumn::make('featuring_artists_id')->label('Featuring Artists'),
            ExportColumn::make('lyrics_language')->label('Lyrics Language'),
        ];
    }

    public static function getRows(): array
    {
        // Static data for testing
        return [
            [
                'album_title' => 'Album 1',
                'album_artists_id' => 'Artist 1, Artist 2',
                'album_music_genre' => 'Pop',
                'track_song_name' => 'Track 1',
                'isrc' => 'ISRC12345',
                'track_music_mood' => 'Happy',
                'explicit' => 'Yes',
                'featuring_artists_id' => 'Feat Artist 1',
                'lyrics_language' => 'English',
            ],
            [
                'album_title' => 'Album 1',
                'album_artists_id' => 'Artist 1, Artist 2',
                'album_music_genre' => 'Pop',
                'track_song_name' => 'Track 2',
                'isrc' => 'ISRC12346',
                'track_music_mood' => 'Sad',
                'explicit' => 'No',
                'featuring_artists_id' => '',
                'lyrics_language' => 'English',
            ],
            [
                'album_title' => 'Album 2',
                'album_artists_id' => 'Artist 3',
                'album_music_genre' => 'Rock',
                'track_song_name' => 'Track 1',
                'isrc' => 'ISRC12347',
                'track_music_mood' => 'Energetic',
                'explicit' => 'Yes',
                'featuring_artists_id' => '',
                'lyrics_language' => 'English',
            ]
        ];
    }

    public static function getCompletedNotificationBody(Export $export): string
    {
        $body = 'Your track export has completed and ' . number_format($export->successful_rows) . 
        ' row(s) exported.';

        if ($failedRowsCount = $export->getFailedRowsCount()) {
            $body .= ' '. number_format($failedRowsCount) . 
            ' row(s) failed to export.';
        }

        return $body;
    }
}
