<?php

namespace App\Models;

use App\Models\Scopes\StateScope;
use Illuminate\Database\Eloquent\Model;

class Inventaire extends Model
{
    protected $fillable = ['quantite', 'article_id', 'magazin_id'];

    protected static function booted()
    {
        static::addGlobalScope(new StateScope());
    }

    public function article(){
        return $this->belongsTo(Article::class);
    }

    public function magazin(){
        return $this->belongsTo(Magazin::class);
    }
}
