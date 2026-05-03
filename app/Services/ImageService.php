<?php

namespace App\Services;

use App\Models\Image;

class ImageService
{
    public function create(array $data): Image
    {
        $dataImage = [
            'uuid' => (string) \Illuminate\Support\Str::uuid(),
            'customer_uuid' => $data['customer_uuid'],
            'photographer_uuid' => $data['photographer_uuid'],
            'file_url' => $data['file_url'],
            'created_at' => now(),
            'updated_at' => now()
        ];

        return Image::create($dataImage);
    }

    public function getById(string $uuid): ?Image
    {
        return Image::find($uuid);
    }

    public function getAll()
    {
        return Image::all();
    }

    public function update(string $uuid, array $data): ?Image
    {
        $item = Image::find($uuid);

        if ($item) {
            $item->update($data);
        }

        return $item;
    }

    public function delete(string $uuid): bool
    {
        $item = Image::find($uuid);

        if ($item) {
            return $item->delete();
        }

        return false;
    }
}
