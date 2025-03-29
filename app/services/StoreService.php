<?php

namespace App\services;

use App\repositories\StoreRepository;

class StoreService
{
    protected $storeRepository;

    public function __construct(StoreRepository $storeRepository)
    {
        $this->storeRepository = $storeRepository;
    }

    public function getStores()
    {
        return $this->storeRepository->getStores();
    }

    public function getRelatedShops($storeId)
    {
        return $this->storeRepository->getRelatedShops($storeId);
    }

    public function getUnrelatedShops($storeId){

        return $this->storeRepository->getUnrelatedShops($storeId);

    }

    public function store($data , $shopIds)
    {
        return $this->storeRepository->store($data, $shopIds);
    }

    public function addShops($storeId, $shopIds)
    {
        return $this->storeRepository->addShops($storeId, $shopIds);
    }

    public function removeShops($storeId, $shopIds)
    {
        return $this->storeRepository->removeShops($storeId, $shopIds);
    }

    public function update($data, $id)
    {
        return $this->storeRepository->update($data, $id);
    }

    public function delete($id)
    {
        return $this->storeRepository->delete($id);
    }
}