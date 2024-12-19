<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Magazin extends Model
{
    protected $fillable = ["name","description","boutique_id"];

    public function boutique()
    {
        return $this->belongsTo(Boutique::class);
    }

    public function inventaires(){
        return $this->hasMany(Inventaire::class);
    }
}
