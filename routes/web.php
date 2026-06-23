<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PageController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\FireReportController;
use App\Http\Controllers\Admin\MetadataController;
use App\Http\Controllers\Admin\PostOperationController;
use App\Http\Controllers\Admin\AuditLogController;
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\Admin\ProfileController;

/*
|--------------------------------------------------------------------------
| PUBLIC PAGES (no login required)
|--------------------------------------------------------------------------
*/
Route::get('/', [PageController::class, 'home'])->name('home');

Route::get('/report', [ReportController::class, 'create'])->name('report.create');
Route::post('/report', [ReportController::class, 'store'])->name('report.store');
Route::get('/report/success', [ReportController::class, 'success'])->name('report.success');

// Crowdsourcing "Verify" submission (triggered from the popup on home page)
Route::post('/crowdsource/verify', [ReportController::class, 'storeCrowdsourceVerification'])->name('crowdsource.verify');

Route::get('/education', [PageController::class, 'education'])->name('education');
Route::get('/crowdsource', [PageController::class, 'crowdsource'])->name('crowdsource');
Route::get('/cybersecurity', [PageController::class, 'cybersecurity'])->name('cybersecurity');
Route::get('/about', [PageController::class, 'about'])->name('about');

/*
|--------------------------------------------------------------------------
| AUTH (admin/firefighter/superadmin only)
|--------------------------------------------------------------------------
*/
Route::get('/login', [LoginController::class, 'show'])->name('login');
Route::post('/login', [LoginController::class, 'login'])->name('login.attempt');
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

Route::get('/register', [RegisterController::class, 'show'])->name('register');
Route::post('/register', [RegisterController::class, 'register'])->name('register.attempt');
Route::get('/register/verify-otp', [RegisterController::class, 'showOtp'])->name('register.otp');
Route::post('/register/verify-otp', [RegisterController::class, 'verifyOtp'])->name('register.otp.verify');
Route::post('/register/resend-otp', [RegisterController::class, 'resendOtp'])->name('register.otp.resend');

Route::get('/forgot-password', [ForgotPasswordController::class, 'show'])->name('password.request');
Route::post('/forgot-password', [ForgotPasswordController::class, 'sendOtp'])->name('password.send-otp');
Route::get('/forgot-password/verify-otp', [ForgotPasswordController::class, 'showOtp'])->name('password.otp');
Route::post('/forgot-password/verify-otp', [ForgotPasswordController::class, 'verifyOtp'])->name('password.otp.verify');
Route::get('/forgot-password/reset', [ForgotPasswordController::class, 'showReset'])->name('password.reset');
Route::post('/forgot-password/reset', [ForgotPasswordController::class, 'reset'])->name('password.reset.attempt');

/*
|--------------------------------------------------------------------------
| ADMIN AREA (role: admin, superadmin)
|--------------------------------------------------------------------------
*/
Route::prefix('admin')->name('admin.')->middleware(['auth', 'role:admin,superadmin'])->group(function () {
    // Shared between admin and superadmin
    Route::get('/home', [DashboardController::class, 'index'])->name('home');
    Route::get('/heatmap', [DashboardController::class, 'heatmap'])->name('heatmap');

    Route::get('/reports', [FireReportController::class, 'index'])->name('reports');
    Route::get('/reports/{report}', [FireReportController::class, 'show'])->name('reports.show');
    Route::post('/reports/{report}/status', [FireReportController::class, 'updateStatus'])->name('reports.update-status');

    Route::get('/metadata', [MetadataController::class, 'index'])->name('metadata');
    Route::post('/metadata/{report}/validate', [MetadataController::class, 'validateMetadata'])->name('metadata.validate');

    Route::get('/post-operations', [PostOperationController::class, 'index'])->name('post-operations');
    Route::get('/post-operations/create', [PostOperationController::class, 'create'])->name('post-operations.create');
    Route::post('/post-operations', [PostOperationController::class, 'store'])->name('post-operations.store');

    Route::get('/profile', [ProfileController::class, 'index'])->name('profile');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');

    // Superadmin-only
    Route::middleware('role:superadmin')->group(function () {
        Route::get('/users', [UserController::class, 'index'])->name('users');
        Route::post('/users', [UserController::class, 'store'])->name('users.store');
        Route::put('/users/{user}', [UserController::class, 'update'])->name('users.update');
        Route::delete('/users/{user}', [UserController::class, 'destroy'])->name('users.destroy');
        Route::post('/users/{user}/reset-password', [UserController::class, 'resetPassword'])->name('users.reset-password');

        Route::get('/roles-permissions', [RoleController::class, 'index'])->name('roles');
        Route::post('/roles-permissions', [RoleController::class, 'update'])->name('roles.update');

        Route::get('/audit-logs', [AuditLogController::class, 'index'])->name('audit-logs');

        Route::get('/settings', [SettingController::class, 'index'])->name('settings');
        Route::post('/settings', [SettingController::class, 'update'])->name('settings.update');
    });
});

/*
|--------------------------------------------------------------------------
| FIREFIGHTER AREA (role: bfp_firefighter) -- UI ONLY FOR NOW
| TODO next phase: wrap with `auth` + `role:bfp_firefighter` middleware
|--------------------------------------------------------------------------
*/
Route::prefix('firefighter')->name('firefighter.')->group(function () {
    Route::get('/home', [PageController::class, 'firefighterHome'])->name('home');
    Route::get('/reports', [PageController::class, 'firefighterReports'])->name('reports');
    Route::get('/profile', [PageController::class, 'firefighterProfile'])->name('profile');
});
