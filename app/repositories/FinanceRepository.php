<?php

namespace App\Repositories;

use App\Models\Finance;
use App\Models\Wallet;

class FinanceRepository {

    public function getFinances($walletId){
        return Finance::where('wallet_id', $walletId)->get();
    }

    public function getFinance($id){
        return Finance::find($id);
    }

    public function store($data){
        $finance = Finance::create($data);
        $wallet = Wallet::find($data['wallet_id']);
        if($data['type'] == 'deposit'){
            $wallet->balance += $data['amount'];
        }
        if($data['type'] == 'withdrawal'){
            $wallet->balance -= $data['amount'];
        }
        $wallet->save();
        return $finance;
    }



    public function delete($id){
        $finance = Finance::find($id);
        $finance->state = 1;
        $finance->save();
        $wallet = Wallet::find($finance->wallet_id);
        if($finance->type == 'deposit'){
            $wallet->balance -= $finance->amount;
        }
        if($finance->type == 'withdrawal'){
            $wallet->balance += $finance->amount;
        }
        $wallet->save();
        return $finance;
    }
}
