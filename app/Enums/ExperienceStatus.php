<?php

namespace App\Enums;

enum ExperienceStatus: string
{
    case DRAFT     = 'draft';
    case PUBLISHED = 'published';
    case ARCHIVED  = 'archived';
}
