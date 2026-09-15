<?php

namespace App\Http\Controllers\Media;

use App\Http\Controllers\Controller;
use Filament\Facades\Filament;
use Illuminate\Http\Request;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class PrivateMediaController extends Controller
{
    public function download(Request $request, Media $media)
    {
        $user = $request->user();

        abort_unless($user, 401);

        abort_unless(
            $user->canAccessPanel(Filament::getPanel('admin')),
            403
        );

        abort_unless(
            in_array($media->collection_name, [
                'application_cv',
                'exhibitor_cv',
            ]),
            404
        );

        return $media->toResponse($request);
    }
}