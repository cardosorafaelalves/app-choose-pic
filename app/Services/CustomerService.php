<?php

namespace App\Services;

use App\Models\Customer;

class CustomerService
{
    public function create(array $data): Customer
    {
        return Customer::create($data);
    }

    public function getById(string $uuid): ?Customer
    {
        return Customer::find($uuid);
    }

    public function getAll()
    {
        return Customer::all();
    }

    public function update(string $uuid, array $data): ?Customer
    {
        $item = Customer::find($uuid);
        if ($item) {
            $item->update($data);
        }
        return $item;
    }

    public function delete(string $uuid): bool
    {
        $item = Customer::find($uuid);
        if ($item) {
            return $item->delete();
        }
        return false;
    }
}
