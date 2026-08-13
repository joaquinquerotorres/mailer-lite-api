<?php

namespace App\Providers;

use App\Campaign\Domain\Contracts\CampaignRepository;
use App\Campaign\Infrastructure\Repository\CampaignEloquentRepository;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(CampaignRepository::class, CampaignEloquentRepository::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
