<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\CardController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::get('/card/list', [CardController::class, 'listCards'])->middleware(['accessToken']);
Route::post('/card/post', [CardController::class, 'postCard']);
Route::put('/card/edit', [CardController::class, 'editCard']);
Route::put('/card/move', [CardController::class, 'moveCard']);
Route::delete('/card/delete', [CardController::class, 'deleteCard']);
