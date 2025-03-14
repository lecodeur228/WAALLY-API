<?php

namespace App\repositories;

use App\Models\Shop;

class ShopRepository
{
    public function getShops()
    {
        return Shop::with(['user' => function($query) {
            $query->select('id', 'name', 'email', 'phone');
        }])->get(['id', 'name', 'description', 'city', 'longitude', 'latitude', 'created_at', 'updated_at', 'user_id']);
    }

    public function getArticles($id){
        $shop = Shop::find($id);
        return $shop->articles;
    }

    public function getMagazins($id){
        $shop = Shop::find($id);
        return $shop->stores;   
    }
    
    public function store($data)
    {
        return Shop::create($data);
    }

    public function update($data, $id)
    {
        $shop = Shop::find($id);
        $shop->name = $data["name"];
        $shop->description = $data["description"];
        $shop->city = $data["city"];
        $shop->latitude = $data["latitude"];
        $shop->longitude = $data["longitude"];
        $shop->user_id = $data["user_id"];
        $shop->save();
        return $shop;
    }

    public function delete($id)
    {
        $shop = Shop::find($id);
        $shop->state = 1;
        $shop->save();
        return $shop;
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