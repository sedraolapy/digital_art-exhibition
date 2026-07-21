<?php

namespace App\Filament\Resources\EventOccurrences\RelationManagers;

use App\Filament\Resources\EventDays\EventDayResource;
use Filament\Actions;
use Filament\Forms;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;

class DaysRelationManager extends RelationManager
{
    protected static string $relationship = 'days';

    protected static ?string $relatedResource = EventDayResource::class;

    public function table(Tables\Table $table): Tables\Table
    {
        return $table
            ->headerActions([
                Actions\CreateAction::make()
                    ->form([
                        Forms\Components\TextInput::make('day_number')
                            ->numeric()
                            ->required()
                            ->label('رقم اليوم'),

                        Forms\Components\DatePicker::make('date')
                            ->required()
                            ->label('تاريخ اليوم'),
                    ]),
            ])
            ->columns([
                Tables\Columns\TextColumn::make('day_number')->label('اليوم'),
                Tables\Columns\TextColumn::make('date')->date()->label('التاريخ'),
            ])
            ->actions([
                Actions\EditAction::make()
                    ->form([
                        Forms\Components\TextInput::make('day_number')
                            ->numeric()
                            ->required(),

                        Forms\Components\DatePicker::make('date')
                            ->required(),
                    ]),
                Actions\DeleteAction::make(),
            ]);
    }
}
