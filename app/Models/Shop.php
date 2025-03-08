<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Shop extends Model
{
    
    protected $fillable = ["name","address","city","latitude","longitude","user_id"];

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function articles(){
        return $this->hasMany(Article::class);
    }

    public function magazins(){
        return $this->hasMany(Store::class);
    }
    
    public function stocks(){
        return $this->hasMany(Stock::class);
    }
}
