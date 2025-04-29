<?php

namespace App\Services;

use App\repositories\MagazinRepository;

class MagazinService {

    protected $magazinRepository;
    public function __construct(MagazinRepository $magazinRepository)
    {
        $this->magazinRepository = $magazinRepository;
    }

    public function getMagazines($shopId){
        return $this->magazinRepository->getMagazines($shopId);
    }

    public function getMagazine($id){
        return $this->magazinRepository->getMagazine($id);
    }

    public function store($data){
        return $this->magazinRepository->store($data);
    }

    public function update($data, $id){
        return $this->magazinRepository->update($data, $id);
    }

    public function delete($id){
        return $this->magazinRepository->delete($id);
    }
}
