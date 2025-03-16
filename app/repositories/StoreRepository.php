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

    public function getRelatedShops($storeId)
    {
        $store = Store::find($storeId);
        return $store->shops;
    }

    public function getUnrelatedShops($storeId){

        $store = Store::find($storeId);

        // Récupérer les IDs des magazins liés à l'article
        $relatedShopIds = $store->shops()->pluck('shop_id');

        // Récupérer les magazins qui ne sont pas liés à l'article
        $unrelatedShops = Shop::whereNotIn('id', $relatedShopIds)->get();

        return $unrelatedShops;

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

    public function addShops($storeId, $shopIds)
    {
        $store = Store::find($storeId);

        // Ajoute uniquement les nouvelles associations sans dupliquer les existantes
        $store->shops()->syncWithoutDetaching($shopIds);

        // Retourne les magazins associés
        return Shop::whereIn('id', $shopIds)->get();
        
    }

    public function removeShops($storeId, $shopIds)
    {
        $store = Store::find($storeId);
        // Détacher l'article de plusieurs shops en une seule requête
        $store->shops()->detach($shopIds);
        $resposne = $store->shops;

        return $resposne;
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