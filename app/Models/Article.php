<?php

namespace App\Models;

use App\Models\Scopes\StateScope;
use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    protected $fillable = ["name","description","prix_vente","prix_achat","boutique_id"];

    protected static function booted()
    {
        static::addGlobalScope(new StateScope());
    }
    public function shop(){
        return $this->belongsTo(Shop::class);
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
