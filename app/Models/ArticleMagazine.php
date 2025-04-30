<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Scopes\StateScope;


class ArticleMagazine extends Model
{

    protected $fillable = [
        'quantity',
        'article_id',
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
     * Relation vers le magazine associé
     * Relation "appartient à" (belongsTo)
     */
    public function magazine(): BelongsTo
    {
        return $this->belongsTo(Magazine::class);
    }
}
