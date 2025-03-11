<?php

namespace App\Models;

use App\Models\Scopes\StateScope;
use Illuminate\Database\Eloquent\Model;

class Stock extends Model
{

    protected static function booted()
    {
        static::addGlobalScope(new StateScope());
    }
    protected $fillable = ["quantite", "article_id","boutique_id" ];

    public function article()
    {
        return $this->belongsTo(Article::class);
    }

    public function shop()
    {
        return $this->belongsTo(Shop::class);
    }
}
