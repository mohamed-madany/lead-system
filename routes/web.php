<?php

use Illuminate\Support\Facades\Route;

// Public Routes (Arabic Landing Page & Contact Form)
Route::get('/', function () {
    return view('home');
})->name('home');

Route::get('/contact', function () {
    return view('contact');
})->name('contact');

// Admin Panel - Filament handles its own routes at /admin
// Configured in config/filament.php
