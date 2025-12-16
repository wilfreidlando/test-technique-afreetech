<?php

namespace App\Services;

use App\Models\Succursale;

class SuccursaleService
{
    public function getAll()
    {
        return Succursale::with('users')->get();
    }

    public function getById($id)
    {
        return Succursale::with(['users', 'clients'])->findOrFail($id);
    }

    public function create(array $data)
    {
        return Succursale::create($data);
    }

    public function update($id, array $data)
    {
        $succursale = Succursale::findOrFail($id);
        $succursale->update($data);
        return $succursale;
    }

    public function delete($id)
    {
        $succursale = Succursale::findOrFail($id);
        $succursale->delete();
        return true;
    }
}
