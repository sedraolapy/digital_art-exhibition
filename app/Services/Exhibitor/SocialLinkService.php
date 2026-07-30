<?php

namespace App\Services\Exhibitor;

use Illuminate\Database\Eloquent\Model;

class SocialLinkService
{
    public const PLATFORMS = ['instagram', 'facebook', 'linkedin', 'behance'];

    public function attachLinks(Model $model, array $data): void
    {
        foreach (self::PLATFORMS as $platform) {
            if (! empty($data[$platform])) {
                $model->socialLinks()->create([
                    'platform' => $platform,
                    'url'      => $data[$platform],
                ]);
            }
        }
    }

    public function updateLinks(Model $model, array $data): void
    {
        $model->socialLinks()->delete();

        $this->attachLinks($model, $data);
    }
}
