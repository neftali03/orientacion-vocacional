<?php

use Auth0\Laravel\Facade\Auth0;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\QuestionsController;
use App\Http\Controllers\CareerController;
use App\Http\Controllers\HasuraTestController;
use App\Http\Controllers\ResultadoController;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Auth\LogoutController;

Route::get('/logout', LogoutController::class)->name('logout');

Route::middleware(['auth', 'hasura.user'])->group(function () {
    Route::get('/', fn () => view('index'))->name('index');

    Route::get('/questions', [QuestionsController::class, 'questions'])->name('questions');
    Route::view('/institution', 'institution.institution')->name('institution');
    Route::get('/test', [HasuraTestController::class, 'showQuestions'])->name('test');
    Route::post('/test', [HasuraTestController::class, 'saveAnswer'])->name('test.save');
    Route::post('/enviar-user-id', [ResultadoController::class, 'mostrarResultados']);

    /* ******************************************** DEGREE USUARIO ******************************************** */
    Route::get('/degree', [CareerController::class, 'showCareers'])->name('degree');

    /* ******************************************** DEGREE ADMIN ******************************************** */
    
    // CREATE
    Route::get('/degree/create', [CareerController::class, 'create'])->name('degree.create');
    Route::post('/degree', [CareerController::class, 'storeCareer'])->name('degree.store'); // Cambiar de degree.list a degree.store

    // LIST
    Route::get('/degree/list', [CareerController::class, 'listAllCareers'])->name('degree.list');

    // EDIT & UPDATE
    Route::get('/degree/{id}/edit', [CareerController::class, 'editCareer'])->name('degree.edit');
    Route::put('/degree/{id}', [CareerController::class, 'updateCareer'])->name('degree.update');

    // DETAILS (va después del EDIT/UPDATE para evitar conflicto)
    Route::get('/degree/{id}/details', [CareerController::class, 'detailsCareer'])->name('degree.details');
});

