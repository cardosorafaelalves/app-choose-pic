<?php

namespace App\Services;

use App\Models\CustomerConfig;

class CustomerConfigService
{
    public function create(array $data): CustomerConfig
    {
        return CustomerConfig::create($data);
    }

    public function getById(string $uuid): ?CustomerConfig
    {
        return CustomerConfig::find($uuid);
    }

    public function getAll()
    {
        return CustomerConfig::all();
    }

    public function update(string $uuid, array $data): ?CustomerConfig
    {
        $item = CustomerConfig::find($uuid);
        if ($item) {
            $item->update($data);
        }
        return $item;
    }

    public function delete(string $uuid): bool
    {
        $item = CustomerConfig::find($uuid);
        if ($item) {
            return $item->delete();
        }
        return false;
    }
}
