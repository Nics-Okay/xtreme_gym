    <?php

use App\Http\Controllers\Admin\ApprenticeController;
use App\Http\Controllers\Admin\AttendeeController;
use App\Http\Controllers\Admin\ClassListController;
use App\Http\Controllers\Admin\ControlPanelController;
use App\Http\Controllers\Admin\EquipmentController;
use App\Http\Controllers\Admin\EventController;
use App\Http\Controllers\Admin\GuestController;
use App\Http\Controllers\Admin\MemberController;
use App\Http\Controllers\Admin\NotificationController;
use App\Http\Controllers\Admin\RateController;
use App\Http\Controllers\Admin\ReservationController;
use App\Http\Controllers\Admin\StudentController;
use App\Http\Controllers\Admin\TournamentController;
use App\Http\Controllers\Admin\TrainerController;
use App\Http\Controllers\Admin\TrainingController;
use App\Http\Controllers\Auth\OtpController;
use App\Http\Controllers\MainController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\User\MembershipController;
use App\Http\Controllers\User\UserPageController;
use App\Http\Controllers\User\UserReservationController;
use App\Models\Setting;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Mail;

/* No Middleware Routes */
Route::get('/', function () {
    return view('index');
})->name('index');

Route::get('/index', function () {
    return view('index');
})->name('main');

Route::get('/test-only', function () {
    return view('user.test-size');
})->name('test.only');

Route::get('/plans', [PageController::class, 'plans'])->name('page.plans');
Route::get('/about', [PageController::class, 'about'])->name('page.about');
Route::get('/contact', [PageController::class, 'contact'])->name('page.contact');
Route::get('/acknowledgement', [PageController::class, 'acknowledgement'])->name('page.acknowledgement');

Route::middleware(['auth', 'admin.lock'])->group(function () {
});

Route::post('/admin/lock', [MainController::class, 'lock'])->name('admin.lock');
Route::post('/admin/unlock', [MainController::class, 'unlock'])->name('admin.unlock');

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

    Route::get('/admin/profile', [ProfileController::class, 'show'])->name('profileNew.show');
    Route::get('/profile', [ProfileController::class, 'showUser'])->name('profileUser.show');
    Route::patch('/profile/update', [ProfileController::class, 'update'])->name('profileNew.update');
    Route::post('/profile/update-image', [ProfileController::class, 'updateImage'])->name('profileNew.updateImage');
    Route::post('/profile/update-password', [ProfileController::class, 'updatePassword'])->name('profileNew.updatePassword');
    Route::delete('/profile/delete', [ProfileController::class, 'destroy'])->name('profileNew.destroy');

    /* Review Routes User */
    Route::get('/reviews', [ReviewController::class, 'create'])->name('review.create');
    Route::post('/admin/reviews/{review}/reply', [ReviewController::class, 'reply'])->name('review.reply');
    Route::post('/reviews', [ReviewController::class, 'store'])->name('review.store');

    /* Reviews Routes Admin */
    Route::get('/admin/reviews', [ReviewController::class, 'show'])->name('review.show');
    Route::get('/calendar', [ReservationController::class, 'calendar'])->name('calendar');
    Route::get('/calendar/events', [ReservationController::class, 'getEvents'])->name('calendar.events');
    Route::post('/reservations', [ReservationController::class, 'store'])->name('reservations.store');

});

/* Authenticated, Verified, OTP Verified, and Admin only */
Route::middleware(['auth', 'verified', 'otp.verified', 'role:admin'])->group(function () {
    Route::get('/admin/control', [ControlPanelController::class, 'show'])->name('control.show');
    Route::post('/cpanel/toggle-lock', [ControlPanelController::class, 'toggleLockedStatus'])->name('cpanel.toggle-lock');
    Route::get('/lock-status', [ControlPanelController::class, 'getLockStatus'])->name('get.lock.status');
    Route::post('/admin/update-lock-code', [ControlPanelController::class, 'updateLockCode'])->name('admin.update-lock-code');
    Route::post('/admin/reset-lock-code', [ControlPanelController::class, 'sendResetLink'])->name('admin.reset-lock-code');
    Route::get('/admin/reset-lock-code/{token}', [ControlPanelController::class, 'resetLockCode'])->name('admin.reset-lock-code-link');





    



    /* Dashboard Routes */
    Route::get('/dashboard', [MainController::class, 'dashboard'])->name('dashboard');
    Route::get('/revenue-summary', [MainController::class, 'getRevenueSummary']);

    /* Members Management Routes */
    Route::get('/admin/members', [MemberController::class, 'show'])->name('member.show');
    Route::get('/admin/members/create', [MemberController::class, 'create'])->name('member.create');
    Route::post('/admin/members/store', [MemberController::class, 'store'])->name('member.store');
    Route::get('/admin/members/{first_name}/{last_name}/{rate}/{payment}/store', [MemberController::class, 'storeData'])->name('member.storeData');
    Route::get('/admin/members/{member}/edit', [MemberController::class, 'edit'])->name('member.edit');
    Route::put('/admin/members/{member}/update', [MemberController::class, 'update'])->name('member.update');
    Route::delete('/admin/members/{member}/destroy', [MemberController::class, 'destroy'])->name('member.destroy');

    /* Rates Routes */
    Route::get('/admin/plans', [RateController::class, 'show'])->name('rate.show');
    Route::get('/admin/plans/create', [RateController::class, 'create'])->name('rate.create');
    Route::post('/admin/plans/store', [RateController::class, 'store'])->name('rate.store');
    Route::get('/admin/plans/{rate}/edit', [RateController::class, 'edit'])->name('rate.edit');
    Route::put('/admin/plans/{rate}/update', [RateController::class, 'update'])->name('rate.update');
    Route::delete('/admin/plans/{rate}/destroy', [RateController::class, 'destroy'])->name('rate.destroy');

    /* Equipments Routes */
    Route::get('/admin/equipments', [EquipmentController::class, 'show'])->name('equipment.show');
    Route::get('/admin/equipments/create', [EquipmentController::class, 'create'])->name('equipment.create');
    Route::post('/admin/equipments/store', [EquipmentController::class, 'store'])->name('equipment.store');
    Route::get('/admin/equipments/{equipment}/edit', [EquipmentController::class, 'edit'])->name('equipment.edit');
    Route::put('/admin/equipments/{equipment}/update', [EquipmentController::class, 'update'])->name('equipment.update');
    Route::delete('/admin/equipments/{equipment}/destroy', [EquipmentController::class, 'destroy'])->name('equipment.destroy');

    /* Transactions Routes */
    Route::get('/admin/transactions/history', [TransactionController::class, 'show'])->name('transaction.show');
    Route::get('/admin/transactions/history/{transaction}/edit', [TransactionController::class, 'edit'])->name('transaction.edit');
    Route::put('/admin/transactions/history/{transaction}/update', [TransactionController::class, 'update'])->name('transaction.update');
    Route::delete('/admin/transactions/history/{transaction}/destroy', [TransactionController::class, 'destroy'])->name('transaction.destroy');
    Route::get('/admin/transactions/membership/request', [TransactionController::class, 'membershipRequest'])->name('transaction.membershipRequest');
    Route::put('/admin/transactions/membership/request/{transaction}/approve', [TransactionController::class, 'membershipRequestApprove'])->name('transactions.membershipRequestApprove');
    Route::put('/admin/transactions/membership/request/{transaction}/cancel', [TransactionController::class, 'membershipRequestCancel'])->name('transactions.membershipRequestCancel');

    Route::get('/admin/transactions/student/request', [TransactionController::class, 'studentRequest'])->name('transaction.studentRequest');
    Route::put('/admin/transactions/student/request/{transaction}/approve', [TransactionController::class, 'studentRequestApprove'])->name('transactions.studentRequestApprove');
    Route::put('/admin/transactions/student/request/{transaction}/cancel', [TransactionController::class, 'studentRequestCancel'])->name('transactions.studentRequestCancel');

    Route::get('/admin/transactions/apprentice/request', [TransactionController::class, 'apprenticeRequest'])->name('transaction.apprenticeRequest');
    Route::put('/admin/transactions/apprentice/request/{transaction}/approve', [TransactionController::class, 'apprenticeRequestApprove'])->name('transactions.apprenticeRequestApprove');
    Route::put('/admin/transactions/apprentice/request/{transaction}/cancel', [TransactionController::class, 'apprenticeRequestCancel'])->name('transactions.apprenticeRequestCancel');

    /* Attendees Routes */
    Route::get('/admin/attendees', [AttendeeController::class, 'show'])->name('attendee.show');
    Route::post('/admin/attendees/store', [AttendeeController::class, 'store'])->name('attendee.store');    
    Route::get('/admin/attendees/guest/{first_name}/{last_name}/{payment}/store', [AttendeeController::class, 'guestStore'])->name('guestAttendee.store');
    Route::delete('/admin/attendees/{attendee}/destroy', [AttendeeController::class, 'destroy'])->name('attendee.destroy');

    /* Guests Routes */
    Route::get('/admin/guests', [GuestController::class, 'show'])->name('guest.show');
    Route::get('/admin/guests/create', [GuestController::class, 'create'])->name('guest.create');
    Route::post('/admin/guests/store', [GuestController::class, 'store'])->name('guest.store');
    Route::get('/admin/guests/{guest}/edit', [GuestController::class, 'edit'])->name('guest.edit');
    Route::put('/admin/guests/{guest}/update', [GuestController::class, 'update'])->name('guest.update');
    Route::delete('/admin/guests/{guest}/destroy', [GuestController::class, 'destroy'])->name('guest.destroy');

    /* Trainers Routes */
    Route::get('admin/trainers', [TrainerController::class, 'show'])->name('trainer.show');
    Route::get('/admin/trainers/create', [TrainerController::class, 'create'])->name('trainer.create');
    Route::post('/admin/trainers/store', [TrainerController::class, 'store'])->name('trainer.store');
    Route::get('admin/trainers/{trainer}/edit', [TrainerController::class, 'edit'])->name('trainer.edit');
    Route::put('admin/trainers/{trainer}/update', [TrainerController::class, 'update'])->name('trainer.update');
    Route::delete('/admin/trainers/{trainer}/destroy', [TrainerController::class, 'destroy'])->name('trainer.destroy');

    /* Events Routes */
    Route::get('admin/events', [EventController::class, 'show'])->name('event.show');
    Route::get('/admin/events/create', [EventController::class, 'create'])->name('event.create');
    Route::post('/admin/events/store', [EventController::class, 'store'])->name('event.store');
    Route::get('admin/events/{event}/edit', [EventController::class, 'edit'])->name('event.edit');
    Route::put('admin/events/{event}/update', [EventController::class, 'update'])->name('event.update');
    Route::delete('/admin/events/{event}/destroy', [EventController::class, 'destroy'])->name('event.destroy');

    /* Reservations Routes
    Route::get('/calendar', [ReservationController::class, 'getEvents'])->name('calendar.events');
    Route::get('admin/reservations', [ReservationController::class, 'show'])->name('reservation.show');
    Route::get('/admin/reservations/create', [ReservationController::class, 'create'])->name('reservation.create');
    Route::post('/admin/reservations/store', [ReservationController::class, 'store'])->name('reservation.store');
    Route::get('admin/reservations/{reservation}/edit', [ReservationController::class, 'edit'])->name('reservation.edit');
    Route::put('admin/reservations/{reservation}/update', [ReservationController::class, 'update'])->name('reservation.update');
    Route::delete('/admin/reservations/{reservation}/destroy', [ReservationController::class, 'destroy'])->name('reservation.destroy');
    */

    /* Class Routes */
    Route::get('admin/class', [ClassListController::class, 'show'])->name('classList.show');
    Route::get('/admin/class/create', [ClassListController::class, 'create'])->name('classList.create');
    Route::post('/admin/class/store', [ClassListController::class, 'store'])->name('classList.store');
    Route::get('admin/class/{classList}/edit', [ClassListController::class, 'edit'])->name('classList.edit');
    Route::put('admin/class/{classList}/update', [ClassListController::class, 'update'])->name('classList.update');
    Route::delete('/admin/class/{classList}/destroy', [ClassListController::class, 'destroy'])->name('classList.destroy');

    /* Student Routes */
    Route::get('admin/students', [StudentController::class, 'show'])->name('student.show');
    Route::get('/admin/students/create', [StudentController::class, 'create'])->name('student.create');
    Route::post('/admin/students/store', [StudentController::class, 'store'])->name('student.store');
    Route::get('admin/students/{student}/edit', [StudentController::class, 'edit'])->name('student.edit');
    Route::put('admin/students/{student}/update', [StudentController::class, 'update'])->name('student.update');
    Route::delete('/admin/students/{student}/destroy', [StudentController::class, 'destroy'])->name('student.destroy');

    /* Tournaments Routes */
    Route::get('admin/tournaments', [ClassListController::class, 'show'])->name('tournament.show');
    Route::get('/admin/tournaments/create', [ClassListController::class, 'create'])->name('tournament.create');
    Route::post('/admin/tournaments/store', [ClassListController::class, 'store'])->name('tournament.store');
    Route::get('admin/tournaments/{tournament}/edit', [ClassListController::class, 'edit'])->name('tournament.edit');
    Route::put('admin/tournaments/{tournament}/update', [ClassListController::class, 'update'])->name('tournament.update');
    Route::delete('/admin/tournaments/{tournament}/destroy', [ClassListController::class, 'destroy'])->name('tournament.destroy');

    Route::get('tournaments', [TournamentController::class, 'index'])->name('tournaments.index');
    Route::get('tournaments/create', [TournamentController::class, 'create'])->name('tournaments.create');
    Route::post('tournaments', [TournamentController::class, 'store'])->name('tournaments.store');
    Route::get('tournaments/{tournament}', [TournamentController::class, 'show'])->name('tournaments.show');
    Route::get('tournaments/{tournament}/edit', [TournamentController::class, 'edit'])->name('tournaments.edit');
    Route::put('tournaments/{tournament}', [TournamentController::class, 'update'])->name('tournaments.update');
    Route::patch('tournaments/{tournament}', [TournamentController::class, 'update'])->name('tournaments.update');
    Route::delete('tournaments/{tournament}', [TournamentController::class, 'destroy'])->name('tournaments.destroy');
    Route::get('tournaments/{tournament}/results', [TournamentController::class, 'showResults'])->name('tournaments.results');
    Route::post('tournaments/{tournament}/register', [TournamentController::class, 'registerParticipant'])->name('tournaments.register');

    /* Notifications */
    Route::get('/get-new-notifications-count', [MainController::class, 'getNewNotificationsCount']);
    Route::post('/notifications/{notification}/read', [NotificationController::class, 'markAsRead'])->name('notification.readNow');
    Route::get('admin/notifications', [NotificationController::class, 'show'])->name('notification.show');
    Route::get('admin/notifications/{notification}/read', [NotificationController::class, 'read'])->name('notification.read');
    Route::get('/admin/notifications/create', [NotificationController::class, 'create'])->name('notification.create');
    Route::post('/admin/notifications/store', [NotificationController::class, 'store'])->name('notification.store');
    Route::get('admin/notifications/{notification}/edit', [NotificationController::class, 'edit'])->name('notification.edit');
    Route::put('admin/notifications/{notification}/update', [NotificationController::class, 'update'])->name('notification.update');
    Route::delete('/admin/notifications/{notification}/destroy', [NotificationController::class, 'destroy'])->name('notification.destroy');

    /* Apprentices Routes */
    Route::get('admin/apprentices', [ApprenticeController::class, 'show'])->name('apprentice.show');
    Route::get('/admin/apprentices/create', [ApprenticeController::class, 'create'])->name('apprentice.create');
    Route::post('/admin/apprentices/store', [ApprenticeController::class, 'store'])->name('apprentice.store');
    Route::get('admin/apprentices/{apprentice}/edit', [ApprenticeController::class, 'edit'])->name('apprentice.edit');
    Route::put('admin/apprentices/{apprentice}/update', [ApprenticeController::class, 'update'])->name('apprentice.update');
    Route::delete('/admin/apprentices/{apprentice}/destroy', [ApprenticeController::class, 'destroy'])->name('apprentice.destroy');

    /* Trainings Routes */
    Route::get('admin/trainings', [TrainingController::class, 'show'])->name('training.show');
    Route::get('/admin/trainings/create', [TrainingController::class, 'create'])->name('training.create');
    Route::post('/admin/trainings/store', [TrainingController::class, 'store'])->name('training.store');
    Route::get('admin/trainings/{training}/edit', [TrainingController::class, 'edit'])->name('training.edit');
    Route::put('admin/trainings/{training}/update', [TrainingController::class, 'update'])->name('training.update');
    Route::delete('/admin/trainings/{training}/destroy', [TrainingController::class, 'destroy'])->name('training.destroy');
});

/* Authenticated, Verified, OTP Verified, Admin role, and Staff role only */
Route::middleware(['auth', 'verified', 'otp.verified', 'role:admin,staff'])->group(function () {
    // routes accessible to admin or staff
});

Route::middleware(['auth', 'verified', 'otp.verified'])->group(function () {
    Route::get('/home', [MainController::class, 'home'])->name('user.home');
    Route::get('/settings', [UserPageController::class, 'settings'])->name('user.settings');
    Route::get('/equipments', [UserPageController::class, 'equipments'])->name('user.equipments');
    Route::get('/transactions', [UserPageController::class, 'transactions'])->name('user.transactions');

    Route::get('/class', [UserPageController::class, 'class'])->name('user.class');
    Route::post('/class/avail', [UserPageController::class, 'availClass'])->name('user.availClass');
    Route::get('/class/cancel', [UserPageController::class, 'cancelClass'])->name('user.cancelClass');

    Route::get('/training', [UserPageController::class, 'training'])->name('user.training');
    Route::post('/training/avail', [UserPageController::class, 'availTraining'])->name('user.availTraining');
    Route::get('/training/cancel', [UserPageController::class, 'cancelTraining'])->name('user.cancelTraining');

    Route::get('/membership', [MembershipController::class, 'showMembership'])->name('user.membership');
    Route::get('/membership/avail/{rate}', [MembershipController::class, 'availMembership'])->name('membership.avail');
    Route::get('/membership/renewal/{rate}', [MembershipController::class, 'renewMembership'])->name('membership.renew');
    Route::post('/membership/avail/store', [TransactionController::class, 'availStore'])->name('membership.availStore');
    Route::post('/membership/renewal/store', [TransactionController::class, 'renewStore'])->name('membership.renewStore');

    /* User Reservation */
    Route::get('/reservations/create', [UserReservationController::class, 'create'])->name('reservations.create');
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
