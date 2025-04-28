<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Scopes\StateScope;


class Customer extends Model
{

     protected $fillable = [
        'name',
        'phone',
        // owner_id sera ajouté par la migration
    ];
     protected static function booted()
    {
        static::addGlobalScope(new StateScope());
    }

    /**
     * Relation vers le propriétaire du client
     * Relation "appartient à" (belongsTo)
     */
    public function owner(): BelongsTo
    {
        return $this->belongsTo(User::class, 'owner_id');
    }

    /**
     * Relation vers les factures du client
     * Relation "possède plusieurs" (hasMany)
     */
    public function invoices(): HasMany
    {
        return $this->hasMany(Invoice::class);
    }
}
