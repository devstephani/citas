<?php

use App\Http\Controllers\LandingPageController;
use App\Livewire\Blog;
use App\Livewire\Client;
use App\Livewire\Dashboard;
use App\Livewire\DeletedRecords;
use App\Livewire\Employee;
use App\Livewire\Packages;
use App\Livewire\Post;
use App\Livewire\PostView;
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

Route::get('/', LandingPageController::class)->name('home');
Route::get('posts/{id}', PostView::class)->name('post.id');

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('dashboard', Dashboard::class)->name('dashboard');
    Route::get('services', Services::class)->name('services');
    Route::get('packages', Packages::class)->name('packages');
    Route::get('virtual', Virtual::class)->name('virtual');
    Route::get('blog', Blog::class)->name('blog');
    Route::get('employees', Employee::class)->name('employees');
    Route::get('clients', Client::class)->name('clients');
    Route::get('posts', Post::class)->name('posts');
    Route::get('trash', DeletedRecords::class)->name('trash');
});
