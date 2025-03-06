<?php

namespace App\Providers;

use App\Repositories\CompanyRepository;
use Illuminate\Support\ServiceProvider;
use App\Repositories\CompanyCategoryRepository;
use App\Repositories\Interface\CompanyInterface;
use App\Repositories\Interface\CompanyCategoryInterface;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register()
    {
        $this->app->bind(CompanyInterface::class, CompanyRepository::class);
        $this->app->bind(CompanyCategoryInterface::class, CompanyCategoryRepository::class);
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
