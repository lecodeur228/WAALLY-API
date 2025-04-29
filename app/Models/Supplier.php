<?php

namespace App\Models;

use App\Models\Scopes\StateScope;
use Illuminate\Database\Eloquent\Model;

class Supplier extends Model
{
     protected $fillable = [
        'nom',
        'phone',
        'owner_id'
    ];

     protected static function booted()
    {
        static::addGlobalScope(new StateScope());
    }

    /**
     * Relation vers le propriétaire du fournisseur
     * Relation "appartient à" (belongsTo)
     */
    public function owner(): BelongsTo
    {
        return $this->belongsTo(User::class, 'owner_id');
    }

    /**
     * Relation vers les articles fournis par ce fournisseur
     * Relation "possède plusieurs" (hasMany)
     */
    public function articles(): HasMany
    {
        return $this->hasMany(Article::class);
    }
}
