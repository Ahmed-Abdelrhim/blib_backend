<?php

namespace App\Services;

use App\Repositories\Interfaces\IndustryRepositoryInterface;
use App\Services\Interfaces\IndustryServiceInterface;

class IndustryService implements IndustryServiceInterface
{


    private $IndustryRepository;

    public function __construct(IndustryRepositoryInterface $IndustryRepository)
    {
        $this->IndustryRepository = $IndustryRepository;
    }

    public function store($title)
    {
        try {
            $industry = $this->IndustryRepository->store($title);


            return response()->json([
                'status' => 201,
                'message' => 'Data Updated Successfully',
                'data'   => $industry
            ], 201);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => 500,
                'message' => $th->getMessage(),
            ], 500);
        }
    }

    public function index()
    {
        $industries = $this->IndustryRepository->index();

        return response()->json([
            'status' => 200,
            'message' => 'Success',
            'data'   => $industries
        ], 200);
    }
}
