<?php

namespace App\Enums\User;

enum Status: string
{
    case APPROVED = 'approved';
    case PENDING = 'pending';
    case REJECTED = 'rejected';
}
