<?php

namespace App\Providers;

use App\Services\BreweryService;
use App\Helpers\BreweryCacheHelper;
use App\Http\Clients\OpenBreweryClient;
use Illuminate\Support\ServiceProvider;
use App\Services\Contracts\BreweryService as BreweryServiceContract;
use App\Helpers\Contracts\BreweryCacheHelper as BreweryCacheHelperContract;
use App\Http\Clients\Contracts\OpenBreweryClient as OpenBreweryClientContract;

class AppServiceProvider extends ServiceProvider
{
    protected array $bindingHelpers = [
        BreweryCacheHelperContract::class => BreweryCacheHelper::class,
    ];

    protected array $bindingClients = [
        OpenBreweryClientContract::class => OpenBreweryClient::class,
    ];

    protected array $bindingServices = [
        BreweryServiceContract::class => BreweryService::class,
    ];

    public function register(): void
    {
        $this->registerHelpers();
        $this->registerClients();
        $this->registerServices();
    }

    public function boot(): void {}

    private function registerHelpers(): void
    {
        foreach ($this->bindingHelpers as $abstract => $concrete) {
            $this->app->bind($abstract, $concrete);
        }
    }

    private function registerClients(): void
    {
        foreach ($this->bindingClients as $abstract => $concrete) {
            $this->app->bind($abstract, $concrete);
        }
    }

    private function registerServices(): void
    {
        foreach ($this->bindingServices as $abstract => $concrete) {
            $this->app->bind($abstract, $concrete);
        }
    }
}
