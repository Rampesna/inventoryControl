<?php

namespace App\Providers;


use App\Interfaces\Eloquent\IDeviceCategoryService;
use App\Interfaces\Eloquent\IDevicePackageService;
use App\Interfaces\Eloquent\IDeviceService;
use App\Interfaces\Eloquent\IDeviceStatusService;
use App\Interfaces\Eloquent\IEmployeeService;
use App\Interfaces\Eloquent\IPersonalAccessTokenService;
use App\Interfaces\Eloquent\IUserService;
use App\Services\Eloquent\DeviceCategoryService;
use App\Services\Eloquent\DevicePackageService;
use App\Services\Eloquent\DeviceService;
use App\Services\Eloquent\DeviceStatusService;
use App\Services\Eloquent\EmployeeService;
use App\Services\Eloquent\PersonalAccessTokenService;
use App\Services\Eloquent\UserService;
use Illuminate\Support\ServiceProvider;

class InterfaceServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(IUserService::class, UserService::class);
        $this->app->bind(IEmployeeService::class, EmployeeService::class);
        $this->app->bind(IPersonalAccessTokenService::class, PersonalAccessTokenService::class);
        $this->app->bind(IDeviceCategoryService::class, DeviceCategoryService::class);
        $this->app->bind(IDeviceStatusService::class, DeviceStatusService::class);
        $this->app->bind(IDeviceService::class, DeviceService::class);
        $this->app->bind(IDevicePackageService::class, DevicePackageService::class);
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
