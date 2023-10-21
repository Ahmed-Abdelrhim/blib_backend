<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Repositories\Eloquent\EmployeeRepository;
use App\Repositories\Eloquent\DepartmentRepository;
use App\Repositories\Eloquent\CMSRepository;
use App\Repositories\Eloquent\IndustryRepository;
use App\Repositories\Interfaces\DepartmentRepositoryInterface;
use App\Repositories\Interfaces\CMSRepositoryInterface;
use App\Repositories\Interfaces\EmployeeRepositoryInterface;
use App\Repositories\Interfaces\IndustryRepositoryInterface;
use App\Repositories\Interfaces\CompanyRepositoryInterface;
use App\Repositories\Eloquent\CompanyRepository;
use App\Repositories\Interfaces\AdminRepositoryInterface;
use App\Repositories\Eloquent\AdminRepository;
use App\Repositories\Interfaces\OTPRepositoryInterface;
use App\Repositories\Eloquent\OTPRepository;
use App\Repositories\Eloquent\PlanRepository;
use App\Repositories\Interfaces\PlanRepositoryInterface;

use App\Repositories\Eloquent\EquipmentRepository;
use App\Repositories\Interfaces\EquipmentRepositoryInterface;


class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->bind(EmployeeRepositoryInterface::class, EmployeeRepository::class);
        $this->app->bind(DepartmentRepositoryInterface::class, DepartmentRepository::class);
        $this->app->bind(CMSRepositoryInterface::class, CMSRepository::class);
        $this->app->bind(IndustryRepositoryInterface::class, IndustryRepository::class);
        $this->app->bind(CompanyRepositoryInterface::class, CompanyRepository::class);
        $this->app->bind(AdminRepositoryInterface::class, AdminRepository::class);
        $this->app->bind(OTPRepositoryInterface::class, OTPRepository::class);
        $this->app->bind(PlanRepositoryInterface::class, PlanRepository::class);
        $this->app->bind(EquipmentRepositoryInterface::class, EquipmentRepository::class);
    }
}
