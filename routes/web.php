<?php

use App\Livewire\Blog;
use App\Livewire\Packages;
use App\Livewire\Services;
use App\Livewire\Virtual;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('dashboard');
})->name('home');

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
    Route::get('services', Services::class)->name('services');
    Route::get('packages', Packages::class)->name('packages');
    Route::get('virtual', Virtual::class)->name('virtual');
    Route::get('blog', Blog::class)->name('blog');
});
