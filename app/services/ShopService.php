<?php

namespace App\services;

use App\repositories\ShopRepository;

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

    public function getRelatedArticles($id){
        return $this->shopRepository->getRelatedArticles($id);
    }

    public function getUnrelatedArticles($shopId){

        return $this->shopRepository->getUnrelatedArticles($shopId);
        
    }

    public function getRelatedStores($id) {
        
        return $this->shopRepository->getRelatedStores($id);

    }

    public function getUnrelatedStores($shopId){

        return $this->shopRepository->getUnrelatedStores($shopId);

    }

    public function store($data)
    {
        return $this->shopRepository->store($data);
    }

    public function addArticles($articleIds, $shopId){
        return $this->shopRepository->addArticles($articleIds, $shopId);
    }

    public function addStores($shopId, $storeIds)
    {
        return $this->shopRepository->addStores($shopId, $storeIds);
    }

    public function removeArticles($shopId, $articleIds)
    {
        return $this->shopRepository->removeArticles($shopId, $articleIds);
    }

    public function removeStores($shopId, $storeIds)
    {
        return $this->shopRepository->removeStores($shopId, $storeIds);
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