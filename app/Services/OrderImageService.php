<?php

namespace App\Services;

use App\Models\OrderImage;

class OrderImageService
{
    public function create(array $data): OrderImage
    {
        return OrderImage::create($data);
    }

    public function getById(string $uuid): ?OrderImage
    {
        return OrderImage::find($uuid);
    }

    public function getAll()
    {
        return OrderImage::all();
    }

    public function update(string $uuid, array $data): ?OrderImage
    {
        $item = OrderImage::find($uuid);
        if ($item) {
            $item->update($data);
        }
        return $item;
    }

    public function delete(string $uuid): bool
    {
        $item = OrderImage::find($uuid);
        if ($item) {
            return $item->delete();
        }
        return false;
    }
}
