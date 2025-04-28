<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Scopes\StateScope;


class Subscription extends Model
{
     protected $fillable = [
        'begin',
        'end',
        'duration',
        // shop_id sera ajouté par la migration
    ];

     protected static function booted()
    {
        static::addGlobalScope(new StateScope());
    }
    /**
     * Relation vers la boutique abonnée
     * Relation "appartient à" (belongsTo)
     */
    public function shop(): BelongsTo
    {
        return $this->belongsTo(Shop::class);
    }
}
