<?php

namespace App\services;

use App\Models\Supplier;
use App\repositories\SupplierRepository;
use Illuminate\Support\Facades\Auth;

class SupplierService
{
    protected $supplierRepository;

    public function __construct(SupplierRepository $supplierRepository)
    {
        $this->supplierRepository = $supplierRepository;
    }

    public function getAllSuppliers()
    {
        return $this->supplierRepository->getAll();
    }

    public function getSupplierById($id)
    {
        return $this->supplierRepository->getById($id);
    }

    public function getSupplierByName($name)
    {
        return $this->supplierRepository->getByName($name);
    }

    public function create($data)
    {
        return $this->supplierRepository->create($data);
    }

    public function update($id, $data)
    {
        return $this->supplierRepository->update($id, $data);
    }

    public function delete($id)
    {
        return $this->supplierRepository->delete($id);
    }

    public function getAllByUserId($userId)
    {
        return $this->supplierRepository->getAllByUserId($userId);
    }

    public function deleteByUserId($userId)
    {
        return $this->supplierRepository->deleteByUserId($userId);
    }
    public function destroy($id)
    {
        return $this->supplierRepository->destroy($id);
    }

}
