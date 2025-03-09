<?php

namespace App\Models;

use App\Models\Scopes\StateScope;
use Illuminate\Database\Eloquent\Model;

class Finance extends Model
{
    protected $fillable = ["montant", "type", "motif", "shop_id"];

    protected static function booted()
    {
        static::addGlobalScope(new StateScope());
    }

    public function shop()
    {
        return $this->belongsTo(Shop::class);
    }
  
}
