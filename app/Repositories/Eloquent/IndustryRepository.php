<?php

namespace App\Repositories\Eloquent;

use App\Models\Industry;
use App\Repositories\Interfaces\IndustryRepositoryInterface;

class IndustryRepository implements IndustryRepositoryInterface
{
    /**
     * @var Model
     */
    protected $model;

    /**
     * IndustryRepository constructor.
     *
     * @param Industry $model
     */
    public function __construct(Industry $model)
    {
        $this->model = $model;
    }

    public function store($title){
        $industry = $this->model->create([
            'title' => $title
        ]);

        return $industry;
    }

    public function index(){
        $industries = $this->model->orderBy('title', 'ASC')->get();

        return $industries;
    }
}
