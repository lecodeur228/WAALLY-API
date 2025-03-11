<?php

namespace App\enums;

enum AccountType: string
{
    case ADMIN = 'admin';
    case OWNER = 'owner';
    case SELLER = 'seller';
}