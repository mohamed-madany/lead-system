<?php

use Illuminate\Support\Facades\Route;

// Public Routes (Arabic Landing Page & Contact Form)
Route::get('/', function () {
    return view('home');
})->name('home');

Route::get('/contact', function () {
    return view('contact');
})->name('contact');

// Initial Super Admin Setup (Temporary - Delete after use)
Route::get('/init-admin/{secret}', function ($secret) {
    if ($secret !== 'leadsfiy-dev-2026') {
        abort(403);
    }

    $user = \App\Models\User::updateOrCreate(
        ['email' => 'admin@leadsfiy.com'],
        [
            'name' => 'Super Admin',
            'password' => bcrypt('password123'),
            'is_platform_admin' => true,
        ]
    );

    return '🎉 Super Admin Created! <br> Email: admin@leadsfiy.com <br> Pass: password123 <br><br> ⚠️ Please delete this route from routes/web.php immediately.';
});

// Admin Panel - Filament handles its own routes at /admin
