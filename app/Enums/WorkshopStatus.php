<?php

namespace App\Enums;

enum WorkshopStatus: String
{
    case UPCOMING = 'upcoming';
    case ACTIVE = 'active';
    case FINISHED = 'finished';
}
