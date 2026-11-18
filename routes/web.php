<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\BestRecordController;
use App\Http\Controllers\CycleTimeController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DasgController;
use App\Http\Controllers\DocumentController;
use App\Http\Controllers\LineController;
use App\Http\Controllers\LinePerformanceController;
use App\Http\Controllers\MachineController;
use App\Http\Controllers\MarqueeTextController;
use App\Http\Controllers\PatternController;
use App\Http\Controllers\PatternHistoryController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\RiskAssessmentController;
use App\Http\Controllers\SopController;
use App\Http\Controllers\SystemManagerController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

// Public routes
Route::get('/', [AuthController::class, 'showLoginForm'])->name('login.form');
Route::post('/login', [AuthController::class, 'login'])->name('login');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
Route::post('/select-line', [LineController::class, 'select'])->name('line-selector.select');
Route::get('/machines/{id}', [MachineController::class, 'show'])->name('machines.show');
Route::get('/fetch-products-table', [DashboardController::class, 'fetchProductsTable'])->name('products.fetchTable');
Route::post('/marqueeText/update', [MarqueeTextController::class, 'update'])->name('marqueeText.update');

Route::middleware('auth')->group(function () {
    // Features available to every signed-in role.
    Route::middleware('role:admin,leader,user')->group(function () {
        Route::resource('dashboards', DashboardController::class);
        Route::get('/select-line', [LineController::class, 'index'])->name('line-selector.index');
        Route::post('/clear-line', [LineController::class, 'clear'])->name('line-selector.clear');

        Route::middleware('line.selected')->group(function () {
            Route::resource('machines', MachineController::class)
                ->except(['show'])
                ->parameters(['machines' => 'id']);
            Route::post('/machines/{id}/sop', [MachineController::class, 'attachSop'])->name('machines.sop.attach');
            Route::delete('/machines/{id}/sop/{sopId}', [MachineController::class, 'detachSop'])->name('machines.sop.detach');

            Route::get('/documents', [DocumentController::class, 'index'])->name('documents.index');
            Route::get('/dasgs', [DasgController::class, 'index'])->name('dasgs.index');
            Route::get('/sops', [SopController::class, 'index'])->name('sops.index');
            Route::get('/risk-assessments', [RiskAssessmentController::class, 'index'])->name('risk-assessments.index');

            Route::get('/cycletimes/monitoring', [CycleTimeController::class, 'index'])->name('cycletimes.monitoring.index');
            Route::get('/cycletimes/monitoring/export-csv', [CycleTimeController::class, 'exportCsv'])->name('cycletimes.monitoring.export-csv');
            Route::get('/cycletimes/monitoring/export-pdf', [CycleTimeController::class, 'exportPdf'])->name('cycletimes.monitoring.export-pdf');
        });
    });

    // Data management shared by admins and leaders.
    Route::middleware('role:admin,leader')->group(function () {
        Route::get('/system-managers', [SystemManagerController::class, 'index'])->name('system-managers.index');
        Route::resource('pattern-histories', PatternHistoryController::class);

        Route::middleware('line.selected')->group(function () {
            Route::resource('best-records', BestRecordController::class);
            Route::resource('line-performance', LinePerformanceController::class);
            Route::get('/products/stats', [ProductController::class, 'stats'])->name('products.stats');
            Route::get('/products/summary', [ProductController::class, 'summary'])->name('products.summary');
            Route::get('/products/log', [ProductController::class, 'log'])->name('products.log');
            Route::resource('products', ProductController::class);

            Route::resource('dasgs', DasgController::class)
                ->only(['store', 'update', 'destroy']);
            Route::resource('sops', SopController::class)
                ->only(['store', 'update', 'destroy']);
            Route::resource('risk-assessments', RiskAssessmentController::class)
                ->only(['store', 'update', 'destroy']);

            Route::post('/cycletimes/setting/upload-map', [PatternController::class, 'uploadMap'])
                ->name('cycletimes.setting.upload-map');
            Route::resource('cycletimes/setting', PatternController::class)->names([
                'index' => 'cycletimes.setting.index',
                'store' => 'cycletimes.setting.store',
                'update' => 'cycletimes.setting.update',
                'destroy' => 'cycletimes.setting.destroy',
            ]);
        });
    });

    // User management is exclusive to admins.
    Route::middleware('role:admin')->group(function () {
        Route::resource('users', UserController::class)->only(['index', 'store', 'update', 'destroy']);
    });
});
