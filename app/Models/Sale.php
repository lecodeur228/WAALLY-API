<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Models\Scopes\StateScope;

class Sale extends Model
{
    protected $fillable = [
        'quantity',
        'total_price',
        'article_id' ,
        'shop_id' ,
        'invoice_id',
        'sale_price',
        'seller_id',
        'customer_id',
    ];

    protected static function booted()
    {
        static::addGlobalScope(new StateScope());
    }

    /**
     * Relation vers l'article vendu
     * Relation "appartient à" (belongsTo)
     */
    public function article(): BelongsTo
    {
        return $this->belongsTo(Article::class);
    }

    /**
     * Relation vers la boutique où a eu lieu la vente
     * Relation "appartient à" (belongsTo)
     */
    public function shop(): BelongsTo
    {
        return $this->belongsTo(Shop::class);
    }

    /**
     * Relation vers la facture associée
     * Relation "appartient à" (belongsTo)
     */
    public function invoice(): BelongsTo
    {
        return $this->belongsTo(Invoice::class);
    }

    public function seller(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function customer(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
