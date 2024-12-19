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
}