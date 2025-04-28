<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Scopes\StateScope;


class Wallet extends Model
{
     protected $fillable = [
        'name',
        'balance',
        // shop_id sera ajouté par la migration
    ];

     protected static function booted()
    {
        static::addGlobalScope(new StateScope());
    }
    /**
     * Relation vers la boutique associée
     * Relation "appartient à" (belongsTo)
     */
    public function shop(): BelongsTo
    {
        return $this->belongsTo(Shop::class);
    }

    /**
     * Relation vers les finances associées au portefeuille
     * Relation "possède plusieurs" (hasMany)
     */
    public function finances(): HasMany
    {
        return $this->hasMany(Finance::class);
    }
}
