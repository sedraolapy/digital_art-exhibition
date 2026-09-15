<?php

namespace App\Services\Exhibitor;

use App\Enums\ExhibitorStatus;
use App\Events\ExhibitorApplicationStatusChanged;
use App\Models\ExhibitorApplication;
use App\Models\User;
use App\Services\Event\EventService;
use Illuminate\Support\Facades\DB;
use App\Services\Media\MediaStorageService;
use Illuminate\Support\Str;

class ExhibitorApplicationService
{
    public function __construct(
        private SocialLinkService $socialLinkService,
        private EventService $eventService,
        private ExhibitorProfileService $exhibitorProfileService,
        private MediaStorageService $mediaStorageService,
    ) {}

    public function create(User $user, array $data): ExhibitorApplication
    {
        $application = DB::transaction(function () use ($user, $data) {
            $currentEvent = $this->eventService->getActiveEvent();
    
            if (! $currentEvent) {
                throw new \Exception(
                    'لا يوجد حدث فعّال حالياً لتقديم طلب عرض.'
                );
            }
    
            if ($this->applicationExists($user->id, $currentEvent->id)) {
                throw new \Exception(
                    'لقد قمت بتقديم طلب لهذه الفعالية مسبقًا.'
                );
            }
    
            $application = ExhibitorApplication::create([
                'user_id'             => $user->id,
                'event_occurrence_id' => $currentEvent->id,
                'category_id'         => $data['category_id'],
                'experience_years'    => $data['experience_years'],
                'portfolio_url'       => $data['portfolio_url'],
                'bio'                 => $data['bio'],
                'status'              => ExhibitorStatus::PENDING->value,
            ]);
    
            $this->socialLinkService->attachLinks(
                $application,
                $data
            );
    
            return $application;
        });
    
        try {
            $this->storeImage($application,$data['image']);
    
            $this->storeCvFile($application,$data['cv_file']);

        } catch (\Throwable $e) {
            $application->delete();
            throw $e;
        }
    
        return $application;
    }
    public function getApplicationStatus(int $userId, int $eventOccurrenceId)
    {
        $applicationStatus =  ExhibitorApplication::where('user_id', $userId)
            ->where('event_occurrence_id', $eventOccurrenceId)
            ->value('status');
        return $applicationStatus;
    }

    private function applicationExists(int $userId, int $eventOccurrenceId): bool
    {
        return ExhibitorApplication::where('user_id', $userId)
            ->where('event_occurrence_id', $eventOccurrenceId)
            ->exists();
    }

    private function storeCvFile(ExhibitorApplication $application, $cvFile): void
    {
        $application->clearMediaCollection('application_cv');
        $application->addMedia($cvFile)
            ->usingFileName(Str::ulid() . '.' . $cvFile->getClientOriginalExtension())
            ->toMediaCollection('application_cv');
    }

    private function storeImage(ExhibitorApplication $application, $image): void
    {
        $application->clearMediaCollection('application_image');
    
        $this->mediaStorageService->storeImage(
            $application,
            $image,
            'application_image'
        );
    }


    public function approveInitial(ExhibitorApplication $application): void 
    {
        DB::transaction(function () use ($application) {

            $application = ExhibitorApplication::whereKey($application->id)
                ->lockForUpdate()
                ->firstOrFail();

            if ($application->status !== ExhibitorStatus::PENDING) {
                throw new \Exception(
                    'لا يمكن قبول الطلب بحالته الحالية.'
                );
            }

            $application->update([
                'status' => ExhibitorStatus::APPROVED_INITIAL->value,
            ]);

            event(new ExhibitorApplicationStatusChanged(
                $application,
                'تم قبول طلبك بشكل مبدئي، وسيتم التواصل معك لاحقًا لمتابعة الإجراءات.'
            ));
        });
    }

    public function reject(ExhibitorApplication $application): void 
    {
        DB::transaction(function () use ($application) {

            $application = ExhibitorApplication::whereKey($application->id)
                ->lockForUpdate()
                ->firstOrFail();

            if (! in_array($application->status, [
                ExhibitorStatus::PENDING,
                ExhibitorStatus::APPROVED_INITIAL,
            ], true)) {
                throw new \Exception(
                    'لا يمكن رفض الطلب بحالته الحالية.'
                );
            }

            $application->update([
                'status' => ExhibitorStatus::REJECTED->value,
            ]);

            event(new ExhibitorApplicationStatusChanged(
                $application,
                'نعتذر، لقد تم رفض طلبك. نتمنى لك التوفيق في الفرص القادمة.'
            ));
        });
    }


    public function approveFinal(ExhibitorApplication $application): void 
    {
        DB::transaction(function () use ($application) {

            $application = ExhibitorApplication::whereKey($application->id)
                ->lockForUpdate()
                ->firstOrFail();

            if ($application->status !== ExhibitorStatus::APPROVED_INITIAL) {
                throw new \Exception(
                    'لا يمكن اعتماد الطلب نهائياً بحالته الحالية.'
                );
            }

            $this->exhibitorProfileService->createFromApplication($application);

            $application->update([
                'status' => ExhibitorStatus::APPROVED_FINAL->value,
            ]);

            event(new ExhibitorApplicationStatusChanged(
                $application,
                'تهانينا! تم قبول طلبك بشكل نهائي، وتم إنشاء ملفك كعارض في النظام. يمكنك الآن مراجعة ملفك كعارض من خلال الموقع.'
            ));
        });
    }



}
