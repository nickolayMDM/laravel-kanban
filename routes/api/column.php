<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ColumnController;

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

Route::post('/column/post', [ColumnController::class, 'postColumn']);
Route::put('/column/edit', [ColumnController::class, 'editColumn']);
Route::put('/column/move', [ColumnController::class, 'moveColumn']);
Route::delete('/column/delete', [ColumnController::class, 'deleteColumn']);
