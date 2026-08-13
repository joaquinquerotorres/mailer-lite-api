<?php

use App\Campaign\Infrastructure\Controllers\GetCampaignsController;
use Illuminate\Support\Facades\Route;

Route::get('/campaigns', GetCampaignsController::class);
