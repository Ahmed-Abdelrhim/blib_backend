<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Services\Interfaces\DropdownServiceInterface;
use App\Services\Interfaces\IndustryServiceInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class DropdownController extends Controller
{
    private $dropdownService;

    public function __construct(DropdownServiceInterface $dropdownService)
    {
        $this->dropdownService = $dropdownService;
    }


    public function __invoke()
    {
        return $this->dropdownService->dropdown();
    }
}
