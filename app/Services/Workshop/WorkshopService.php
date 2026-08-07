<?php

namespace App\Services\Workshop;

use App\Models\Workshop;

class WorkshopService
{
    public function getWorkshops(){

        return $workshop = Workshop::with('media')->get();
    }
}