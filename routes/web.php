<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\AppointmentController;
use App\Http\Controllers\DepartementController;
use App\Http\Controllers\MedecinController;
use App\Http\Controllers\PatientController;

Route::get('/', function () {
    return redirect('/login');
});

Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::middleware(['auth'])->group(function () {
    // Client : demander un RDV
    Route::get('/appointments/create', [AppointmentController::class, 'create'])->name('appointments.create');
    Route::post('/appointments', [AppointmentController::class, 'store'])->name('appointments.store');

    // Staff : gestion des rendez-vous
    Route::get('/appointments', [AppointmentController::class, 'index'])->name('appointments.index');
    Route::get('/appointments-staff/create', [AppointmentController::class, 'createByStaff'])->name('appointments.create_staff');
    Route::post('/appointments-staff', [AppointmentController::class, 'storeByStaff'])->name('appointments.store_staff');
    Route::get('/appointments/{appointment}/edit', [AppointmentController::class, 'edit'])->name('appointments.edit');
    Route::put('/appointments/{appointment}', [AppointmentController::class, 'update'])->name('appointments.update');
    Route::delete('/appointments/{appointment}', [AppointmentController::class, 'destroy'])->name('appointments.destroy');

    Route::put('/notifications/{id}/read', [AppointmentController::class, 'markAsRead'])->name('notifications.read');

    // Staff : CRUD complet
    Route::resource('patients', PatientController::class);
    Route::resource('medecins', MedecinController::class);
    Route::resource('departements', DepartementController::class);
});