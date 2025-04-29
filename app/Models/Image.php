<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Scopes\StateScope;


class Image extends Model
{
     protected $fillable = [
        'image_path',
        'article_id'
    ];

     protected static function booted()
    {
        static::addGlobalScope(new StateScope());
    }

    /**
     * Relation vers l'article associé à l'image
     * Relation "appartient à" (belongsTo)
     */
    public function article(): BelongsTo
    {
        return $this->belongsTo(Article::class);
    }
}
