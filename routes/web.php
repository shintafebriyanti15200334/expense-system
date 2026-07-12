<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SubmissionController;
use App\Http\Controllers\ApprovalController;
use App\Http\Controllers\FinanceController;

/*
|--------------------------------------------------------------------------
| Welcome
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return redirect()->route('login');
});

/*
|--------------------------------------------------------------------------
| Dashboard Umum
|--------------------------------------------------------------------------
*/

Route::middleware('auth')->group(function () {

    Route::get(
        '/dashboard',
        [DashboardController::class, 'index']
    )->name('dashboard');

});

/*
|--------------------------------------------------------------------------
| Dashboard Per Role
|--------------------------------------------------------------------------
*/

Route::middleware([
    'auth',
    'role:Staff'
])->group(function () {

    Route::get('/staff', function () {
        return redirect()->route('dashboard');
    })->name('staff.dashboard');

});

Route::middleware([
    'auth',
    'role:SPV'
])->group(function () {

    Route::get('/spv', function () {
        return redirect()->route('dashboard');
    })->name('spv.dashboard');

});

Route::middleware([
    'auth',
    'role:Manager'
])->group(function () {

    Route::get('/manager', function () {
        return redirect()->route('dashboard');
    })->name('manager.dashboard');

});

Route::middleware([
    'auth',
    'role:Director'
])->group(function () {

    Route::get('/director', function () {
        return redirect()->route('dashboard');
    })->name('director.dashboard');

});

Route::middleware([
    'auth',
    'role:Finance'
])->group(function () {

    Route::get('/finance/dashboard', function () {
        return redirect()->route('dashboard');
    })->name('finance.dashboard');

});

/*
|--------------------------------------------------------------------------
| Submission (Staff)
|--------------------------------------------------------------------------
*/

Route::middleware([
    'auth',
    'role:Staff'
])->group(function () {

Route::get(
        '/submissions/history',
        [SubmissionController::class, 'history']
    )->name('submissions.history');

     Route::get(
    '/submissions/history/excel',
    [SubmissionController::class, 'exportHistoryExcel']
)->name('submissions.history.excel');

     Route::get(
    '/submissions/history/pdf',
    [SubmissionController::class, 'exportHistoryPdf']
)->name('submissions.history.pdf');

    Route::resource(
        'submissions',
        SubmissionController::class
    );

});
/*
|--------------------------------------------------------------------------
| Approval
|--------------------------------------------------------------------------
*/

Route::middleware(['auth'])->group(function () {


    Route::get(
        '/approvals/history',
        [ApprovalController::class,'history']
    )
    ->name('approvals.history');

    Route::get(
    '/approvals/history/excel',
    [ApprovalController::class,'exportHistoryExcel']
)->name('approvals.history.excel');

Route::get(
    '/approvals/history/pdf',
    [ApprovalController::class,'exportHistoryPdf']
)->name('approvals.history.pdf');


    Route::get(
        '/approvals',
        [ApprovalController::class,'index']
    )
    ->name('approvals.index');


    Route::get(
        '/approvals/{approval}',
        [ApprovalController::class,'show']
    )
    ->name('approvals.show');


    Route::post(
        '/approvals/{approval}/approve',
        [ApprovalController::class,'approve']
    )
    ->name('approvals.approve');


    Route::post(
        '/approvals/{approval}/reject',
        [ApprovalController::class,'reject']
    )
    ->name('approvals.reject');


});

/*
|--------------------------------------------------------------------------
| Finance
|--------------------------------------------------------------------------
*/

Route::middleware([
    'auth',
    'role:Finance'
])->group(function () {

    Route::get(
        '/finance',
        [FinanceController::class, 'index']
    )->name('finance.index');

    Route::post(
        '/finance/{submission}/pay',
        [FinanceController::class, 'pay'
    ])->name('finance.pay');

});

Route::get(
    '/submissions/export',
    [SubmissionController::class, 'export']
)->name('submissions.export');

Route::get(
    '/finance/history',
    [FinanceController::class,'history']
)
->name('finance.history');

 Route::get(
        '/finance/export/excel',
        [FinanceController::class, 'exportHistoryExcel']
    )->name('finance.export.excel');


    Route::get(
        '/finance/export/pdf',
        [FinanceController::class, 'exportHistoryPdf']
    )->name('finance.export.pdf');

/*
|--------------------------------------------------------------------------
| Profile
|--------------------------------------------------------------------------
*/

Route::middleware('auth')->group(function () {

    Route::get(
        '/profile',
        [ProfileController::class, 'edit']
    )->name('profile.edit');

    Route::patch(
        '/profile',
        [ProfileController::class, 'update']
    )->name('profile.update');

    Route::delete(
        '/profile',
        [ProfileController::class, 'destroy']
    )->name('profile.destroy');

});

require __DIR__.'/auth.php';