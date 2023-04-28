<?php

use Illuminate\Support\Facades\Route;
use Muscobytes\OzonSeller\Http\Controllers\WebhookController;
use Muscobytes\OzonSeller\Middleware\WebhookMiddleware;


/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/


Route::middleware(WebhookMiddleware::class)->get(
    config('ozonseller.webhook.url'), [WebhookController::class, 'webhook']
);
