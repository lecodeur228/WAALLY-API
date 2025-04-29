<?php

namespace App\Repositories;


use App\Models\Magazine;


class MagazinRepository
{
    public function getMagazines($shopId){
        return Magazine::where('shop_id', $shopId)->get();
    }

    public function getMagazine($id){
        return Magazine::find($id);
    }


    public function store($data){
        return Magazine::create($data);
    }

   
    public function update($data, $id){
        $magazine = Magazine::find($id);
        $magazine->update($data);
        return $magazine;
    }

    public function delete($id){
        $magazine = Magazine::find($id);
        $magazine->state = 1;
        $magazine->save();
        return $magazine;
    }

}
