<?php

namespace App\Contracts\Services;

interface MarkServiceInterface
{
    public function create($collection);

    public function update(int $id, $collection);

    public function delete(int $id);
}
