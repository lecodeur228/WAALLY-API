<?php

namespace App\Repositories;

use App\Models\Boutique;

class ShopRepository
{
    public function getShops()
    {
        return Boutique::with(['user' => function($query) {
            $query->select('id', 'name', 'email', 'phone');
        }])->get(['id', 'name', 'address', 'created_at', 'updated_at']);
    }
    public function store($data)
    {
        return Boutique::create($data);
    }

    public function update($data, $id)
    {
        return Boutique::where('id', $id)->update($data);
    }

    public function delete($id)
    {
        return Boutique::where('id', $id)->delete();
    }

}