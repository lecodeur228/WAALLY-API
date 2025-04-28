<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ShopUser extends Model
{
    protected $table = 'shop_user';

    protected $fillable = ['shop_id', 'user_id', 'role'];
}
