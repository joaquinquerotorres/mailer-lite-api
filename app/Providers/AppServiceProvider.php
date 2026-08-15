<?php

namespace App\Providers;

use App\Campaign\Application\CreateCampaign\CreateCampaignCommand;
use App\Campaign\Application\CreateCampaign\CreateCampaignCommandHandler;
use App\Campaign\Application\GetCampaign\GetCampaignQuery;
use App\Campaign\Application\GetCampaign\GetCampaignQueryHandler;
use App\Campaign\Application\GetCampaigns\GetCampaignsQuery;
use App\Campaign\Application\GetCampaigns\GetCampaignsQueryHandler;
use App\Campaign\Domain\Contracts\CampaignRepository;
use App\Campaign\Infrastructure\Repository\CampaignEloquentRepository;
use App\Shared\Domain\Bus\CommandBus;
use App\Shared\Domain\Bus\QueryBus;
use App\Shared\Instrastructure\Bus\LaravelCommandBus;
use App\Shared\Instrastructure\Bus\LaravelQueryBus;
use Illuminate\Support\Facades\Bus;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(CampaignRepository::class, CampaignEloquentRepository::class);
        $this->app->bind(QueryBus::class, LaravelQueryBus::class);
        $this->app->bind(CommandBus::class, LaravelCommandBus::class);

    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Bus::map([
            GetCampaignsQuery::class => GetCampaignsQueryHandler::class,
            GetCampaignQuery::class => GetCampaignQueryHandler::class,
            CreateCampaignCommand::class => CreateCampaignCommandHandler::class,
        ]);
    }

}
