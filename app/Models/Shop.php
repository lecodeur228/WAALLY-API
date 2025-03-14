<?php

namespace App\Models;

use App\Models\Scopes\StateScope;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Shop extends Model
{
    use HasFactory;

    protected $fillable = ["name","description","city","latitude","longitude","user_id"];

    protected static function booted()
    {
        static::addGlobalScope(new StateScope());
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function articles(){
        return $this->belongsToMany(Article::class);
    }

    public function stocks(){
        return $this->hasMany(Stock::class);
    }

    public function stores() {
        return $this->belongsToMany(Store::class);
    }
}
