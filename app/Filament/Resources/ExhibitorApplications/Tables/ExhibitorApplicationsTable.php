<?php

namespace App\Filament\Resources\ExhibitorApplications\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Support\Facades\Storage;
use App\Enums\ExhibitorStatus;
use App\Enums\RoleEnum;
use App\Events\ExhibitorApplicationStatusChanged;
use App\Mail\ExhibitorApplicationStatusMail;
use App\Services\Exhibitor\ExhibitorProfileService;
use Event;
use Filament\Actions\Action;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Filters\SelectFilter;
use Illuminate\Support\Facades\Auth;
use Mail;

class ExhibitorApplicationsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('user.name')
                    ->numeric()
                    ->sortable(),
                ImageColumn::make('image')
                    ->label('Exhibitor Image')
                    ->circular()
                    ->height(60)
                    ->width(60)
                    ->getStateUsing(fn ($record) =>
                        $record->getMedia('application_image')
                            ->map(fn ($media) => $media->getUrl('webp'))
                        ),
                TextColumn::make('category.name')
                    ->badge()
                    ->searchable(),
                TextColumn::make('portfolio_url')
                    ->label('Portfolio')
                    ->url(fn ($state) => $state)
                    ->formatStateUsing(fn () => 'Visit Portfolio')
                    ->openUrlInNewTab()
                    ->color('primary')
                    ->weight('medium')
                    ->icon('heroicon-o-link')
                    ->iconPosition('before'),
                TextColumn::make('status')
                    ->label('Status')
                    ->badge()
                    ->searchable()
                    ->formatStateUsing(fn (ExhibitorStatus $state) => match ($state) {
                        ExhibitorStatus::PENDING => 'Pending',
                        ExhibitorStatus::REJECTED => 'Rejected',
                        ExhibitorStatus::APPROVED_INITIAL => 'Approved (Initial)',
                        ExhibitorStatus::APPROVED_FINAL => 'Approved (Final)',
                    })
                    ->color(fn (ExhibitorStatus $state) => match ($state) {
                        ExhibitorStatus::PENDING => 'warning',
                        ExhibitorStatus::REJECTED => 'danger',
                        ExhibitorStatus::APPROVED_INITIAL => 'info',
                        ExhibitorStatus::APPROVED_FINAL => 'success',
                    }),
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

                SelectFilter::make('status')
                    ->label('Status')
                    ->options([
                        ExhibitorStatus::PENDING->value => 'Pending',
                        ExhibitorStatus::APPROVED_INITIAL->value => 'Approved (Initial)',
                        ExhibitorStatus::APPROVED_FINAL->value => 'Approved (Final)',
                        ExhibitorStatus::REJECTED->value => 'Rejected',
                    ]),

                SelectFilter::make('category')
                    ->relationship('category', 'name')
                    ->label('Category')
                    ->searchable()
                    ->preload(),

                SelectFilter::make('event_occurrence_id')
                    ->relationship('eventOccurrence', 'title')
                    ->label('Event')
                    ->searchable()
                    ->preload(),

                Filter::make('experience_years')
                    ->form([
                        TextInput::make('min')
                            ->numeric()
                            ->label('Min Years'),

                        TextInput::make('max')
                            ->numeric()
                            ->label('Max Years'),
                    ])
                    ->query(function ($query, array $data) {
                        return $query
                            ->when(
                                filled($data['min']),
                                fn ($q) => $q->where('experience_years', '>=', $data['min'])
                            )
                            ->when(
                                filled($data['max']),
                                fn ($q) => $q->where('experience_years', '<=', $data['max'])
                            );
                    }),

                Filter::make('created_at')
                    ->form([
                        DatePicker::make('from'),
                        DatePicker::make('until'),
                    ])
                    ->query(function ($query, array $data) {
                        return $query
                            ->when(
                                $data['from'],
                                fn ($q) => $q->whereDate('created_at', '>=', $data['from'])
                            )
                            ->when(
                                $data['until'],
                                fn ($q) => $q->whereDate('created_at', '<=', $data['until'])
                            );
                    }),

            ])
            ->recordActions([
                ViewAction::make(),
                EditAction::make()
                    ->visible(fn () => Auth::user()->hasRole(RoleEnum::SUPER_ADMIN->value)),


            Action::make('approveInitial')
                ->label('Approve')
                ->icon('heroicon-o-check-circle')
                ->color('success')
                ->requiresConfirmation()
                ->visible(fn ($record) => $record->status === ExhibitorStatus::PENDING)
                ->action(function ($record) {
                    $record->update(['status' => ExhibitorStatus::APPROVED_INITIAL]);

                    Event::dispatch(new ExhibitorApplicationStatusChanged(
                        $record,
                        'تم قبول طلبك بشكل مبدئي، وسيتم التواصل معك لاحقًا لمتابعة الإجراءات.'
                    ));
                }),

            Action::make('reject')
                ->label('Reject')
                ->icon('heroicon-o-x-circle')
                ->color('danger')
                ->requiresConfirmation()
                ->visible(fn ($record) =>
                    in_array($record->status, [
                        ExhibitorStatus::PENDING,
                        ExhibitorStatus::APPROVED_INITIAL,
                    ])
                )
                ->action(function ($record) {
                    $record->update(['status' => ExhibitorStatus::REJECTED]);

                    Event::dispatch(new ExhibitorApplicationStatusChanged(
                        $record,
                        'نعتذر، لقد تم رفض طلبك. نتمنى لك التوفيق في الفرص القادمة.'
                    ));
                }),

            Action::make('approveFinal')
                ->label('Final Approval')
                ->icon('heroicon-o-check-badge')
                ->color('success')
                ->requiresConfirmation()
                ->visible(fn ($record) => $record->status === ExhibitorStatus::APPROVED_INITIAL)
                ->action(function ($record) {
                    $record->update(['status' => ExhibitorStatus::APPROVED_FINAL]);

                    app(ExhibitorProfileService::class)->createFromApplication($record);

                    Event::dispatch(new ExhibitorApplicationStatusChanged(
                        $record,
                        'تهانينا! تم قبول طلبك بشكل نهائي، وتم إنشاء ملفك كعارض في النظام. يمكنك الآن مراجعة ملفك كعارض من خلال الموقع.'
                    ));
                }),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
