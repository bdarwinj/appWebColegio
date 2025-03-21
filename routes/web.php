<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\EnrollmentController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CourseFeeController;
use App\Http\Controllers\PasswordController;
use App\Http\Controllers\ChangeUserPasswordController;
use App\Http\Controllers\ConfigController;
use App\Http\Controllers\ImportStudentController;
use App\Http\Controllers\DatabaseBackupController;

Route::get('/', function(){
    return redirect()->route('login');
});

Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('doLogin');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::middleware('auth')->group(function(){
    // Rutas disponibles para ambos roles (Admin y User)
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    
    // Courses
    Route::get('/courses', [CourseController::class, 'index'])->name('courses.index');
    Route::get('/courses/create', [CourseController::class, 'create'])->name('courses.create');
    Route::post('/courses', [CourseController::class, 'store'])->name('courses.store');
    
    // Course Fees
    Route::get('/course-fees/config', [CourseFeeController::class, 'config'])->name('course_fees.config');
    Route::post('/course-fees', [CourseFeeController::class, 'store'])->name('course_fees.store');
    Route::get('/course-fees/status', [CourseFeeController::class, 'status'])->name('course_fees.status');
    Route::get('/course-fees/status/ajax', [CourseFeeController::class, 'statusAjax'])->name('course_fees.status.ajax');

    
    // Students
    Route::get('/students', [StudentController::class, 'index'])->name('students.index');
    Route::get('/students/create', [StudentController::class, 'create'])->name('students.create');
    Route::post('/students', [StudentController::class, 'store'])->name('students.store');
    Route::get('/students/{id}', [StudentController::class, 'show'])->name('students.show');
    Route::get('/students/{id}/details', [StudentController::class, 'details'])->name('students.details');
    Route::get('/students/{id}/enrollments', [StudentController::class, 'enrollmentHistory'])->name('students.enrollmentHistory');
    Route::get('/students/{id}/edit', [StudentController::class, 'edit'])->name('students.edit');
    Route::put('/students/{id}', [StudentController::class, 'update'])->name('students.update');
    // Exportación de estudiantes
    Route::get('/students/export/pdf', [\App\Http\Controllers\ExportStudentController::class, 'exportPdf'])->name('students.export.pdf');
    Route::get('/students/export/excel', [\App\Http\Controllers\ExportStudentController::class, 'exportExcel'])->name('students.export.excel');
        
    // Import Students
    Route::get('/students/import', [ImportStudentController::class, 'showImportForm'])->name('students.import.form');
    Route::post('/students/import', [ImportStudentController::class, 'import'])->name('students.import');
    
    // Enrollments
    Route::get('/enrollments', [EnrollmentController::class, 'index'])->name('enrollments.index');
    Route::post('/enrollments/{id}/promote', [EnrollmentController::class, 'promote'])->name('enrollments.promote');
    
    // Payments
    Route::get('/payments/create', [PaymentController::class, 'create'])->name('payments.create');
    Route::post('/payments', [PaymentController::class, 'store'])->name('payments.store');
    Route::get('/payments/history/{student_id}', [PaymentController::class, 'history'])->name('payments.history');
    Route::get('/payments/history', [PaymentController::class, 'historyAll'])->name('payments.history.all');
    Route::get('/payments/receipt/{id}', [PaymentController::class, 'receipt'])->name('payments.receipt');
    
    // Users
    Route::get('/users', [UserController::class, 'index'])->name('users.index');
    Route::get('/users/create', [UserController::class, 'create'])->name('users.create');
    Route::post('/users', [UserController::class, 'store'])->name('users.store');

    // Gestión de Usuarios y Cambio de Contraseña
    Route::get('/password/change', [PasswordController::class, 'showChangeForm'])->name('password.change.form');
    Route::post('/password/change', [PasswordController::class, 'change'])->name('password.change');
    
    // Cambio de contraseña para otro usuario (solo admin)
    Route::get('/users/{id}/change-password', [ChangeUserPasswordController::class, 'showForm'])->name('users.change_password.form');
    Route::post('/users/{id}/change-password', [ChangeUserPasswordController::class, 'update'])->name('users.change_password');

    // Configuración
    Route::get('/config/edit', [ConfigController::class, 'edit'])->name('config.edit');
    Route::put('/config', [ConfigController::class, 'update'])->name('config.update');
    // Database Backup/Restore
    Route::get('/database/backup', [DatabaseBackupController::class, 'backup'])->name('database.backup');
    Route::post('/database/restore', [DatabaseBackupController::class, 'restore'])->name('database.restore');
});
