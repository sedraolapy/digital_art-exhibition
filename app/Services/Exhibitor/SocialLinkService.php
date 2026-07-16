<?php

namespace App\Services\Exhibitor;

use App\Models\ExhibitorApplication;
use Illuminate\Database\Eloquent\Model;

class SocialLinkService
{
    public function attachLinks(Model $model, array $data): void
    {
        if (!empty($data['instagram'])) {
            $model->socialLinks()->create([
                'platform' => 'instagram',
                'url'      => $data['instagram'],
            ]);
        }

        if (!empty($data['facebook'])) {
            $model->socialLinks()->create([
                'platform' => 'facebook',
                'url'      => $data['facebook'],
            ]);
        }

        if (!empty($data['linkedin'])) {
            $model->socialLinks()->create([
                'platform' => 'linkedin',
                'url'      => $data['linkedin'],
            ]);
        }

        if (!empty($data['behance'])) {
            $model->socialLinks()->create([
                'platform' => 'behance',
                'url'      => $data['behance'],
            ]);
        }
    }

    public function updateLinks(Model $model, array $data): void
    {
        $model->socialLinks()->delete();

        $this->attachLinks($model, $data);
    }
}