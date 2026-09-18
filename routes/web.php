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

// =========================================================================
// Auth - publik (belum login)
// =========================================================================
Route::get('/', [AuthController::class, 'showLoginForm'])->name('login.form');
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login.page');
Route::post('/login', [AuthController::class, 'login'])->name('login');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// =========================================================================
// Route publik yang SENGAJA tanpa proteksi (display TV / kebutuhan line)
// =========================================================================
Route::get('machines/{id}', [MachineController::class, 'show'])->name('machines.show');
Route::get('/fetch-products-table', [DashboardController::class, 'fetchProductsTable'])->name('products.fetchTable');
Route::post('/marqueeText/update', [MarqueeTextController::class, 'update'])->name('marqueeText.update');

Route::middleware(['auth'])->group(function () {

    // =====================================================================
    // TIER 1: Semua role login (admin, leader, user)
    // =====================================================================
    Route::middleware(['role:admin,leader,user'])->group(function () {

        // Dashboard
        Route::resource('dashboards', DashboardController::class);

        // Line Selector
        Route::get('/select-line', [LineController::class, 'index'])->name('line-selector.index');
        Route::post('/select-line', [LineController::class, 'select'])->name('line-selector.select');
        Route::post('/clear-line', [LineController::class, 'clear'])->name('line-selector.clear');

        Route::middleware(['line.selected'])->group(function () {

            // Machine Management (view + interaksi dasar)
            Route::resource('machines', MachineController::class)->except(['show'])->parameters(['machines' => 'id']);
            Route::post('machines/{id}/sop', [MachineController::class, 'attachSop'])->name('machines.sop.attach');
            Route::delete('machines/{id}/sop/{sopId}', [MachineController::class, 'detachSop'])->name('machines.sop.detach');

            // Documents - index (lihat daftar dokumen, boleh semua role)
            Route::get('/documents', [DocumentController::class, 'index'])->name('documents.index');
            Route::get('documents/dasg', [DasgController::class, 'index'])->name('documents.dasg');
            Route::get('documents/sop', [SopController::class, 'index'])->name('documents.sop');
            Route::get('documents/risk-assessment', [RiskAssessmentController::class, 'index'])->name('documents.risk-assessment');

            // Cycle Times - Monitoring (read-only untuk semua role)
            Route::get('/cycletimes/monitoring', [CycleTimeController::class, 'index'])->name('cycletimes.monitoring.index');
            Route::get('/cycletimes/monitoring/export-csv', [CycleTimeController::class, 'exportCsv'])->name('cycletimes.monitoring.export-csv');
            Route::get('/cycletimes/monitoring/export-pdf', [CycleTimeController::class, 'exportPdf'])->name('cycletimes.monitoring.export-pdf');
        });
    });

    // =====================================================================
    // TIER 2: admin & leader saja (kelola data)
    // =====================================================================
    Route::middleware(['role:admin,leader'])->group(function () {

        // Register user baru (form + submit disatukan di sini)
        Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register.form');
        Route::post('/register', [AuthController::class, 'register'])->name('register');

        // System Manager
        Route::get('/system-managers', [SystemManagerController::class, 'index'])->name('system-managers.index');

        // User Management
        Route::resource('users', UserController::class)->only(['index', 'store', 'update', 'destroy']);

        // Pattern Histories
        Route::resource('pattern-histories', PatternHistoryController::class);

        Route::middleware(['line.selected'])->group(function () {

            // Best Records
            Route::resource('best-records', BestRecordController::class);

            // Line Performance
            Route::resource('line-performance', LinePerformanceController::class);

            // Product Management
            Route::resource('products', ProductController::class);

            // Documents - kelola (create/update/delete)
            Route::resource('documents/dasg', DasgController::class)
                ->only(['store', 'update', 'destroy'])
                ->names([
                    'store'   => 'documents.dasg.store',
                    'update'  => 'documents.dasg.update',
                    'destroy' => 'documents.dasg.destroy',
                ]);

            Route::resource('documents/sop', SopController::class)
                ->only(['store', 'update', 'destroy'])
                ->names([
                    'store'   => 'documents.sop.store',
                    'update'  => 'documents.sop.update',
                    'destroy' => 'documents.sop.destroy',
                ]);

            Route::resource('documents/risk-assessment', RiskAssessmentController::class)
                ->only(['store', 'update', 'destroy'])
                ->names([
                    'store'   => 'documents.risk-assessment.store',
                    'update'  => 'documents.risk-assessment.update',
                    'destroy' => 'documents.risk-assessment.destroy',
                ]);

            // Cycle Times Setting
            Route::post('cycletimes/setting/upload-map', [PatternController::class, 'uploadMap'])->name('cycletimes.setting.upload-map');
            Route::resource('cycletimes/setting', PatternController::class)->names([
                'index'   => 'cycletimes.setting.index',
                'store'   => 'cycletimes.setting.store',
                'update'  => 'cycletimes.setting.update',
                'destroy' => 'cycletimes.setting.destroy',
            ]);
        });
    });
});