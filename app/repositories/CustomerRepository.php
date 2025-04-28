<?php

namespace App\Repositories;

use App\Models\Customer;
use Illuminate\Support\Facades\Auth;

class CustomerRepository {


    public function getCustomers(){
        return Customer::where('owner_id', Auth::user()->id)->get();
    }

    public function getCustomerById($id){
        return Customer::where('owner_id', Auth::user()->id)->find($id);
    }
    public function getCustomerByName($name){
        return Customer::where('owner_id', Auth::user()->id)->where('name', $name)->first();
    }

    public function store(array $data){
        $data['owner_id'] = Auth::user()->id;
        $customer = Customer::create($data);
        return $customer;
    }

    public function update(array $data, $id){
        $data['owner_id'] = Auth::user()->id;
        $customer = Customer::find($id);
        $customer->update($data);
        return $customer;
    }

    public function delete($id){
        $customer = Customer::find($id);
        $customer->state = 1;
        $customer->save();
        return $customer;
    }

}
