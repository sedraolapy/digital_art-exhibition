<?php

namespace App\Filament\Resources\VotingResults\Tables;

use App\Models\Category;
use App\Models\EventOccurrence;
use App\Models\ExhibitorProfile;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;

class VotingResultsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('exhibitor.user.name')
                ->label('Exhibitor')
                ->url(fn ($record) => route('filament.admin.resources.exhibitor-profiles.view',$record->exhibitor))
                ->color('primary')
                ->weight('medium')
                ->icon('heroicon-o-link')
                ->iconPosition('before')
                ->searchable(),

            TextColumn::make('exhibitor.category.name')
                ->label('Category'),

            TextColumn::make('eventOccurrence.title')
                ->label('Event'),

            TextColumn::make('total_votes')
                ->label('Total Votes')
                ->badge()
                ->sortable(),
            ])
            ->filters([
                SelectFilter::make('event_occurrence_id')
                    ->label('Event')
                    ->options(
                        EventOccurrence::pluck('title','id')
                    )
                    ->query(function ($query, array $data) {

                        if (! filled($data['value'])) {
                            return;
                        }

                        $query->where(
                            'event_occurrence_id',
                            $data['value']
                        );
                    }),

                SelectFilter::make('exhibitor_id')
                    ->label('Exhibitor')
                    ->options(
                        ExhibitorProfile::with('user')
                            ->get()
                            ->mapWithKeys(fn ($exhibitor) => [
                                $exhibitor->id =>
                                    $exhibitor->user->first_name
                                    .' '
                                    .$exhibitor->user->last_name,
                            ])
                    )
                    ->searchable()
                    ->query(function ($query, array $data) {

                        if (! filled($data['value'])) {
                            return;
                        }

                        $query->where(
                            'exhibitor_id',
                            $data['value']
                        );
                    }),

                SelectFilter::make('category_id')
                    ->label('Category')
                    ->options(
                        Category::pluck('name','id')
                    )
                    ->query(function ($query, array $data) {

                        if (! filled($data['value'])) {
                            return;
                        }

                        $query->whereHas(
                            'exhibitor',
                            fn ($q) =>
                                $q->where(
                                    'category_id',
                                    $data['value']
                                )
                        );
                    }),
            ])
            ->recordActions([
                ViewAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    //
                ]),
            ]);
    }
}
