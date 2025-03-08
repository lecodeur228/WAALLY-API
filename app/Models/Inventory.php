<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Inventory extends Model
{
    protected $fillable = ['quantite', 'article_id', 'magazin_id'];

    public function article(){
        return $this->belongsTo(Article::class);
    }

    public function magazin(){
        return $this->belongsTo(Store::class);
    }
}
