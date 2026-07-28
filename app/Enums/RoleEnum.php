<?php

namespace App\Enums;

enum RoleEnum: string
{
// Website
    case USER = 'user';
    case EXHIBITOR = 'exhibitor';

// Dashboard
    case SUPER_ADMIN = 'super admin';
    case CONTENT_MANAGER = 'content manager';
    case EXHIBITOR_APPLICATION_MANAGER = 'exhibitor application manager';
    case ORGANIZER = 'organizer';
}