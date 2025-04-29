<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Scopes\StateScope;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;


class Article extends Model
{
    protected $fillable = [
        'name',
        'description',
        'sale_price',
        'purchase_price',
        'supplier_id',
        'owner_id',
    ];

     protected static function booted()
    {
        static::addGlobalScope(new StateScope());
    }

    /**
     * Relation vers le fournisseur de l'article
     * Relation "appartient à" (belongsTo)
     */
    public function supplier(): BelongsTo
    {
        return $this->belongsTo(Supplier::class);
    }

    /**
     * Relation vers le propriétaire de l'article
     * Relation "appartient à" (belongsTo)
     */
    public function owner(): BelongsTo
    {
        return $this->belongsTo(User::class, 'owner_id');
    }

    /**
     * Relation vers les images associées à l'article
     * Relation "possède plusieurs" (hasMany)
     */
    public function images(): HasMany
    {
        return $this->hasMany(Image::class);
    }

    /**
     * Relation vers les articles dans les magazines (table pivot)
     * Relation "possède plusieurs" (hasMany)
     */
    public function magazineRelations(): HasMany
    {
        return $this->hasMany(ArticleMagazine::class);
    }

    /**
     * Relation vers les articles dans les boutiques (table pivot)
     * Relation "possède plusieurs" (hasMany)
     */
    public function shopRelations(): HasMany
    {
        return $this->hasMany(ArticleShop::class);
    }

    /**
     * Relation vers les approbations de l'article
     * Relation "possède plusieurs" (hasMany)
     */
    public function approvals(): HasMany
    {
        return $this->hasMany(Approve::class);
    }

    /**
     * Relation vers les ventes de l'article
     * Relation "possède plusieurs" (hasMany)
     */
    public function sales(): HasMany
    {
        return $this->hasMany(Sale::class);
    }

    /**
     * Relation "many-to-many" vers les magazines (à travers la table pivot)
     * Relation "appartient à plusieurs" (belongsToMany)
     */
    public function magazines()
    {
        return $this->belongsToMany(Magazine::class, 'articles_magazines')
            ->withPivot('quantity')
            ->withTimestamps();
    }

    /**
     * Relation "many-to-many" vers les boutiques (à travers la table pivot)
     * Relation "appartient à plusieurs" (belongsToMany)
     */
    public function shops()
    {
        return $this->belongsToMany(Shop::class, 'articles_shop')
            ->withPivot('quantity')
            ->withTimestamps();
    }
}
