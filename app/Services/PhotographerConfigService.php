<?php

namespace App\Services;

use App\Models\PhotographerConfig;

class PhotographerConfigService
{
    public function create(array $data): PhotographerConfig
    {
        return PhotographerConfig::create($data);
    }

    public function getById(string $uuid): ?PhotographerConfig
    {
        return PhotographerConfig::find($uuid);
    }

    public function getAll()
    {
        return PhotographerConfig::all();
    }

    public function update(string $uuid, array $data): ?PhotographerConfig
    {
        $item = PhotographerConfig::find($uuid);
        if ($item) {
            $item->update($data);
        }
        return $item;
    }

    public function delete(string $uuid): bool
    {
        $item = PhotographerConfig::find($uuid);
        if ($item) {
            return $item->delete();
        }
        return false;
    }
}
