<?php

namespace App\Enums;

enum CheckInType: string
{
    case EVENT = 'event';
    case LECTURE = 'lecture';
    case WORKSHOP = 'workshop';
}