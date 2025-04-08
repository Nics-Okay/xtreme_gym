<?php

use App\Http\Controllers\Admin\EquipmentController;
use App\Http\Controllers\Admin\RateController;
use App\Http\Controllers\Auth\OtpController;
use App\Http\Controllers\MainController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\User\MembershipController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Mail;

/* No Middleware Routes */
Route::get('/', function () {
    return view('welcome');
})->name('index');

/* Authenticated Users Only */
Route::middleware('auth')->group(function () {
});

/* Authenticated and Verified */
Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('otp/verify', [OtpController::class, 'showVerifyForm'])->name('otp.verify');
    Route::get('otp/generate', [OtpController::class, 'generateOtp'])->name('otp.generate');
    Route::post('otp/verify', [OtpController::class, 'verifyOtp'])
        ->middleware('throttle:3,1') // 1 attempts per 2 minute
        ->name('otp.verify');
    Route::get('otp/resend', [OtpController::class, 'resendOtp'])->name('otp.resend');

    /* Security Routes */
    Route::get('/filter', [MainController::class, 'showRightDashboard'])->name('filter');
    Route::get('/otp-reset', [OtpController::class, 'reset'])->name('otp.reset');
});

/* Authenticated, Verified, and OTP Verified only */
Route::middleware(['auth', 'verified', 'otp.verified'])->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

/* Authenticated, Verified, OTP Verified, and Admin only */
Route::middleware(['auth', 'verified', 'otp.verified', 'role:admin'])->group(function () {
    /* Dashboard Routes */
    Route::get('/dashboard', function () { 
        return view('admin.dashboard');
    })->name('dashboard');

    /* Rate Routes */
    Route::get('admin/plans', [RateController::class, 'show'])->name('rate.show');
    Route::get('/admin/plans/create', [RateController::class, 'create'])->name('rate.create');
    Route::post('/admin/plans/store', [RateController::class, 'store'])->name('rate.store');
    Route::get('admin/plans/{rate}/edit', [RateController::class, 'edit'])->name('rate.edit');
    Route::put('admin/plans/{rate}/update', [RateController::class, 'update'])->name('rate.update');
    Route::delete('/admin/plans/{rate}/destroy', [RateController::class, 'destroy'])->name('rate.destroy');

    /* Equipments Routes */
    Route::get('/admin/equipments', [EquipmentController::class, 'show'])->name('equipment.show');
    Route::get('/admin/equipments/create', [EquipmentController::class, 'create'])->name('equipment.create');
    Route::post('/admin/equipments/store', [EquipmentController::class, 'store'])->name('equipment.store');
    Route::get('/admin/equipments/{equipment}/edit', [EquipmentController::class, 'edit'])->name('equipment.edit');
    Route::put('/admin/equipments/{equipment}/update', [EquipmentController::class, 'update'])->name('equipment.update');
    Route::delete('/admin/equipments/{equipment}/destroy', [EquipmentController::class, 'destroy'])->name('equipment.destroy');

    /* Transactions Routes */
    Route::get('/admin/transactions/membership/request', [TransactionController::class, 'membershipRequest'])->name('transaction.membershipRequest');
});

/* Authenticated, Verified, OTP Verified, Admin role, and Staff role only */
Route::middleware(['auth', 'verified', 'otp.verified', 'role:admin,staff'])->group(function () {
    // routes accessible to admin or staff
});

/* Authenticated, Verified, OTP Verified, and User only */
Route::middleware(['auth', 'verified', 'otp.verified', 'role:user'])->group(function () {
    Route::get('/home', [MainController::class, 'home'])->name('user.home');
    Route::get('/membership', [MembershipController::class, 'showMembership'])->name('user.membership');
    Route::get('/membership/avail/{rate}', [MembershipController::class, 'availMembership'])->name('membership.avail');
    Route::get('/membership/renewal/{rate}', [MembershipController::class, 'renewMembership'])->name('membership.renew');
    Route::post('/membership/avail/store', [TransactionController::class, 'availStore'])->name('membership.availStore');
    Route::post('/membership/renewal/store', [TransactionController::class, 'renewStore'])->name('membership.renewStore');
});

/* Test Routes */
Route::get('/send-test-email', function () {
    Mail::raw('This is a test email from Laravel!', function ($message) {
        $message->to('202210747@btech.ph.education')
                ->subject('Test Email');
    });
    return 'Test email sent successfully!';
});

require __DIR__.'/auth.php';
