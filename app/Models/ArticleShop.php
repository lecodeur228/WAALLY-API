<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Scopes\StateScope;


class ArticleShop extends Model
{
    protected $table = 'articles_shop';

    protected $fillable = [
        'quantity',
        // article_id sera ajouté par la migration
        // shop_id sera ajouté par la migration
    ];
     protected static function booted()
    {
        static::addGlobalScope(new StateScope());
    }

    /**
     * Relation vers l'article associé
     * Relation "appartient à" (belongsTo)
     */
    public function article(): BelongsTo
    {
        return $this->belongsTo(Article::class);
    }


    /**
     * Relation vers la boutique associée
     * Relation "appartient à" (belongsTo)
     */
    public function shop(): BelongsTo
    {
        return $this->belongsTo(Shop::class);
    }
}
