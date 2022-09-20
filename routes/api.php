<?php

use App\Http\Controllers\TaskController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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
//
//Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//    return $request->user();
//});


use App\Http\Controllers\AuthController;

Route::post('register',[AuthController::class,'register']);
Route::post('login',[AuthController::class,'login']);

Route::group(['middleware' => ['auth:api']], function () {
    Route::post('logout', [AuthController::class, 'logout']);
    Route::resource('tasks', TaskController::class)->names('tasks');
    Route::get('completed-tasks',[ TaskController::class, 'completedTasks'])->name('completed.tasks');
    Route::get('incompleted-tasks',[ TaskController::class, 'incompletedTasks'])->name('incompleted.tasks');
    Route::put('tasks/update-status/{id}', [TaskController::class, 'checkComplete'])->name('check.complete');
    Route::post('tasks/multiple-delete', [TaskController::class, 'multipleDelete']);
    Route::post('tasks/multiple-update', [TaskController::class, 'multipleComplete']);
}
);
