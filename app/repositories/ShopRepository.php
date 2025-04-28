<?php

namespace App\Repositories;

use App\Models\Article;
use App\Models\Shop;
use App\Models\Store;
use Illuminate\Support\Facades\Auth;


class ShopRepository
{
    public function getShops()
    {
        $userConnectedId = Auth::user()->id;
        return Shop::where('owner_id', $userConnectedId)->get();
    }

    public function getShop($id)
    {
        return Shop::find($id);
    }

    // public function getShopsByUser()
    // {
    //     $userId = Auth::user()->id;
    //     return Shop::where('owner_id', $userId)->get();
    // }

    public function store($data)
    {
        $data['owner_id'] = Auth::user()->id;
        return Shop::create($data);
    }



    public function update($data, $id)
    {
        $shop = Shop::find($id);
        $shop->update($data);
        return $shop;
    }

    public function delete($id)
    {
        $shop = Shop::find($id);
        $shop->state = 1;
        $shop->save();
        return $shop;
    }

}
