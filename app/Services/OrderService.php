<?php

namespace App\Services;

use App\Models\Order;

class OrderService
{
    public function create(array $data): Order
    {
        return Order::create($data);
    }

    public function getById(string $uuid): ?Order
    {
        return Order::find($uuid);
    }

    public function getAll()
    {
        return Order::all();
    }

    public function update(string $uuid, array $data): ?Order
    {
        $item = Order::find($uuid);
        if ($item) {
            $item->update($data);
        }
        return $item;
    }

    public function delete(string $uuid): bool
    {
        $item = Order::find($uuid);
        if ($item) {
            return $item->delete();
        }
        return false;
    }
}
