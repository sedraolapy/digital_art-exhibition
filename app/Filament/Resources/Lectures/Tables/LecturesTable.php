<?php

namespace App\Filament\Resources\Lectures\Tables;

use App\Enums\RoleEnum;
use App\Models\EventDay;
use App\Models\Lecture;
use Carbon\Carbon;
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
use Illuminate\Support\Facades\Auth;

class LecturesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('title')
                    ->searchable(),
                ImageColumn::make('image')
                    ->label('Lecture Image')
                    ->height(60)
                    ->width(60)
                    ->getStateUsing(fn ($record) =>
                        $record->getMedia('lectures')
                            ->map(fn ($media) => $media->getUrl())
                        ),
                TextColumn::make('speaker_name')
                    ->searchable(),
                TextColumn::make('day.date')
                    ->label('Date')
                    ->sortable(),
                TextColumn::make('start_time')
                    ->time('H:i')
                    ->sortable(),
                TextColumn::make('end_time')
                    ->time('H:i')
                    ->sortable(),
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
                SelectFilter::make('day_id')
                    ->label('Event Day')
                    ->options(
                        EventDay::with('occurrence')
                            ->get()
                            ->mapWithKeys(fn ($day) => [
                                $day->id => "{$day->day_number} - {$day->occurrence->title}",
                            ])
                    )
                    ->searchable()
                    ->query(function ($query, array $data) {

                        if (! filled($data['value'])) {
                            return;
                        }

                        $query->where('day_id', $data['value']);
                    }),

                SelectFilter::make('speaker_name')
                    ->label('Speaker')
                    ->options(fn () =>
                        Lecture::query()
                            ->pluck('speaker_name', 'speaker_name')
                            ->unique()
                    )
                    ->searchable(),

                Filter::make('date')
                    ->form([
                        DatePicker::make('date')
                            ->label('Lecture Date'),
                    ])
                    ->query(function ($query, array $data) {

                        if (! filled($data['date'])) {
                            return;
                        }

                        $query->whereHas('day', function ($q) use ($data) {
                            $q->whereDate('date', $data['date']);
                        });
                    }),

            ])
            ->recordActions([
                ViewAction::make(),
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make()
                        ->visible(fn () => Auth::user()->hasRole(RoleEnum::SUPER_ADMIN->value)),
                ]),
            ]);
    }
}
