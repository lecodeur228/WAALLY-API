<?php

namespace App\Models;

use App\Models\Scopes\StateScope;
use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    protected $fillable = ["name","description","sale_price","buy_price","shop_id"];

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
        return $this->hasMany(Inventory::class);
    }

    public function ventes(){
        return $this->hasMany(Sale::class);
    }

    public function stocks(){
        return $this->hasMany(Stock::class);
    }
}
