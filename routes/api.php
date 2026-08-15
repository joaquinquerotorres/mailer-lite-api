<?php

use App\Campaign\Infrastructure\Controllers\CreateCampaignController;
use App\Campaign\Infrastructure\Controllers\GetCampaignController;
use App\Campaign\Infrastructure\Controllers\GetCampaignsController;
use App\Campaign\Infrastructure\Controllers\SendCampaignController;
use App\Campaign\Infrastructure\Controllers\UpdateCampaignController;
use Illuminate\Support\Facades\Route;

Route::get('/campaigns', GetCampaignsController::class);
Route::get('/campaigns/{campaignUuid}', GetCampaignController::class);
Route::post('/campaigns', CreateCampaignController::class);
Route::put('/campaigns/{campaignUuid}', UpdateCampaignController::class);
Route::post('/campaigns/{campaignUuid}/send', SendCampaignController::class);
