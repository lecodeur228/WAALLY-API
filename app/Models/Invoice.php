<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Scopes\StateScope;


class Invoice extends Model
{
     protected $fillable = [
        'ref',
        // customer_id sera ajouté par la migration
    ];

     protected static function booted()
    {
        static::addGlobalScope(new StateScope());
    }

    /**
     * Relation vers le client associé à la facture
     * Relation "appartient à" (belongsTo)
     */
    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class);
    }

    /**
     * Relation vers les ventes associées à la facture
     * Relation "possède plusieurs" (hasMany)
     */
    public function sales(): HasMany
    {
        return $this->hasMany(Sale::class);
    }
}
