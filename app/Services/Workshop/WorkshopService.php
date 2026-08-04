<?php

namespace App\Services\Workshop;

use App\Models\Workshop;

class WorkshopService{

    public function getWorkshops(){

        $workshop = Workshop::get();
        return $workshop;
    }
}