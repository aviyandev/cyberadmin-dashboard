<?php

use Illuminate\Support\Facades\Route;
use CyberAdmin\Dashboard\Http\Livewire\Dashboard;
use CyberAdmin\Dashboard\Http\Livewire\Settings;
use CyberAdmin\Dashboard\Http\Livewire\Profile;
use CyberAdmin\Dashboard\Http\Livewire\Users;
use CyberAdmin\Dashboard\Http\Livewire\Reports;

Route::group([
    'prefix' => config('cyberadmin.route_prefix', 'cyberadmin'),
    'middleware' => config('cyberadmin.middleware', ['web', 'auth']),
], function () {
    Route::get('/', Dashboard::class)->name('cyberadmin.dashboard');
    Route::get('/dashboard', Dashboard::class)->name('cyberadmin.dashboard');
    Route::get('/settings', Settings::class)->name('cyberadmin.settings');
    Route::get('/profile', Profile::class)->name('cyberadmin.profile');
    Route::get('/users', Users::class)->name('cyberadmin.users');
    Route::get('/reports', Reports::class)->name('cyberadmin.reports');
});
