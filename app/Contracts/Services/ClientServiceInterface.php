<?php

namespace App\Contracts\Services;

interface ClientServiceInterface
{
    public function createOrUpdate($collection);

    public function create($collection);

    public function update(int $id, $collection);

    public function delete(int $id);
}
