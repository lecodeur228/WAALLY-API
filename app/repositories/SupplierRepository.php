<?php

namespace App\Repositories;

use App\Models\Supplier;
use Illuminate\Support\Facades\Auth;




class SupplierRepository
{
    public function getAll()
    {
        return Supplier::where('owner_id', Auth::user()->id)->get();
    }

    public function getById($id)
    {
        return Supplier::where('owner_id', Auth::user()->id)->find($id);
    }

    public function getByName($name)
    {
        return Supplier::where('owner_id', Auth::user()->id)->where('name', $name)->first();

    }
    public function create(array $data)
    {
        $data['owner_id'] = Auth::user()->id;
        return Supplier::create($data);
    }
    public function update(array $data, $id)
    {
        $supplier = Supplier::find($id);
        if ($supplier) {
            $supplier->update($data);
            return $supplier;
        }
        return null;
    }

    public function delete($id)
    {
        $supplier = Supplier::find($id);
        if ($supplier) {
            $supplier->state = 1;
            $supplier->save();
            return true;
        }
        return false;
    }

    public function destroy($id)
    {
        $supplier = Supplier::find($id);
        if ($supplier) {
            $supplier->delete();
            return true;
        }
        return false;
    }




}
