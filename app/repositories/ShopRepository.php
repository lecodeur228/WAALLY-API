<?php

namespace App\Repositories;

use App\Models\Shop;

class ShopRepository
{
    public function getShops()
    {
        return Shop::with(['user' => function($query) {
            $query->select('id', 'name', 'email', 'phone');
        }])->get(['id', 'name', 'description', 'city', 'longitude', 'latitude', 'created_at', 'updated_at', 'user_id']);
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
        return Shop::where('id', $id)->update(['state' => 1]);
    }


    public function assignUserToShop($shopId, $userId)
    {
        $shop = Shop::find($shopId);
        if ($shop) {
            $shop->user_id = $userId;
            $shop->save();
            return $shop;
        }
        return null;
    }
}