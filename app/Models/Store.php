<?php

namespace App\Models;

use App\Models\Scopes\StateScope;
use Illuminate\Database\Eloquent\Model;

class Store extends Model
{
    protected $fillable = ["name","description","boutique_id"];

    protected static function booted()
    {
        static::addGlobalScope(new StateScope());
    }

    public function shop()
    {
        return $this->belongsTo(Shop::class);
    }

    public function inventaires(){
        return $this->hasMany(Inventory::class);
    }
}
