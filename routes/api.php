<?php

use App\Campaign\Infrastructure\Controllers\GetCampaignController;
use App\Campaign\Infrastructure\Controllers\GetCampaignsController;
use Illuminate\Support\Facades\Route;

Route::get('/campaigns', GetCampaignsController::class);
Route::get('/campaigns/{campaignUuid}', GetCampaignController::class);
