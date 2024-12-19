<?php

namespace App\Enums;

enum ExceptionType: string
{
    case ROLE_NOT_ALLOWED = 'Role not allowed';
    case UNAUTHORIZED = 'Unauthorized access';
    case RESOURCE_NOT_FOUND = 'Resource not found';
    case SERVER_ERROR = 'Internal server error';
}
