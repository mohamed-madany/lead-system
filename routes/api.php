<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\WebhookController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

// Configuration for webhooks
Route::match(['get', 'post'], '/webhooks/facebook', [WebhookController::class, 'facebook']);
Route::match(['get', 'post'], '/webhooks/whatsapp', [WebhookController::class, 'whatsapp']);

// Per-tenant unique webhooks
Route::match(['get', 'post'], '/webhooks/{tenant}', [WebhookController::class, 'facebook']);
