<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Services\EmployeeService;
use App\Services\Interfaces\EmployeeServiceInterface;
use App\Services\Interfaces\EmployeeAuthServiceInterface;
use App\Services\EmployeeAuthService;
use App\Services\Interfaces\IndustryServiceInterface;
use App\Services\IndustryService;
use App\Services\Interfaces\CompanyServiceInterface;
use App\Services\CompanyService;
use App\Services\Interfaces\AdminAuthServiceInterface;
use App\Services\AdminAuthService;
use App\Services\CMSService;
use App\Services\DepartmentService;
use App\Services\DropdownService;
use App\Services\EmployeeDashboardService;
use App\Services\EmployeeExcelService;
use App\Services\Interfaces\CMSServiceInterface;
use App\Services\Interfaces\DepartmentServiceInterface;
use App\Services\Interfaces\DropdownServiceInterface;
use App\Services\Interfaces\EmployeeDashboardServiceInterface;
use App\Services\Interfaces\EmployeeExcelServiceInterface;
use App\Services\Interfaces\PlanServiceInterface;
use App\Services\MailService;
use App\Services\Interfaces\MailServiceInterface;
use App\Services\PlanService;

class ServicesServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->bind(EmployeeServiceInterface::class, EmployeeService::class);
        $this->app->bind(CMSServiceInterface::class, CMSService::class);
        $this->app->bind(EmployeeDashboardServiceInterface::class, EmployeeDashboardService::class);
        $this->app->bind(DepartmentServiceInterface::class, DepartmentService::class);
        $this->app->bind(EmployeeAuthServiceInterface::class, EmployeeAuthService::class);
        $this->app->bind(EmployeeServiceInterface::class, EmployeeService::class);
        $this->app->bind(IndustryServiceInterface::class, IndustryService::class);
        $this->app->bind(CompanyServiceInterface::class, CompanyService::class);
        $this->app->bind(AdminAuthServiceInterface::class, AdminAuthService::class);
        $this->app->bind(PlanServiceInterface::class, PlanService::class);
        $this->app->bind(MailServiceInterface::class, MailService::class);
        $this->app->bind(DropdownServiceInterface::class, DropdownService::class);
        $this->app->bind(EmployeeExcelServiceInterface::class, EmployeeExcelService::class);
    }
}
