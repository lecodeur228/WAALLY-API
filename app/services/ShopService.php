<?php

namespace App\Services;

use App\Repositories\ShopRepository;

class ShopService
{
    protected $shopRepository;
    public function __construct(ShopRepository $shopRepository)
    {
        $this->shopRepository = $shopRepository;
    }
    
    public function getShops()
    {
        return $this->shopRepository->getShops();
    }

    public function getArticles($id){
        return $this->shopRepository->getArticles($id);
    }

    public function getMagazins($id) {
        
        return $this->shopRepository->getMagazins($id);

    }

    public function store($data)
    {
        return $this->shopRepository->store($data);
    }

    public function update($data, $id)
    {
        return $this->shopRepository->update($data, $id);
    }

    public function delete($id)
    {
        return $this->shopRepository->delete($id);
    }

    public function assignUserToShop($shopId, $userId)
    {
        return $this->shopRepository->assignUserToShop($shopId, $userId);
    }
}