<?php

declare(strict_types=1);

namespace App\Enums;

enum AppRole: string
{
    case ADMIN = 'admin';
    case STAFF = 'staff';
    case USER = 'user';
}
