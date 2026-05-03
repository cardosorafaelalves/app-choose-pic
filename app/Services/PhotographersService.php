<?php

namespace App\Services;

use App\Models\Photographer;

class PhotographersService
{
    public function __construct()
    {
        //
    }

    /**
     * Create a new Photographer
     */
    public function create(array $data): Photographer
    {
        return Photographer::create($data);
    }

    /**
     * Get a Photographer by UUID
     */
    public function getById(string $uuid): ?Photographer
    {
        return Photographer::find($uuid);
    }

    /**
     * Get all Photographers
     */
    public function getAll(): \Illuminate\Database\Eloquent\Collection
    {
        return Photographer::all();
    }

    /**
     * Update a Photographer by UUID
     */
    public function update(string $uuid, array $data): ?Photographer
    {
        $photographer = Photographer::find($uuid);
        if ($photographer) {
            $photographer->update($data);
        }
        return $photographer;
    }

    /**
     * Delete a Photographer by UUID
     */
    public function delete(string $uuid): bool
    {
        $photographer = Photographer::find($uuid);
        if ($photographer) {
            return $photographer->delete();
        }
        return false;
    }
}
