<?php

namespace App\Contracts\Services;

interface CategoryServiceInterface
{
    public function create($collection);

    public function update(string $alias, $collection);

    public function delete(string $alias);
}
