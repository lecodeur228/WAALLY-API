<?php

namespace App\Services;

use App\repositories\SaleRepository;

class SaleService {
    protected $saleRepository;
    public function __construct(SaleRepository $saleRepository)
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
