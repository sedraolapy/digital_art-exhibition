<?php

namespace App\Enums;

enum CycleStatus: String
{
    case UPCOMING = 'upcoming';
    case ACTIVE = 'active';
    case FINISHED = 'finished';
}
