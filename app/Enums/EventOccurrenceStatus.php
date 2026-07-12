<?php

namespace App\Enums;

enum EventOccurrenceStatus: string
{
    case UPCOMING = 'upcoming';
    case ACTIVE = 'active';
    case FINISHED = 'finished';
}
