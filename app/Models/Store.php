<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Store extends Model
{
    protected $fillable = ["name","description","boutique_id"];

    public function boutique()
    {
        return $this->belongsTo(Shop::class);
    }

    public function inventaires(){
        return $this->hasMany(Inventory::class);
    }
}
