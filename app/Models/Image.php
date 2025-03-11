<?php

namespace App\Models;

use App\Models\Scopes\StateScope;
use Illuminate\Database\Eloquent\Model;

class Image extends Model
{
    protected $fillable = ["image_path","artcle_id"];

    protected static function booted()
    {
        static::addGlobalScope(new StateScope());
    }

    public function article()
    {
        return $this->belongsTo(Article::class);
    }
}
