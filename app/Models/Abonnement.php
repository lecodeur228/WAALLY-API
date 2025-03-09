<?php

namespace App\Models;

use App\Models\Scopes\StateScope;
use Illuminate\Database\Eloquent\Model;

class Abonnement extends Model
{
    
    protected static function booted()
    {
        static::addGlobalScope(new StateScope());
    }
}
