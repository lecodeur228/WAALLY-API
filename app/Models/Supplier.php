<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Scopes\StateScope;
use App\Models\Article;

class Supplier extends Model
{
    protected $fillable = ['name', 'phone', 'user_id'];

     protected static function booted()
    {
        static::addGlobalScope(new StateScope());
    }

    public function articles()
    {
        return $this->hasMany(Article::class);
    }



}
