<?php

namespace App\Filament\Customer\Resources\SongResource\Widgets;

use Filament\Tables;
use App\Models\Label;
use App\Models\Artists;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Widgets\TableWidget as BaseWidget;
use App\Filament\Customer\Resources\SongResource;
use App\Filament\Customer\Resources\MusicResource;

class LatestSongs extends BaseWidget
{
    protected int|string|array $columnSpan = 'full';
    protected static ?int $sort = 3;
    protected static ?string $recordTitle = 'Latest Released';

    public function table(Table $table): Table
    {
        return $table
            ->paginated(false)
            ->modifyQueryUsing(fn ($query) => $query->where('customer_id', getCurrentCustomer()->id)->limit(10))
            ->query(MusicResource::getEloquentQuery())
            ->defaultPaginationPageOption(10)
            ->defaultSort('created_at', 'desc')
            ->columns([

                ImageColumn::make('album_cover_photo')->extraImgAttributes(['loading' => 'lazy'])->size(150)->toggleable()->label('Artwork')->openUrlInNewTab()
                ->url(function ($record) {
                    return asset($record->album_cover_photo);
                }),

                Tables\Columns\TextColumn::make('album_title')->searchable()->label('Album Name'),

                // Tables\Columns\TextColumn::make('artists.name')->searchable()->label('Artist Name'),
                Tables\Columns\TextColumn::make('release_primary_artist.name')->searchable()->label('Artist Name'),

                // Tables\Columns\TextColumn::make('track.title')->searchable()->label('Label Name'),

                Tables\Columns\TextColumn::make('album_label_id')->searchable()->formatStateUsing(function($record){
                     return Label::find($record->album_label_id)->title ?? '';
                })->label('Label Name'),

                Tables\Columns\TextColumn::make('album_upc_ean')->searchable()->label(' UPC/EAN'),

                Tables\Columns\TextColumn::make('isrc_code')->searchable()->label(' ISRC Code'),

                Tables\Columns\TextColumn::make('album_release_type')
                ->label('Release Type')
                ->formatStateUsing(fn ($state) => strtoupper($state))
                ->color(fn ($state) => match ($state) {
                    'single' => 'success',
                    'ep' => 'warning',
                    'album' => 'primary',
                    default => 'secondary',
                })
                ->icon(fn ($state) => match ($state) {
                    'single' => 'heroicon-o-musical-note',
                    'ep' => 'heroicon-o-square-3-stack-3d',
                    'album' => 'heroicon-o-archive-box',
                    default => 'heroicon-o-question-mark-circle',
                })
                ->badge()
                ->searchable(),

                Tables\Columns\TextColumn::make('album_catalogue_number')->label('Catalogue Number'),

                TextColumn::make('status')
                ->badge()
                ->searchable()
                ->color(fn ($state) => match ($state) {
                    'pending' => 'warning',
                    'approved' => 'success',
                    'rejected' => 'danger',
                })
                ->formatStateUsing(fn ($state) => ucfirst($state))


                
            ]);
    }
}
