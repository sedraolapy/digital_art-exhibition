<?php

namespace App\Filament\Resources\EventOccurrences\RelationManagers;

use App\Models\EventDay;
use Filament\Actions;
use Filament\Forms;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Unique;
class DaysRelationManager extends RelationManager
{
    protected static string $relationship = 'days';

    public function table(Tables\Table $table): Tables\Table
    {
        return $table
            ->headerActions([
                Actions\CreateAction::make()
                    ->using(function (array $data) {
                        return $this->getOwnerRecord()
                            ->days()
                            ->create($data);
                    })
                    ->form([
                        Forms\Components\TextInput::make('day_number')
                            ->label('Day number')
                            ->numeric()
                            ->required()
                            ->default(function () {
                                return EventDay::where(
                                    'event_occurrences_id',
                                    $this->getOwnerRecord()->id
                                )->count() + 1;
                            }),
                        Forms\Components\DatePicker::make('date')
                            ->label('Date')
                            ->required()
                            ->native(false)
                            ->minDate(fn () => $this->getOwnerRecord()->start_date)
                            ->maxDate(fn () => $this->getOwnerRecord()->end_date)
                            ->unique(
                                table: 'event_days',
                                column: 'date',
                                ignoreRecord: true,
                                modifyRuleUsing: fn (Unique $rule) => $rule->where(
                                    'event_occurrences_id',
                                    $this->getOwnerRecord()->id,
                                ),
                            )
                            ->validationMessages([
                                'unique' => 'A day with this date already exists for this event occurrence.',
                            ]),
                    ]),
            ])
            ->columns([
                Tables\Columns\TextColumn::make('day_number')
                    ->label('Day number'),

                Tables\Columns\TextColumn::make('date')
                    ->date()
                    ->label('Date'),
            ])
            ->actions([
                Actions\EditAction::make()
                    ->mutateRecordDataUsing(function (array $data, $record): array {
                        $data['day_number'] = $record->getRawOriginal('day_number');

                        return $data;
                    })
                    ->form([
                        Forms\Components\TextInput::make('day_number')
                            ->numeric()
                            ->required(),

                        Forms\Components\DatePicker::make('date')
                            ->required()
                            ->native(false)
                            ->minDate(fn () => $this->getOwnerRecord()->start_date)
                            ->maxDate(fn () => $this->getOwnerRecord()->end_date),
                    ]),

                Actions\DeleteAction::make(),
            ]);
    }
}