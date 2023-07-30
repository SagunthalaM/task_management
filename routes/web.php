<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\TaskController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Http\Controllers\UserController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('auth.login');
})->middleware('guest');

Auth::routes(['verify'=>true]);
//Socialite routes
Route::get('/auth/google/redirect', [App\Http\Controllers\SocialiteController::class, 'googleredirect'])->name('googlelogin');
Route::get('/auth/google/callback', [App\Http\Controllers\SocialiteController::class, 'googlecallback']);

//admin routes
Route::middleware(['auth','is_admin'])->group(function(){
        
    Route::get('tasks',[TaskController::class,'index'])->name('tasks.index');
    Route::get('tasks/create',[TaskController::class,'create'])->name('tasks.create');
    Route::post('tasks/store',[TaskController::class,'store']);
    Route::get('/taks/{id}',[TaskController::class,'show'])->name('tasks.show');
    Route::get('/edit-task/{task}',[TaskController::class,'edit'])->name('tasks.edit');
    Route::post('tasks/update/{id}',[TaskController::class,'update']);
    Route::delete('tasks/delete/{task}',[TaskController::class,'destroy'])->name('tasks.delete');
    Route::get('admin/add-user',[App\Http\Controllers\UserController::class,'AddUserIndex'])->name('admin.user.add');
    Route::post('admin/insert-user',[App\Http\Controllers\UserController::class,'InsertUser']);
    Route::get('/users/{id}',[UserController::class,'getUser'])->name('admin.user.get_user');
    Route::get('/edit-user/{user}',[App\Http\Controllers\UserController::class,'EditUser'])->name('admin.user.edit');
    Route::post('admin/update-user/{id}',[App\Http\Controllers\UserController::class,'UpdateUser']);
    Route::delete('/users/delete/{user}',[App\Http\Controllers\UserController::class,'DeleteUser'])->name('admin.user.delete');
    Route::get('/users',[UserController::class,'index'])->name('users.index');

});

//user view

Route::get('user-view',[TaskController::class,'UserView'])->name('users_view.index')->middleware('auth');


Route::put('/user-view/{taskId}/update-progress', [TaskController::class, 'updateProgress'])->name('tasks.update-progress')->middleware('auth');
