<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Scopes\StateScope;


class Approv extends Model
{
     protected $fillable = [
        'quantity',
        'type',
        'article_id',
        'shop_id',
        'magazine_id'
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

    public function magazine(): BelongsTo
    {
        return $this->belongsTo(Magazine::class);
    }
}
