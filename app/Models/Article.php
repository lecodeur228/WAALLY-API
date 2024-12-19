<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    protected $fillable = ["name","description","prix_vente","prix_achat","boutique_id"];

    public function boutique(){
        return $this->belongsTo(Boutique::class);
    }

    public function images(){
        return $this->hasMany(Image::class);
    }

    public function inventaires(){
        return $this->hasMany(Inventaire::class);
    }

    public function ventes(){
        return $this->hasMany(Vente::class);
    }

    public function stocks(){
        return $this->hasMany(Stock::class);
    }
}
