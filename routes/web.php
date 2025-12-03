<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\SalleController;
use \App\Http\Controllers\ConsultationController;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\MedecinController;


Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    $user = Auth::user();

    if ($user->role === 'admin') {
        return redirect()->route('admin.dashboard');
    } elseif ($user->role === 'medecin') {
        return redirect()->route('medecin.dashboard');
    } else {
        abort(403, 'Accès non autorisé.');
    }
})->middleware(['auth'])->name('dashboard');

Route::middleware(['auth'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
});

Route::middleware(['auth'])->prefix('medecin')->name('medecin.')->group(function () {
    Route::get('/dashboard', [MedecinController::class, 'dashboard'])->name('dashboard');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});



Route::middleware(['auth'])->prefix('admin')->name('admin.')->group(function () {

    Route::resource('users', \App\Http\Controllers\Admin\UserController::class);

    Route::post('users/{id}/role', [\App\Http\Controllers\Admin\UserController::class, 'updateRole'])
        ->name('users.updateRole');

    Route::post('users/{id}/status', [\App\Http\Controllers\Admin\UserController::class, 'toggleStatus'])
        ->name('users.toggleStatus');


});


    // Médecins
    Route::get('/admin/medecins', [UserController::class, 'medecins'])->name('admin.medecins.index');

    // Patients
    Route::get('/admin/patients', [UserController::class, 'patients'])->name('admin.patients.index');
    Route::get('/patients', [UserController::class, 'patient'])->name('patients.index');


        Route::get('salles/create', [SalleController::class, 'create'])->name('salles.create');
        Route::post('salles', [SalleController::class, 'store'])->name('salles.store');
        Route::get('salles/{salle}/edit', [SalleController::class, 'edit'])->name('salles.edit');
        Route::put('salles/{salle}', [SalleController::class, 'update'])->name('salles.update');
        Route::delete('salles/{salle}', [SalleController::class, 'destroy'])->name('salles.destroy');

            Route::get('salles/index', [SalleController::class, 'index'])->name('salles.index');


// Liste toutes les consultations
Route::get('consultations', [ConsultationController::class, 'index'])
    ->name('consultations.index');

// Formulaire création consultation
Route::get('consultations/create', [ConsultationController::class, 'create'])
    ->name('consultations.create');

// Stocker nouvelle consultation
Route::post('consultations', [ConsultationController::class, 'store'])
    ->name('consultations.store');

// Afficher une consultation
Route::get('consultations/{id}', [ConsultationController::class, 'show'])
    ->name('consultations.show');

// Formulaire édition consultation
Route::get('consultations/{id}/edit', [ConsultationController::class, 'edit'])
    ->name('consultations.edit');

// Mettre à jour consultation
Route::put('consultations/{id}', [ConsultationController::class, 'update'])
    ->name('consultations.update');

// Supprimer une consultation
Route::delete('consultations/{id}', [ConsultationController::class, 'destroy'])
    ->name('consultations.destroy');

// Liste des consultations par patient
Route::get('patients/{patientId}/consultations', [ConsultationController::class, 'byPatients'])
    ->name('consultations.byPatient');

Route::get('patient/{patientId}/consultations', [ConsultationController::class, 'byPatient'])
    ->name('consultations.byPatientm');

// Liste des consultations par médecin
Route::get('medecins/{medecinId}/consultations', [ConsultationController::class, 'byMedecin'])
    ->name('consultations.byMedecin');

// Afficher le formulaire d’assignation
Route::get('/patients/{patient}/assigner', [SalleController::class, 'showAssignForm'])
    ->name('patients.showAssignForm')
    ->middleware(['auth']);

Route::post('/patients/{patient}/assigner', [SalleController::class, 'assignerPatient'])
    ->name('patients.assigner')
    ->middleware(['auth']);

// Faire quitter un patient d'une salle
Route::post('/patients/{patient}/quitter', [SalleController::class, 'quitterSalle'])
    ->name('patients.quitter')
    ->middleware(['auth']);








    require __DIR__.'/auth.php';
