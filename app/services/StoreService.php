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

    public function store($data , $shopIds)
    {
        return $this->storeRepository->store($data, $shopIds);
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