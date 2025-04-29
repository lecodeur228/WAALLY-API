<?php


namespace App\Services;


use App\Repositories\WalletRepository;

class WalletService {

    protected $walletRepository;

    public function __construct(WalletRepository $walletRepository)
    {
        $this->walletRepository = $walletRepository;
    }

    public function getWallets($shopId){
        return $this->walletRepository->getWallets($shopId);
    }

    public function getWallet($id)
    {
        return $this->walletRepository->getWallet($id);
    }

    public function store(array $data){
        return $this->walletRepository->store($data);
    }

    public function update(array $data,$id){
        return $this->walletRepository->update($data,$id);
    }

    public function delete($id){
        return $this->walletRepository->delete($id);
    }
}
