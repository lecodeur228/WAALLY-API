<?php

namespace App\Repositories;

use App\Models\Shop;

class ShopRepository
{
    public function getShops()
    {
        return Shop::with(['user' => function($query) {
            $query->select('id', 'name', 'email', 'phone');
        }])->get(['id', 'name', 'address', 'created_at', 'updated_at']);
    }
    public function store($data)
    {
        return Shop::create($data);
    }

    public function update($data, $id)
    {
        return Shop::where('id', $id)->update($data);
    }

    public function delete($id)
    {
        return Shop::where('id', $id)->delete();
    }

}