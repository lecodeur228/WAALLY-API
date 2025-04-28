<?php

namespace App\Services;

use App\repositories\CustomerRepository;

class CustomerService {

    protected $customerRepository;

    public function __construct(CustomerRepository $customerRepository)
    {
        $this->customerRepository = $customerRepository;
    }

    public function getCustomers(){
        return $this->customerRepository->getCustomers();
    }

    public function getCustomerById($id){
        return $this->customerRepository->getCustomerById($id);
    }

    public function getCustomerByName($name){
        return $this->customerRepository->getCustomerByName($name);
    }

    public function store(array $data){
        return $this->customerRepository->store($data);
    }

    public function update(array $data, $id){
        return $this->customerRepository->update($data, $id);
    }

    public function delete($id){
        return $this->customerRepository->delete($id);
    }

}
