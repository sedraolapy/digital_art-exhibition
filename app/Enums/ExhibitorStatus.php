<?php

namespace App\Enums;

enum ExhibitorStatus: string
{
    case PENDING = 'pending';                 
    case REJECTED = 'rejected';
    case APPROVED_INITIAL = 'approved_initial';
    case APPROVED_FINAL = 'approved_final';
}
