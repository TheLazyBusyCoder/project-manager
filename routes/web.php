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
            Route::post('/modules/sub/{module_id}', 'moduleCreateSub')->name('pm.modules.create.sub');
        });

        Route::get('/modules/{module_id}' , 'moduleView')->name('pm.modules.view');
        Route::get('/pm/modules/{module_id}/tasks/{task_id}', [ProjectManagerController::class, 'viewTask'])->name('pm.tasks.view');
        Route::post('/pm/tasks/store', [ProjectManagerController::class, 'taskStore'])->name('pm.tasks.store');

        Route::get('/pm/bugs/{bug_id}', [ProjectManagerController::class, 'bugsView'])
        ->name('pm.bugs.view');

        Route::post('/pm/bugs/{bug_id}/comment', [ProjectManagerController::class, 'addBugComment'])
        ->name('pm.bugs.comments.add');
    });


    /*
    |--------------------------------------------------------------------------
    | Developer Routes
    |--------------------------------------------------------------------------
    */
    Route::middleware(['role:developer'])->prefix('developer')->group(function () {
        Route::get('/', [DeveloperController::class, 'dashboard'])->name('developer.dashboard');
        Route::get('/tasks' , [DeveloperController::class, 'tasks'])->name('developer.tasks');
        Route::get('/tasks/{task_id}' , [DeveloperController::class, 'viewTask'])->name('developer.tasks.view');
        Route::post('/tasks/{task_id}/comment' , [DeveloperController::class, 'addComment'])->name('developer.tasks.comment');
        Route::post('/modules/{module_id}/documentation' , [DeveloperController::class, 'addModuleDocumentation'])->name('developer.module.documentation');
        Route::get('/documentation/{doc_id}' , [DeveloperController::class, 'viewDocumentation'])->name('developer.documentation.view');
        Route::get('/project/{project_id}' , [DeveloperController::class , 'viewProjectTree'])->name('developer.project.view');

        Route::get('/bugs/{bug_id}', [DeveloperController::class, 'bugsView'])
        ->name('developer.bugs.view');
        Route::post('/bugs/{bug_id}/comment', [DeveloperController::class, 'addBugComment'])
        ->name('developer.bugs.comments.add');
    });

    /*
    |--------------------------------------------------------------------------
    | Tester Routes
    |--------------------------------------------------------------------------
    */
    Route::middleware(['role:tester'])->prefix('tester')->group(function () {
        Route::get('/', [TesterController::class, 'dashboard'])->name('tester.dashboard');
        Route::get('/tasks' , [TesterController::class, 'tasks'])->name('tester.tasks');
        Route::get('/tasks/{task_id}' , [TesterController::class, 'viewTask'])->name('tester.tasks.view');
        Route::post('/tasks/{task_id}/comment' , [TesterController::class, 'addComment'])->name('tester.tasks.comment');
        Route::get('/documentation/{doc_id}' , [TesterController::class, 'viewDocumentation'])->name('tester.documentation.view');
        Route::get('/project/{project_id}' , [TesterController::class , 'viewProjectTree'])->name('tester.project.view');

        Route::post('/bugs/store', [TesterController::class, 'bugsStore'])
        ->name('tester.bugs.store');

        Route::get('/bugs/{bug_id}', [TesterController::class, 'bugsView'])
        ->name('tester.bugs.view');

        Route::post('/bugs/{bug_id}/comment', [TesterController::class, 'addBugComment'])
        ->name('tester.bugs.comments.add');
    });

});