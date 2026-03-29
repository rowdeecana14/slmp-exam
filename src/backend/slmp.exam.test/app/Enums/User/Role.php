<?php

namespace App\Enums\User;

enum Role: string
{
    case ADMIN = 'admin';
    case USER = 'user';
    case MODERATOR = 'moderator';
}
