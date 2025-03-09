<?php

namespace App\Models;

use App\Models\Scopes\StateScope;
use Illuminate\Database\Eloquent\Model;

class Vente extends Model
{

    protected static function booted()
    {
        static::addGlobalScope(new StateScope());
    }

    protected $fillable = ["quantite","user_id","quantite","prix_total"];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function article()
    {
        return $this->belongsTo(Article::class);
    }
}
