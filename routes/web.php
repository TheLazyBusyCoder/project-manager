<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DeveloperController;
use App\Http\Controllers\ProjectManagerController;
use App\Http\Controllers\TesterController;
use Illuminate\Http\Request;
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

Route::get('/login' , function(Request $request) {
    return redirect()->route('index');
});
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
    Route::middleware(['role:project_manager'])
    ->prefix('project-manager')
    ->controller(ProjectManagerController::class)
    ->group(function () {

        // Dashboard
        Route::get('/', 'dashboard')->name('pm.dashboard');

        // Developers
        Route::prefix('developers')->group(function () {
            Route::get('/', 'developersIndex')->name('pm.developers');
            Route::post('/', 'developersStore')->name('pm.developers');
            Route::put('/{developer_id}', 'developersUpdate')->name('pm.developers.update');
        });
        Route::prefix('developer')->group(function () {
            Route::get('/{developer_id}', 'developerView')->name('pm.developer');
            Route::delete('/{developer_id}', 'developerDelete')->name('pm.developer.delete');
        });

        // Testers
        Route::prefix('testers')->group(function () {
            Route::get('/', 'testersIndex')->name('pm.testers');
            Route::post('/', 'testersStore')->name('pm.testers');
            Route::put('/{tester_id}', 'testersUpdate')->name('pm.testers.update');
        });
        Route::prefix('tester')->group(function () {
            Route::get('/{tester_id}', 'testerView')->name('pm.tester');
            Route::delete('/{tester_id}', 'testerDelete')->name('pm.tester.delete');
        });

        // Projects
        Route::prefix('projects')->group(function() {
            Route::get('/' , 'projectsIndex')->name('pm.projects');
            Route::get('/{project_id}' , 'projectView')->name('pm.project.view');
            Route::post('/' , 'projectCreate')->name('pm.projects.create');
            Route::post('/{project_id}/modules', 'moduleCreate')->name('pm.modules.create');
        });
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