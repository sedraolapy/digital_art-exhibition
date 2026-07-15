<?php

namespace App\Services\Exhibitor;

use App\Models\ExhibitorApplication;
use Illuminate\Database\Eloquent\Model;

class SocialLinkService
{
    public function attachLinks(Model $model, array $data): void
    {
        $model->socialLinks()->createMany([
            ['platform' => 'instagram', 'url' => $data['instagram']],
            ['platform' => 'facebook',  'url' => $data['facebook']],
        ]);

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
}