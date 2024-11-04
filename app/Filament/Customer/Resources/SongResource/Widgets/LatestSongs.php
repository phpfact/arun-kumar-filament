<?php

namespace App\Filament\Customer\Resources\SongResource\Widgets;

use Filament\Tables;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Widgets\TableWidget as BaseWidget;
use App\Filament\Customer\Resources\SongResource;
use App\Models\Artists;

class LatestSongs extends BaseWidget
{
    protected int|string|array $columnSpan = 'full';
    protected static ?int $sort = 3;
    protected static ?string $recordTitle = 'Latest Released';

    public function table(Table $table): Table
    {
        return $table
            ->modifyQueryUsing(fn ($query) => $query->where('customer_id', getCurrentCustomer()->id)->limit(10))
            ->query(SongResource::getEloquentQuery())
            ->defaultPaginationPageOption(10)
            ->defaultSort('created_at', 'desc')
            ->columns([

                ImageColumn::make('cover_photo')
                    ->extraImgAttributes(['loading' => 'lazy'])
                    ->size(150)
                    ->label('Art Work')
                    ->url(fn($record) => asset($record->cover_photo))
                    ->openUrlInNewTab(),

                TextColumn::make('name')
                    ->label('Song Name'),

                TextColumn::make('artists_id')
                    ->label('Artists Name')
                    ->placeholder('N/A')
                    ->formatStateUsing(function ($record) {
                        $badges = [];
                        foreach ($record->artists_id as $id) {
                            $artist = Artists::find($id);
                            if ($artist) {
                                $badges[] = '<span style="display: inline-block; padding: 1px 10px; background-color: #FFEB3B17; color: #FDD835; border: 1px solid #FDD835; border-radius: 12px; font-size: 0.700rem; font-weight: 500; box-shadow: 0px 2px 4px rgba(0, 0, 0, 0.1); margin-right: 6px;">' . e($artist->name) . '</span>';
                            }
                        }
                        return implode(' ', $badges);
                    })
                    ->html(),

                TextColumn::make('publisher')
                    ->badge()
                    ->label('Lyricists Name'),

                TextColumn::make('composer')
                    ->badge()
                    ->label('Music/Composer'),

                TextColumn::make('release_date')
                    ->date('M d, Y')
                    ->label('Release Date'),

                TextColumn::make('label.title')
                    ->placeholder('N/A')
                    ->label('Label Name'),

                TextColumn::make('isrc_code')
                    ->placeholder('N/A')
                    ->label('ISRC Code'),

                TextColumn::make('status')
                    ->badge()
                    ->formatStateUsing(fn($state) => ucfirst($state))
                    ->color(fn($state) => match ($state) {
                        'pending' => 'warning',
                        'approved' => 'success',
                        'rejected' => 'danger',
                    }),
            ]);
    }
}
