<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Finance extends Model
{
    protected $fillable = ["montant", "type", "motif", "boutique_id"];

    public function boutique()
    {
        return $this->belongsTo(Shop::class);
    }
  
}
