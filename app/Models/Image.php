<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Image extends Model
{
    protected $fillable = ["image_path","artcle_id"];

    public function article()
    {
        return $this->belongsTo(Article::class);
    }
}
