<?php

use Auth0\Laravel\Facade\Auth0;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\QuestionsController;
use App\Http\Controllers\CareerController;
use App\Http\Controllers\HasuraTestController;
use App\Http\Controllers\ResultadoController;

Route::middleware(['auth', 'hasura.user'])->group(function () {
  Route::get('/', fn () => view('index'))->name('index');
  Route::get('/degree', [CareerController::class, 'showCareers'])->name('degree');
  Route::get('/questions', [QuestionsController::class, 'questions'])->name('questions');
  Route::view('/institution', 'institution.institution')->name('institution');
  Route::get('/test', [HasuraTestController::class, 'showQuestions'])->name('test');
  Route::post('/test', [HasuraTestController::class, 'saveAnswer'])->name('test.save');
  Route::post('/enviar-user-id', [ResultadoController::class, 'mostrarResultados']);
});

/*Route::get('/', function () {
    return view('index');
})->name('index')->middleware('auth');
Route::view('/degree', 'degree.degree')->name('degree')->middleware('auth');
Route::get('/questions', [QuestionsController::class, 'questions'])->name('questions')->middleware('auth');
Route::view('/institution', 'institution.institution')->name('institution')->middleware('auth');
Route::get('/test', [HasuraTestController::class, 'showQuestions'])->name('test')->middleware('auth');
Route::post('/test', [HasuraTestController::class, 'saveAnswer'])->name('test.save')->middleware('auth');
Route::post('/enviar-user-id', [ResultadoController::class, 'mostrarResultados'])->middleware('auth');
*/
/*Route::get('/private', function () {
  return response('Welcome! You are logged in.');
})->middleware('auth');*/

/*Route::get('/scope', function () {
    return response('You have `read:messages` permission, and can therefore access this resource.');
})->middleware('auth')->can('read:messages');*/

/*Route::get('/', function () {
    $user = auth()->user();
    $name = $user->name ?? 'User';
    $email = $user->email ?? '';

    return response("Hello {$name}! Your email address is {$email}.");
})->middleware('auth');*/

/*Route::get('/colors', function () {
  $endpoint = Auth0::management()->users();

  $colors = ['red', 'blue', 'green', 'black', 'white', 'yellow', 'purple', 'orange', 'pink', 'brown'];

  $endpoint->update(
    id: auth()->id(),
    body: [
        'user_metadata' => [
            'color' => $colors[random_int(0, count($colors) - 1)]
        ]
    ]
  );

  $metadata = $endpoint->get(auth()->id()); // Retrieve the user's metadata.
  $metadata = Auth0::json($metadata); // Convert the JSON to a PHP array.

  $color = $metadata['user_metadata']['color'] ?? 'unknown';
  $name = auth()->user()->name;

  return response("Hello {$name}! Your favorite color is {$color}.");
})->middleware('auth');*/
