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
use App\Events\ExhibitorApplicationStatusChanged;
use App\Mail\ExhibitorApplicationStatusMail;
use App\Services\Exhibitor\ExhibitorProfileService;
use Event;
use Filament\Actions\Action;
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
                    ->numeric()
                    ->sortable(),
                TextColumn::make('experience_years')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('status')
                    ->badge()
                    ->searchable(),
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
                //
            ])
            ->recordActions([
                ViewAction::make()->modal(),
                EditAction::make()->modal(),

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
                ->visible(fn ($record) => $record->status === ExhibitorStatus::PENDING)
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
