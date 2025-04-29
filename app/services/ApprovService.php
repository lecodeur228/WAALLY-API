<?php

namespace App\Services;

use App\repositories\ApprovRepository;

class ApprovService {

    protected $approvalRepository;
    public function __construct(ApprovRepository $approvalRepository)
    {
        $this->approvalRepository = $approvalRepository;
    }

    public function getApprovals($shopId){
        return $this->approvalRepository->getApprovals($shopId);
    }

    public function store($data){
        return $this->approvalRepository->store($data);
    }

    public function delete($id){
        return $this->approvalRepository->delete($id);
    }
}
