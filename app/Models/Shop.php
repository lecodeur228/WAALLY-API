<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Scopes\StateScope;


class Shop extends Model
{

     protected $fillable = [
        'name',
        'address',
        // owner_id sera ajouté par la migration
    ];

     protected static function booted()
    {
        static::addGlobalScope(new StateScope());
    }

     /**
     * Relation vers le propriétaire de la boutique
     * Relation "appartient à" (belongsTo)
     */
    public function owner(): BelongsTo
    {
        return $this->belongsTo(User::class, 'owner_id');
    }

    /**
     * Relation vers les articles de la boutique
     * Relation "possède plusieurs" (hasMany)
     */
    public function articles(): HasMany
    {
        return $this->hasMany(ArticleShop::class);
    }

    /**
     * Relation vers les magazines de la boutique
     * Relation "possède plusieurs" (hasMany)
     */
    public function magazines(): HasMany
    {
        return $this->hasMany(Magazine::class);
    }

    /**
     * Relation vers les abonnements de la boutique
     * Relation "possède plusieurs" (hasMany)
     */
    public function subscriptions(): HasMany
    {
        return $this->hasMany(Subscription::class);
    }

    /**
     * Relation vers les portefeuilles de la boutique
     * Relation "possède plusieurs" (hasMany)
     */
    public function wallets(): HasMany
    {
        return $this->hasMany(Wallet::class);
    }

    /**
     * Relation vers les approbations de la boutique
     * Relation "possède plusieurs" (hasMany)
     */
    public function approvals(): HasMany
    {
        return $this->hasMany(Approve::class);
    }

    /**
     * Relation vers les ventes effectuées dans la boutique
     * Relation "possède plusieurs" (hasMany)
     */
    public function sales(): HasMany
    {
        return $this->hasMany(Sale::class);
    }

    // /**
    //  * Relation vers les utilisateurs associés à la boutique
    //  * Relation "possède plusieurs" (hasMany)
    //  */
    // public function users(): HasMany
    // {
    //     return $this->hasMany(User::class);
    // }

     public function users()
    {
        return $this->belongsToMany(User::class)
                    ->using(ShopUser::class)
                    ->withPivot('role')
                    ->withTimestamps();
    }
}
