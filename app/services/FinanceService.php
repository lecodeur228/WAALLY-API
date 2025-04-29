<?php

namespace App\Services;

use App\repositories\FinanceRepository;

class FinanceService {

    protected $financeRepository;
    public function __construct(FinanceRepository $financeRepository)
    {
        $this->financeRepository = $financeRepository;
    }

    public function getFinances($walletId){
        return $this->financeRepository->getFinances($walletId);
    }

    public function getFinance($id){
        return $this->financeRepository->getFinance($id);
    }

    public function store($data){
        return $this->financeRepository->store($data);
    }

    public function delete($id){
        return $this->financeRepository->delete($id);
    }
}
