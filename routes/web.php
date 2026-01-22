<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DeveloperController;
use App\Http\Controllers\ProjectManagerController;
use App\Http\Controllers\TesterController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    if(Auth::check()) {
        return match (Auth::user()->role) {
            'admin' => redirect()->to('/admin'),
            'project_manager' => redirect()->to('/project-manager'),
            'developer' => redirect()->to('/developer'),
            'tester' => redirect()->to('/tester'),
            default => abort(403),
        };
    }
    return view('welcome');
});

Route::post('/login', [AuthController::class, 'login'])->name('login');

/*
|--------------------------------------------------------------------------
| Authenticated Routes
|--------------------------------------------------------------------------
*/
Route::middleware(['auth'])->group(function () {

    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    /*
    |--------------------------------------------------------------------------
    | Admin Routes
    |--------------------------------------------------------------------------
    */
    Route::middleware(['role:admin'])->prefix('admin')->group(function () {
        Route::get('/', [AdminController::class, 'dashboard']);
    });

    /*
    |--------------------------------------------------------------------------
    | Project Manager Routes
    |--------------------------------------------------------------------------
    */
    Route::middleware(['role:project_manager'])->prefix('project-manager')->group(function () {
        Route::get('/dashboard', [ProjectManagerController::class, 'dashboard']);
        Route::resource('/projects', ProjectManagerController::class);
    });

    /*
    |--------------------------------------------------------------------------
    | Developer Routes
    |--------------------------------------------------------------------------
    */
    Route::middleware(['role:developer'])->prefix('developer')->group(function () {
        Route::get('/dashboard', [DeveloperController::class, 'dashboard']);
    });

    /*
    |--------------------------------------------------------------------------
    | Tester Routes
    |--------------------------------------------------------------------------
    */
    Route::middleware(['role:tester'])->prefix('tester')->group(function () {
        Route::get('/dashboard', [TesterController::class, 'dashboard']);
    });

});