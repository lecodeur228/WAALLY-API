<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Scopes\StateScope;


class Finance extends Model
{
     protected $table = 'finances';

    protected $fillable = [
        'amount',
        'type',
        'motif',
        // wallet_id sera ajouté par la migration
    ];
     protected static function booted()
    {
        static::addGlobalScope(new StateScope());
    }

    /**
     * Relation vers le portefeuille associé
     * Relation "appartient à" (belongsTo)
     */
    public function wallet(): BelongsTo
    {
        return $this->belongsTo(Wallet::class);
    }
}
