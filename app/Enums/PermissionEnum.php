<?php

namespace App\Enums;

enum PermissionEnum: string
{
    // Dashboard
    case ACCESS_ADMIN_PANEL = 'access admin panel';


    // Experiences
    case VIEW_EXPERIENCES = 'view experiences';
    case UPDATE_EXPERIENCES = 'update experiences';


    // Members
    case VIEW_MEMBERS = 'view members';
    case UPDATE_MEMBERS = 'update members';


    // Sponsors
    case VIEW_SPONSORS = 'view sponsors';
    case UPDATE_SPONSORS = 'update sponsors';


    // Statistics
    case VIEW_STATISTICS = 'view statistics';
    case UPDATE_STATISTICS = 'update statistics';


    // Lectures
    case VIEW_LECTURES = 'view lectures';
    case UPDATE_LECTURES = 'update lectures';


    // Exhibitor Profiles
    case VIEW_EXHIBITOR_PROFILES = 'view exhibitor profiles';
    case UPDATE_EXHIBITOR_PROFILES = 'update exhibitor profiles';
    case CREATE_EXHIBITOR_PROFILES = 'craete exhibitor profiles';
    case DELETE_EXHIBITOR_PROFILES = 'delete exhibitor profiles';



    // Exhibitor Applications
    case VIEW_EXHIBITOR_APPLICATIONS = 'view exhibitor applications';
    case UPDATE_EXHIBITOR_APPLICATIONS = 'update exhibitor applications';
    case CREATE_EXHIBITOR_APPLICATIONS = 'craete exhibitor applications';
    case DELETE_EXHIBITOR_APPLICATIONS = 'delete exhibitor applications';

    //wORKSOP
    case VIEW_WORKSHOP = 'view workshop';
    case UPDATE_WORKSHOP = 'update workshop';


    // Check-in
    case PERFORM_CHECK_IN = 'perform check-in';


    public function label(): string
{
    return match ($this) {
        self::ACCESS_ADMIN_PANEL => 'Access Admin Panel',

        self::VIEW_EXPERIENCES => 'View',
        self::UPDATE_EXPERIENCES => 'Update',

        self::VIEW_MEMBERS => 'View',
        self::UPDATE_MEMBERS => 'Update',

        self::VIEW_SPONSORS => 'View',
        self::UPDATE_SPONSORS => 'Update',

        self::VIEW_STATISTICS => 'View',
        self::UPDATE_STATISTICS => 'Update',

        self::VIEW_LECTURES => 'View',
        self::UPDATE_LECTURES => 'Update',

        self::VIEW_EXHIBITOR_PROFILES => 'View',
        self::UPDATE_EXHIBITOR_PROFILES => 'Update',

        self::VIEW_EXHIBITOR_APPLICATIONS => 'View',
        self::UPDATE_EXHIBITOR_APPLICATIONS => 'Update',

        self::PERFORM_CHECK_IN => 'Perform Check-in',
    };

}

public function group(): string
{
    return match ($this) {
        self::ACCESS_ADMIN_PANEL => 'System',

        self::VIEW_EXPERIENCES,
        self::UPDATE_EXPERIENCES => 'Experiences',

        self::VIEW_MEMBERS,
        self::UPDATE_MEMBERS => 'Members',

        self::VIEW_SPONSORS,
        self::UPDATE_SPONSORS => 'Sponsors',

        self::VIEW_STATISTICS,
        self::UPDATE_STATISTICS => 'Statistics',

        self::VIEW_LECTURES,
        self::UPDATE_LECTURES => 'Lectures',

        self::VIEW_EXHIBITOR_PROFILES,
        self::UPDATE_EXHIBITOR_PROFILES => 'Exhibitor Profiles',

        self::VIEW_EXHIBITOR_APPLICATIONS,
        self::UPDATE_EXHIBITOR_APPLICATIONS => 'Exhibitor Applications',

        self::PERFORM_CHECK_IN => 'Check-in',
    };
}
}

