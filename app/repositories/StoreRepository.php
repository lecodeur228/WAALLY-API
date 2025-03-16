<?php

namespace App\repositories;

use App\Models\Shop;
use App\Models\Store;

class StoreRepository
{
    public function getStores()
    {
        return Store::all();
    }

    public function getShops($storeId)
    {
        $store = Store::find($storeId);
        return $store->shops;
    }

    public function store($data, $shopIds)
    {
        $store = Store::create($data);
        foreach ($shopIds as $shopId) {
            $store->shops()->attach($shopId);
            $response[$shopId] = $store;
        }
        return $response;
    }

    public function update($data, $id)
    {
        $store = Store::find($id);
        $store->name = $data["name"];
        $store->description = $data["description"];
        $store->save();
        return $store;
    }

    public function delete($id)
    {
        $store = Store::find($id);
        $shops = $store->shops;
        $store->state = 1;
        $store->save();
        if($shops){
            foreach ($shops as $shop) {
                $store->shops()->detach($shop->id);
            }
        }
        return $store;
    }
}