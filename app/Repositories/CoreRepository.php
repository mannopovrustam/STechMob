<?php

namespace App\Repositories;

use App\Models\Currency;

abstract class CoreRepository
{
    protected $model;

    protected $currency;

    protected $language;

    protected $updatedDate;

    /**
     * CoreRepository constructor.
     */
    public function __construct()
    {
        $this->model = app($this->getModelClass());
    }

    abstract protected function getModelClass();

    protected function model()
    {
        return clone $this->model;
    }

    /**
     * Set default Currency
     */
    protected function setCurrency()
    {
        return $this->currency ?? Currency::where('default', 1)->pluck('id')->first();
    }

    /**
     * Set default Language
     */
    protected function setLanguage()
    {
        return $this->language ?? Language::where('default', 1)->pluck('locale')->first();
    }

    /**
     * Set Updated Date
     */
    protected function setUpdatedDate()
    {
        return $this->updatedDate;
    }
}
