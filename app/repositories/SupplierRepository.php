<?php

namespace App\repositories;

use App\Models\Supplier;
use Illuminate\Support\Facades\Auth;




class SupplierRepository
{
    public function getAll()
    {
        return Supplier::all();
    }

    public function getById($id)
    {
        return Supplier::find($id);
    }

    public function getByName($name)
    {
        return Supplier::where('name', $name)->first();

    }
    public function create($data)
    {
        $data['user_id'] = Auth::user()->id;
        return Supplier::create($data);
    }
    public function update($id, $data)
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
