<?php

use Illuminate\Support\Facades\Route;

// Public Routes (Arabic Landing Page & Contact Form)
Route::get('/', function () {
    return view('home');
})->name('home');

Route::get('/contact', function () {
    return view('contact');
})->name('contact');

// Initial Super Admin Setup (Temporary)
Route::get('/init-admin/{secret}', function ($secret) {
    if ($secret !== 'leadsfiy-dev-2026') abort(403);
    
    $user = \App\Models\User::updateOrCreate(
        ['email' => 'admin@leadsfiy.com'],
        [
            'name' => 'Super Admin',
            'password' => bcrypt('password123'),
            'is_platform_admin' => true,
        ]
    );

    return "🎉 Account Ready! Email: admin@leadsfiy.com | Pass: password123";
});

// Admin Panel - Filament handles its own routes at /admin
// Configured in config/filament.php
