<?php

namespace App\Enums;

enum AccountType: string
{
    case ADMIN = 'admin';
    case OWNER = 'owner';
    case SELLER = 'seller';
}
