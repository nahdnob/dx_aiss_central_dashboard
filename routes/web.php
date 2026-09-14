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
 
Route::get('/', [AuthController::class, 'showLoginForm'])->name('login.form');
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login.page');

Route::post('/register', [AuthController::class, 'register'])->name('register');
Route::post('/login', [AuthController::class, 'login'])->name('login');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::middleware(['auth'])->group(function () {
    // Route - dashboard
    Route::resource('dashboards', DashboardController::class);

    // Line Selector Routes
    Route::get('/select-line', [LineController::class, 'index'])->name('line-selector.index');
    Route::post('/select-line', [LineController::class, 'select'])->name('line-selector.select');
    Route::post('/clear-line', [LineController::class, 'clear'])->name('line-selector.clear');

    Route::middleware(['line.selected'])->group(function () {

    //-----------------------------------------------------------------------------------------------

    // Machine Management
    Route::resource('machines', MachineController::class)->except(['show'])->parameters(['machines' => 'id']);
    Route::post('machines/{id}/sop', [MachineController::class, 'attachSop'])->name('machines.sop.attach');
    Route::delete('machines/{id}/sop/{sopId}', [MachineController::class, 'detachSop'])->name('machines.sop.detach');
    
    //-----------------------------------------------------------------------------------------------

        // System Manager
        Route::get('/system-managers', [SystemManagerController::class, 'index'])->name('system-managers.index');

        // User Management
        Route::resource('users', UserController::class)->only(['index', 'store', 'update', 'destroy']);

        // Best Records
        Route::resource('best-records', BestRecordController::class);

        // Line Performance
        Route::resource('line-performance', LinePerformanceController::class);
        
        // Product Management
        Route::resource('products', ProductController::class);


        // Route - Documents
        Route::get('/documents', [DocumentController::class, 'index'])->name('documents.index');

        Route::resource('documents/dasg', DasgController::class)
            ->only(['index', 'store', 'update', 'destroy'])
            ->names([
                'index' => 'documents.dasg',
                'store' => 'documents.dasg.store',
                'update' => 'documents.dasg.update',
                'destroy' => 'documents.dasg.destroy',
            ]);

        Route::resource('documents/sop', SopController::class)
            ->only(['index', 'store', 'update', 'destroy'])
            ->names([
                'index' => 'documents.sop',
                'store' => 'documents.sop.store',
                'update' => 'documents.sop.update',
                'destroy' => 'documents.sop.destroy',
            ]);

        Route::resource('documents/risk-assessment', RiskAssessmentController::class)
            ->only(['index', 'store', 'update', 'destroy'])
            ->names([
                'index' => 'documents.risk-assessment',
                'store' => 'documents.risk-assessment.store',
                'update' => 'documents.risk-assessment.update',
                'destroy' => 'documents.risk-assessment.destroy',
            ]);
        
        // Cycle Times - Monitoring
        Route::get('/cycletimes/monitoring', [CycleTimeController::class, 'index'])->name('cycletimes.monitoring.index');
        Route::get('/cycletimes/monitoring/export-csv', [CycleTimeController::class, 'exportCsv'])->name('cycletimes.monitoring.export-csv');
        Route::get('/cycletimes/monitoring/export-pdf', [CycleTimeController::class, 'exportPdf'])->name('cycletimes.monitoring.export-pdf');
        // Cycle Times Settings handled by PatternController
        Route::post('cycletimes/setting/upload-map', [PatternController::class, 'uploadMap'])->name('cycletimes.setting.upload-map');
        Route::resource('cycletimes/setting', PatternController::class)->names([
            'index'   => 'cycletimes.setting.index',
            'store'   => 'cycletimes.setting.store',
            'update'  => 'cycletimes.setting.update',
            'destroy' => 'cycletimes.setting.destroy',
        ]);
    });
});

// Route publik, tanpa middleware
Route::get('machines/{id}', [MachineController::class, 'show'])->name('machines.show');

// Rute untuk mengambil tabel produk
Route::get('/fetch-products-table', [DashboardController::class, 'fetchProductsTable'])->name('products.fetchTable');

// Route - Marquee Text
Route::post('/marqueeText/update', [MarqueeTextController::class, 'update'])->name('marqueeText.update');

// Pattern Histories
Route::resource('pattern-histories', PatternHistoryController::class);