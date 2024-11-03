<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Filament\Forms\Components\Select;
use App\Models\RemoveCopyrightRequest;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Filters\SelectFilter;
use Illuminate\Database\Eloquent\Builder;
use Filament\Tables\Actions\ExportBulkAction;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\RemoveCopyrightRequestResource\Pages;
use App\Filament\Resources\RemoveCopyrightRequestResource\RelationManagers;

class RemoveCopyrightRequestResource extends Resource
{
    protected static ?string $model = RemoveCopyrightRequest::class;

    protected static ?string $modelLabel = 'Release Copyright claim';

    protected static ?string $pluralModelLabel = 'Release Copyright claim';

    protected static ?string $navigationIcon = 'heroicon-o-minus-circle';

    public static function form(Form $form): Form
    {
        return $form
            ->columns(1)
            ->schema([
                Select::make('status')
                    ->selectablePlaceholder(false)
                    ->options([
                        'pending' => 'Pending',
                        'processing' => 'Processing',
                        'completed' => 'Completed',
                        'cancelled' => 'Cancelled',
                    ])
                    ->required(),

            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('song_name')
                    ->searchable()
                    ->sortable()
                    ->label('Song Name'),

                TextColumn::make('yt_video_link')
                    ->label('YouTube Video Link'),

                TextColumn::make('customer.email')
                    ->searchable()
                    ->sortable()
                    ->label('Requested By'),

                TextColumn::make('provider'),

                TextColumn::make('status')
                    ->color(fn ($state) => match ($state) {
                        'pending' => 'warning',
                        'processing' => 'info',
                        'completed' => 'success',
                        'cancelled' => 'danger',
                    })
                    ->formatStateUsing(fn ($state) => ucfirst($state))
                    ->badge(),

                TextColumn::make('created_at')
                    ->searchable()
                    ->date('M d, Y')
                    ->label('Requested At'),

            ])
            ->filters([
                SelectFilter::make('customer_id')
                    ->searchable()
                    ->relationship('customer', 'email')
                    ->preload()
                    ->label('Requested By'),
            ])
            ->headerActions([
                Tables\Actions\ExportAction::make()->exporter(\App\Filament\Exports\AdminRemoveCopyrightRequestResourceExporter::class),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make()
                ]),
                ExportBulkAction::make()->exporter(\App\Filament\Exports\AdminRemoveCopyrightRequestResourceExporter::class),
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
            'index' => Pages\ListRemoveCopyrightRequests::route('/'),
            // 'create' => Pages\CreateRemoveCopyrightRequest::route('/create'),
            // 'edit' => Pages\EditRemoveCopyrightRequest::route('/{record}/edit'),
        ];
    }
}
