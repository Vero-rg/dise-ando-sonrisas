<?php

use App\Http\Controllers\Admin\AppointmentController as AdminAppointmentController;
use App\Http\Controllers\Admin\HeroImageController as AdminHeroImageController;
use App\Http\Controllers\Admin\ServiceImageController as AdminServiceImageController;
use App\Http\Controllers\Admin\TreatmentResultController as AdminTreatmentResultController;
use App\Http\Controllers\AppointmentController;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Route;

Route::get('/', [AppointmentController::class, 'index'])->name('home');

Route::post('/citas', [AppointmentController::class, 'store'])
    ->middleware('throttle:10,1')
    ->name('citas.store');

Route::middleware(['auth', 'verified'])->group(function () {
    // Legacy: se conserva para uso futuro, sin acceso desde la navegación.
    Route::inertia('dashboard', 'Dashboard')->name('dashboard');

    Route::prefix('admin')->name('admin.')->group(function () {
        Route::get('citas', [AdminAppointmentController::class, 'index'])
            ->name('citas.index');

        Route::patch('citas/{appointment}/estado', [AdminAppointmentController::class, 'updateStatus'])
            ->name('citas.estado');

        Route::patch('citas/{appointment}/reagendar', [AdminAppointmentController::class, 'reschedule'])
            ->name('citas.reagendar');

        Route::get('resultados', [AdminTreatmentResultController::class, 'index'])
            ->name('resultados.index');

        Route::post('resultados', [AdminTreatmentResultController::class, 'store'])
            ->name('resultados.store');

        Route::post('resultados/{result}', [AdminTreatmentResultController::class, 'update'])
            ->name('resultados.update');

        Route::patch('resultados/{result}/visibilidad', [AdminTreatmentResultController::class, 'toggleVisibility'])
            ->name('resultados.visibilidad');

        Route::delete('resultados/{result}', [AdminTreatmentResultController::class, 'destroy'])
            ->name('resultados.destroy');

        Route::get('servicios', [AdminServiceImageController::class, 'index'])
            ->name('servicios.index');

        Route::post('servicios', [AdminServiceImageController::class, 'store'])
            ->name('servicios.store');

        Route::delete('servicios', [AdminServiceImageController::class, 'destroy'])
            ->name('servicios.destroy');

        Route::get('portada', [AdminHeroImageController::class, 'index'])
            ->name('portada.index');

        Route::post('portada', [AdminHeroImageController::class, 'store'])
            ->name('portada.store');

        Route::delete('portada/{heroImage}', [AdminHeroImageController::class, 'destroy'])
            ->name('portada.destroy');
    });
});

Route::get('/clear-all', function () {
    Artisan::call('storage:link');

    return 'linked';
});

require __DIR__.'/settings.php';
