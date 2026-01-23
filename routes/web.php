<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DeveloperController;
use App\Http\Controllers\ProjectManagerController;
use App\Http\Controllers\TesterController;
use Illuminate\Support\Facades\Auth;
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
})->name('index');

Route::post('/login', [AuthController::class, 'login'])->name('login');

Route::get('/setup-account', [AuthController::class, 'showSetupForm']);
Route::post('/setup-account', [AuthController::class, 'setupAccount']);

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
        Route::get('/', [AdminController::class, 'dashboard'])->name('admin.dashboard');
        Route::get('/project-managers', [AdminController::class, 'projectManagers'])->name('admin.project-managers');
        Route::post('/project-managers', [AdminController::class, 'projectManagerAdd'])->name('admin.project-managers');
    });

    /*
    |--------------------------------------------------------------------------
    | Project Manager Routes
    |--------------------------------------------------------------------------
    */
    Route::middleware(['role:project_manager'])->prefix('project-manager')->group(function () {
        Route::get('/', [ProjectManagerController::class, 'dashboard'])->name('pm.dashboard');
        Route::get('developers', [ProjectManagerController::class, 'developersIndex'])
        ->name('pm.developers');
        Route::post('developers', [ProjectManagerController::class, 'developersStore'])
        ->name('pm.developers');
        Route::get('/developer/{developer_id}' , [ProjectManagerController::class, 'developerView'])->name('pm.developer');
        Route::delete('/developer/{developer_id}', [ProjectManagerController::class, 'developerDelete'])
        ->name('pm.developer.delete');
        Route::put('developers/{developer_id}', [ProjectManagerController::class, 'developersUpdate'])
        ->name('pm.developers.update');

        Route::get('testers', [ProjectManagerController::class, 'testersIndex'])
        ->name('pm.testers');
        Route::post('testers', [ProjectManagerController::class, 'testersStore'])
        ->name('pm.testers');
        Route::get('/tester/{tester_id}', [ProjectManagerController::class, 'testerView'])
        ->name('pm.tester');
        Route::delete('/tester/{tester_id}', [ProjectManagerController::class, 'testerDelete'])
        ->name('pm.tester.delete');
        Route::put('/testers/{tester_id}', [ProjectManagerController::class, 'testersUpdate'])
        ->name('pm.testers.update');
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