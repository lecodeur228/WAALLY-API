<?php

namespace App\Services;

use App\repositories\SalesRepository;

class SaleService {
    protected $saleRepository;
    public function __construct(SalesRepository $saleRepository)
    {
        $this->saleRepository = $saleRepository;
    }

    public function getSales($shopId){
        return $this->saleRepository->getSales($shopId);
    }

    public function store($data){
        return $this->saleRepository->store($data);
    }

    public function delete($saleId){
        return $this->saleRepository->delete($saleId);
    }
}
