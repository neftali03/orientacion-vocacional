<?php

use Auth0\Laravel\Facade\Auth0;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\QuestionsController;
use App\Http\Controllers\CareerController;
use App\Http\Controllers\QuestionController;
use App\Http\Controllers\SchoolsController;
use App\Http\Controllers\HasuraTestController;
use App\Http\Controllers\ResultadoController;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Auth\LogoutController;
use App\Http\Controllers\UserSurveyController;
use App\Http\Controllers\DeepSeekController;

Route::get('/logout', LogoutController::class)->name('logout');

Route::middleware(['auth', 'hasura.user'])->group(function () {
    /* USER ************************************************************************************************************************** */
    Route::get('/', fn () => view('index'))->name('index');
    Route::get('/questions', [QuestionsController::class, 'questions'])->name('questions');
    Route::view('/institution', 'institution.institution')->name('institution');

    /* USER START TEST *************************************************************************************************************** */
    Route::post('/user-survey/store', [UserSurveyController::class, 'store'])->name('user-survey.store');
    Route::get('/test', [HasuraTestController::class, 'showQuestions'])->name('test');
    Route::post('/test', [HasuraTestController::class, 'saveAnswer'])->name('test.save');
    Route::post('/user-survey/deactivate', [UserSurveyController::class, 'deactivateSurvey'])->name('user-survey.deactivate');
    Route::get('/deepseek/result', [DeepSeekController::class, 'resultadoDesdeRespuestas'])->name('deepseek.result');
    Route::post('/deepseek/enviar-resultados', [DeepSeekController::class, 'enviarResultados'])->name('deepseek.enviarResultados');

    /* DEGREE USER ******************************************************************************************************************* */
    Route::get('/degree', [CareerController::class, 'showCareers'])->name('degree');

    /* ADMIN ************************************************************************************************************************* */
    Route::middleware(['hasura.role:admin'])->group(function () {
        /* DEGREE ADMIN ************************************************************************************************************** */
        Route::get('/degree/create', [CareerController::class, 'create'])->name('degree.create');
        Route::post('/degree', [CareerController::class, 'storeCareer'])->name('degree.store');
        Route::get('/degree/list', [CareerController::class, 'listAllCareers'])->name('degree.list');
        Route::get('/degree/{id}/edit', [CareerController::class, 'editCareer'])->name('degree.edit');
        Route::put('/degree/{id}', [CareerController::class, 'updateCareer'])->name('degree.update');
        Route::get('/degree/{id}/details', [CareerController::class, 'detailsCareer'])->name('degree.details');

        /* QUESTION ADMIN ************************************************************************************************************ */
        Route::get('/questions/create', [QuestionController::class, 'create'])->name('questions.create');
        Route::post('/questions', [QuestionController::class, 'storeQuestion'])->name('questions.store');
        Route::get('/questions/list', [QuestionController::class, 'listAllQuestions'])->name('questions.list');
        Route::get('/questions/{id}/edit', [QuestionController::class, 'editQuestion'])->name('questions.edit');
        Route::put('/questions/{id}', [QuestionController::class, 'updateQuestion'])->name('questions.update');
        Route::get('/questions/{id}/details', [QuestionController::class, 'detailQuestion'])->name('questions.details');
        
        /* SCHOOLS ADMIN ************************************************************************************************************* */
        Route::get('/institution/create', [SchoolsController::class, 'create'])->name('institution.create');
        Route::post('/institution', [SchoolsController::class, 'storeSchools'])->name('institution.store');
        Route::get('/institution/list', [SchoolsController::class, 'listAllSchools'])->name('institution.list');
        Route::get('/institution/{id}/edit', [SchoolsController::class, 'editSchool'])->name('institution.edit');
        Route::put('/institution/{id}', [SchoolsController::class, 'updateSchool'])->name('institution.update');
        Route::get('/institution/{id}/details', [SchoolsController::class, 'detailsSchools'])->name('institution.details');
    });

    /* DEEPSEEK ********************************************************************************************************************** */
    Route::get('/deepseek-test', [DeepSeekController::class, 'test']);
});

