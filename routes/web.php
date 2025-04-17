<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Website\LandingController;
use App\Http\Controllers\SchoolController;
use App\Http\Controllers\Admin\TopicController;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Admin\Finance\FeeTypeController;
use App\Http\Controllers\Admin\Finance\FeeStructureController;
use App\Http\Controllers\Admin\Finance\TuitionFeeController;
use App\Http\Controllers\Admin\Finance\TransportFeeController;
use App\Http\Controllers\Admin\Finance\FeeCollectionController;
use App\Http\Controllers\Admin\Finance\FinanceReportController;
use App\Http\Controllers\Admin\Finance\OtherFeeController;
use App\Http\Controllers\Admin\Finance\InvoiceController;
use App\Http\Controllers\Admin\Finance\PaymentController;
use App\Http\Controllers\Admin\TeacherController;
use App\Http\Controllers\Admin\TeacherAssignmentController;
use App\Http\Controllers\Admin\TeachingScheduleController;
use App\Http\Controllers\Admin\TimetableController;
use App\Http\Controllers\Admin\StudentController;
use App\Http\Controllers\Student\SubjectController;
use App\Http\Controllers\Admin\Finance\ReportController;

Auth::routes();

// Landing page route with controller
Route::get('/', [LandingController::class, 'index'])->name('SchoolLandingPage');

// Login route
Route::get('loginpage', [SchoolController::class, 'loginpage'])->name('loginpage');

// Admin Routes
Route::prefix('system/Admin')->middleware(['auth', 'role:admin'])->name('admin.')->group(function () {
    Route::get('/dashboard', [App\Http\Controllers\Admin\DashboardController::class, 'index'])
         ->name('dashboard');
         
    // Subjects Routes with admin prefix in names
    Route::resource('subjects', App\Http\Controllers\Admin\SubjectController::class)->names([
        'index' => 'subjects.index',
        'create' => 'subjects.create',
        'store' => 'subjects.store',
        'edit' => 'subjects.edit',
        'update' => 'subjects.update',
        'destroy' => 'subjects.destroy',
        'show' => 'subjects.show'
    ]);
    Route::get('subjects/topics', [App\Http\Controllers\Admin\SubjectController::class, 'topics'])
         ->name('subjects.topics');
    Route::get('/subjects', [App\Http\Controllers\Admin\SubjectController::class, 'index'])->name('subjects.index');
    Route::get('/subjects/create', [App\Http\Controllers\Admin\SubjectController::class, 'create'])->name('subjects.create');
    
    // Topics Management Routes
    Route::controller(TopicController::class)->group(function () {
        Route::get('topics', 'index')->name('subjects.topics.index');
        Route::post('topics', 'store')->name('subjects.topics.store');
        Route::get('topics/{topic}', 'show')->name('subjects.topics.show');
        Route::get('topics/{topic}/edit', 'edit')->name('subjects.topics.edit');
        Route::put('topics/{topic}', 'update')->name('subjects.topics.update');
        Route::delete('topics/{topic}', 'destroy')->name('subjects.topics.destroy');
    });
    
    // Finance Module Routes
    Route::prefix('finance')->name('finance.')->group(function () {
        // Fee Types
        Route::resource('fee-types', FeeTypeController::class);
        
        // Fee Structures
        Route::resource('fee-structures', FeeStructureController::class);
        
        // Tuition Fees
        Route::controller(TuitionFeeController::class)->group(function () {
            Route::get('tuition-fees', 'index')->name('tuition-fees');
            Route::get('tuition-fees/create', 'create')->name('tuition-fees.create');
            Route::post('tuition-fees', 'store')->name('tuition-fees.store');
            Route::get('tuition-fees/{tuitionFee}/edit', 'edit')->name('tuition-fees.edit');
            Route::put('tuition-fees/{tuitionFee}', 'update')->name('tuition-fees.update');
            Route::delete('tuition-fees/{tuitionFee}', 'destroy')->name('tuition-fees.destroy');
        });

        // Transport Fees
        Route::controller(TransportFeeController::class)->group(function () {
            Route::get('transport-fees', 'index')->name('transport-fees');
            Route::get('transport-fees/create', 'create')->name('transport-fees.create');
            Route::post('transport-fees', 'store')->name('transport-fees.store');
            Route::get('transport-fees/{transportFee}/edit', 'edit')->name('transport-fees.edit');
            Route::put('transport-fees/{transportFee}', 'update')->name('transport-fees.update');
            Route::delete('transport-fees/{transportFee}', 'destroy')->name('transport-fees.destroy');
        });

        // Other Fees
        Route::controller(OtherFeeController::class)->group(function () {
            Route::get('other-fees', 'index')->name('other-fees');
            Route::get('other-fees/create', 'create')->name('other-fees.create');
            Route::post('other-fees', 'store')->name('other-fees.store');
            Route::get('other-fees/{otherFee}/edit', 'edit')->name('other-fees.edit');
            Route::put('other-fees/{otherFee}', 'update')->name('other-fees.update');
            Route::delete('other-fees/{otherFee}', 'destroy')->name('other-fees.destroy');
        });

        // Invoices
        Route::controller(InvoiceController::class)->group(function () {
            Route::get('invoices', 'index')->name('invoices.index');
            Route::get('invoices/create', 'create')->name('invoices.create');
            Route::post('invoices', 'store')->name('invoices.store');
            Route::get('invoices/{invoice}', 'show')->name('invoices.show');
            Route::get('invoices/{invoice}/edit', 'edit')->name('invoices.edit');
            Route::put('invoices/{invoice}', 'update')->name('invoices.update');
            Route::delete('invoices/{invoice}', 'destroy')->name('invoices.destroy');
            Route::get('invoices/{invoice}/print', 'print')->name('invoices.print');
            Route::get('invoices/{invoice}/send', 'send')->name('invoices.send');
        });

        // Payments
        Route::controller(PaymentController::class)->group(function () {
            Route::get('payments', 'index')->name('payments.index');
            Route::get('payments/create', 'create')->name('payments.create');
            Route::post('payments', 'store')->name('payments.store');
            Route::get('payments/{payment}', 'show')->name('payments.show');
            Route::get('payments/{payment}/edit', 'edit')->name('payments.edit');
            Route::put('payments/{payment}', 'update')->name('payments.update');
            Route::delete('payments/{payment}', 'destroy')->name('payments.destroy');
            Route::get('payments/{payment}/receipt', 'generateReceipt')->name('payments.receipt');
        });

        // Fee Collection
        Route::controller(FeeCollectionController::class)->group(function () {
            Route::get('fee-collection', 'index')->name('fee-collection');
            Route::get('fee-collection/create', 'create')->name('fee-collection.create');
            Route::post('fee-collection', 'store')->name('fee-collection.store');
        });

        // Reports
        Route::controller(FinanceReportController::class)->group(function () {
            Route::get('reports', 'index')->name('reports');
            Route::post('reports/generate', 'generateReport')->name('reports.generate');
            Route::get('reports/export', 'exportReport')->name('reports.export');
        });
    });
});

Route::group([
    'prefix' => 'admin/finance', 
    'as' => 'admin.finance.', 
    'middleware' => ['auth', 'admin']
], function () {
    Route::resource('tuition-fees', TuitionFeeController::class);
    Route::resource('transport-fees', TransportFeeController::class);
    Route::put('/payments/{payment}/approve', [PaymentController::class, 'approve'])->name('payments.approve');
    Route::put('/payments/{payment}/reject', [PaymentController::class, 'reject'])->name('payments.reject');
    Route::get('/reports', [ReportController::class, 'index'])->name('reports.index');
    Route::post('/reports/generate', [ReportController::class, 'generate'])->name('reports.generate');
});

Route::middleware(['auth', 'admin'])->group(function () {
    Route::prefix('admin')->name('admin.')->group(function () {
        Route::get('/dashboard', [App\Http\Controllers\Admin\DashboardController::class, 'index'])->name('dashboard');
        // Teachers Routes
        Route::resource('teachers', TeacherController::class);
        
        // Teacher Assignments Routes (Standalone)
        Route::get('assignments', [TeacherAssignmentController::class, 'index'])
            ->name('teachers.assignments.index');
        Route::get('assignments/create', [TeacherAssignmentController::class, 'create'])
            ->name('teachers.assignments.create');
        Route::post('assignments', [TeacherAssignmentController::class, 'store'])
            ->name('teachers.assignments.store');
        Route::get('assignments/{assignment}/edit', [TeacherAssignmentController::class, 'edit'])
            ->name('teachers.assignments.edit');
        Route::put('assignments/{assignment}', [TeacherAssignmentController::class, 'update'])->name('teachers.assignments.update');
        Route::delete('assignments/{assignment}', [TeacherAssignmentController::class, 'destroy'])->name('teachers.assignments.destroy');

        // Teacher-specific assignments (Nested)
        Route::get('teachers/{teacher}/assignments', [TeacherAssignmentController::class, 'teacherAssignments'])
            ->name('teachers.assignments.teacher');
        
        // Teaching Schedules Routes
        Route::controller(TeachingScheduleController::class)->group(function () {
            Route::get('schedules', 'index')->name('teachers.schedules.index');
            Route::get('schedules/create', 'create')->name('teachers.schedules.create');
            Route::post('schedules', 'store')->name('teachers.schedules.store');
            Route::get('schedules/{schedule}', 'show')->name('teachers.schedules.show');
            Route::get('schedules/{schedule}/edit', 'edit')->name('teachers.schedules.edit');
            Route::put('schedules/{schedule}', [TeachingScheduleController::class, 'update'])
                ->name('teachers.schedules.update');
            Route::delete('schedules/{schedule}', 'destroy')->name('teachers.schedules.destroy');
        });
        Route::get('admin/teachers/schedules/{schedule}', [TeachingScheduleController::class, 'show'])
            ->name('admin.teachers.schedules.show');

        // Timetable routes
        Route::get('timetables', [TimetableController::class, 'index'])->name('timetables.index');
        Route::get('timetables/create', [TimetableController::class, 'create'])->name('timetables.create');
        Route::post('timetables', [TimetableController::class, 'store'])->name('timetables.store');
        Route::get('timetables/{timetable}/edit', [TimetableController::class, 'edit'])->name('timetables.edit');
        Route::put('timetables/{timetable}', [TimetableController::class, 'update'])->name('timetables.update');
        Route::delete('timetables/{timetable}', [TimetableController::class, 'destroy'])->name('timetables.destroy');

        // Timetable slot teacher management
        Route::get('timetables/slots/{slot}/available-teachers', [TimetableController::class, 'getAvailableTeachers'])
            ->name('timetables.slots.available-teachers');
        Route::post('timetables/slots/{slot}/assign-teacher', [TimetableController::class, 'assignTeacher'])
            ->name('timetables.slots.assign-teacher');
        Route::delete('timetables/slots/{slot}/remove-teacher', [TimetableController::class, 'removeTeacher'])
            ->name('timetables.slots.remove-teacher');

        Route::get('timetables/slots/{slot}/assign', [TimetableController::class, 'showAssign'])
            ->name('timetables.slots.show-assign');
        Route::post('timetables/slots/{slot}/assign-teacher', [TimetableController::class, 'assignTeacher'])
            ->name('timetables.slots.assign-teacher');
        Route::delete('timetables/slots/{slot}/remove-teacher', [TimetableController::class, 'removeTeacher'])
            ->name('timetables.slots.remove-teacher');

        // Get subject-specific teachers
        Route::get('timetables/slots/{slot}/subject-teachers', [TimetableController::class, 'getSubjectTeachers'])
            ->name('timetables.slots.subject-teachers');

        // Student routes
        Route::resource('students', StudentController::class);

        // Student Payment Records (if not already defined in finance routes)
        Route::get('finance/payments', [PaymentController::class, 'index'])
            ->name('finance.payments.index');

        Route::get('students/{student}', [StudentController::class, 'show'])->name('students.show');
        Route::get('students/{student}/edit', [StudentController::class, 'edit'])->name('students.edit');
        Route::put('students/{student}', [StudentController::class, 'update'])->name('students.update');
    });
});

// Teacher Routes
Route::prefix('system/Teacher')->middleware(['auth', 'role:teacher'])->group(function () {
    Route::get('/teacher-dashboard', [App\Http\Controllers\Teacher\DashboardController::class, 'index'])
         ->name('teacher.dashboard');
});

// Supervisor Routes
Route::prefix('system')->middleware(['auth', 'role:supervisor'])->group(function () {
    Route::get('/supervisor-dashboard', [App\Http\Controllers\Supervisor\DashboardController::class, 'index'])
         ->name('supervisor.dashboard');
});

// User Routes
Route::prefix('system/user')->middleware(['auth', 'role:user'])->group(function () {
    Route::get('/user-dashboard', [App\Http\Controllers\User\DashboardController::class, 'index'])
         ->name('user.dashboard');
});



// Student Routes
Route::prefix('system/Student')->middleware(['auth', 'role:student'])->group(function () {
    Route::get('/student-dashboard', function () {
        return view('student.dashboard');
    })->name('student.dashboard');
});

Route::middleware(['auth', 'role:student'])->group(function () {
    Route::get('/subjects', [App\Http\Controllers\Student\SubjectController::class, 'index'])->name('student.subjects.index');
    Route::get('/subjects/{subject}', [App\Http\Controllers\Student\SubjectController::class, 'show'])->name('student.subjects.show');
    Route::get('/subjects/{subject}/pdf', [App\Http\Controllers\Student\SubjectController::class, 'viewPdf'])->name('student.subjects.pdf');
    Route::get('/timetable', [App\Http\Controllers\Student\TimetableController::class, 'index'])
         ->name('student.timetable');
});

Route::middleware(['auth', 'role:student', 'has.student.profile'])->group(function () {
    Route::get('/subjects', [App\Http\Controllers\Student\SubjectController::class, 'index'])->name('student.subjects.index');
    Route::get('/subjects/{subject}', [App\Http\Controllers\Student\SubjectController::class, 'show'])->name('student.subjects.show');
    Route::get('/subjects/{subject}/pdf', [App\Http\Controllers\Student\SubjectController::class, 'viewPdf'])->name('student.subjects.pdf');
});

Route::prefix('student')->middleware(['auth', 'role:student'])->name('student.')->group(function () {
    Route::get('/invoices', [App\Http\Controllers\Student\InvoiceController::class, 'index'])->name('invoices.index');
    Route::get('/invoices/{invoice}', [App\Http\Controllers\Student\InvoiceController::class, 'show'])->name('invoices.show');
    Route::get('/invoices/{invoice}/print', [App\Http\Controllers\Student\InvoiceController::class, 'print'])
        ->name('invoices.print');
    Route::get('/invoices/{invoice}/pay', [App\Http\Controllers\Student\InvoiceController::class, 'pay'])
        ->name('invoices.pay');
    Route::post('/invoices/{invoice}/pay', [App\Http\Controllers\Student\InvoiceController::class, 'submitPayment'])
        ->name('invoices.submitPayment');
    Route::get('/payments', [App\Http\Controllers\Student\PaymentController::class, 'index'])->name('payments.index');
    Route::get('/profile', [ProfileController::class, 'index'])->name('profile.index');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');
});