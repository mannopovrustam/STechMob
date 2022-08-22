<?php

namespace App\Contracts\Repositories;


interface CardProductInterface
{
    public function trade($collection = []);
    public function income($collection = []);
    public function transfer($collection = []);
    public function returns($collection = []);
    public function search($searchTerm);
}