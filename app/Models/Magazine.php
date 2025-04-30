<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Scopes\StateScope;


class Magazine extends Model
{
     protected $fillable = [
        'name',
        'description',
        'shop_id'
    ];

     protected static function booted()
    {
        static::addGlobalScope(new StateScope());
    }

    /**
     * Relation vers la boutique propriétaire du magazine
     * Relation "appartient à" (belongsTo)
     */
    public function shop(): BelongsTo
    {
        return $this->belongsTo(Shop::class);
    }

    /**
     * Relation vers les articles dans le magazine (table pivot)
     * Relation "possède plusieurs" (hasMany)
     */
    public function articleRelations(): HasMany
    {
        return $this->hasMany(ArticleMagazine::class);
    }

    /**
     * Relation "many-to-many" vers les articles (à travers la table pivot)
     * Relation "appartient à plusieurs" (belongsToMany)
     */
    public function articles()
    {
        return $this->belongsToMany(Article::class, 'articles_magazines')
            ->withPivot('quantity')
            ->withTimestamps();
    }

    public function approvs() : HasMany
    {
        return $this->hasMany(Approv::class);
    }
}
