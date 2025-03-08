<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    protected $fillable = ["name","description","prix_vente","prix_achat","boutique_id"];

    public function boutique(){
        return $this->belongsTo(Shop::class);
    }

    public function images(){
        return $this->hasMany(Image::class);
    }

    public function inventaires(){
        return $this->hasMany(Inventory::class);
    }

    public function ventes(){
        return $this->hasMany(Sale::class);
    }

    public function stocks(){
        return $this->hasMany(Stock::class);
    }
}
