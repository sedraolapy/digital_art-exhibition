<?php

namespace App\Filament\Resources\Members\Tables;

use App\Models\Member;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Forms\Components\DatePicker;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class MembersTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->searchable(),
                ImageColumn::make('image')
                    ->label('Member Image')
                    ->circular()
                    ->height(60)
                    ->width(60)
                    ->getStateUsing(fn ($record) =>
                        $record->getMedia('members')
                            ->map(fn ($media) => $media->getUrl('webp'))
                        ),
                TextColumn::make('role')
                    ->searchable(),
                TextColumn::make('portfolio_url')
                    ->label('Portfolio')
                    ->searchable()
                    ->url(fn ($record) => $record->portfolio_url)
                    ->openUrlInNewTab()
                    ->formatStateUsing(fn () => 'View Portfolio')
                    ->color('primary')
                    ->icon('heroicon-o-link'),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                
            ])
            ->recordActions([
                ViewAction::make()->modal(),
                EditAction::make()->modal(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
