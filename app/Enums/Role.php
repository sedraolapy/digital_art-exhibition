<?php

namespace App\Enums;

enum Role : String
{
    case USER = 'user';
    case EXHIBITOR = 'exhibitor';
    case ADMIN = 'admin';
}
