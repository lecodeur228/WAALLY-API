<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Stock extends Model
{
    protected $fillable = ["quantite", "article_id","boutique_id" ];

    public function article()
    {
        return $this->belongsTo(Article::class);
    }

    public function boutique()
    {
        return $this->belongsTo(Boutique::class);
    }
}
