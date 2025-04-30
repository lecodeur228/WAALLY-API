<?php

namespace App\Repositories;


use App\Models\Wallet;


class WalletRepository {

    public function getWallets($shopId)
    {
        return Wallet::where('shop_id',$shopId)->get();
    }

    public function getWallet($id){
        return Wallet::find($id);
    }

    public function store(array $data){
        $wallet = Wallet::create($data);
        return $wallet;
    }

    public function update(array $data,$id){
        $wallet = Wallet::find($id);
        $wallet->update($data);
        return $wallet;
    }

    public function delete($id){
        $wallet = Wallet::find($id);
        $wallet->state = 1;
        $wallet->save();
        return $wallet;
    }
}
