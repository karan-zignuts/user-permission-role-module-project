<?php

use App\Http\Controllers;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\ModuleController;
use App\Http\Controllers\RoleController;



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

$controller_path = 'App\Http\Controllers';

// Main Page Route
Route::get('/', $controller_path . '\pages\HomePage@index')->name('pages-home');
Route::get('/page-2', $controller_path . '\pages\Page2@index')->name('pages-page-2');

// pages
Route::get('/pages/misc-error', $controller_path . '\pages\MiscError@index')->name('pages-misc-error');

// authentication
// Route::get('/auth/login-basic', $controller_path . '\authentications\LoginBasic@index')->name('auth-login-basic');
Route::get('/auth/register-basic', $controller_path . '\authentications\RegisterBasic@index')->name('auth-register-basic');

Route::get('/auth/login-basic', $controller_path . '\authentications\LoginBasic@index')->name('auth-login-basic');
Route::post('/auth/login-basic', $controller_path . '\authentications\LoginBasic@login')->name('auth-login-basic.post');


//permissions
Route::controller(PermissionController::class)->group(function () {
  Route::get('permissions', 'index')->name('permissions.index');
  Route::post('/permissions', 'store')->name('permissions.store');
  Route::get('/permissions/create','create')->name('permissions.create');
  Route::get('/permissions/edit/{id}','edit')->name('permissions.edit');
  Route::put('/permissions/{id}','update')->name('permissions.update');
  Route::delete('/permissions/{id}','destroy')->name('permissions.destroy');
  // Route::post('/toggle-status/{id}','toggleStatus')->name('permissions.toggleStatus');
  Route::post('/permissions/toggleStatus/{permission_id}', 'toggleStatus')->name('permissions.toggleStatus');


  // Route::get('/toggle-status/{permission_id}/{status}', 'toggleStatus')->name('permissions.toggle-status');


});

//Modules
Route::get('/modules', [ModuleController::class, 'index'])->name('modules.index');
Route::get('/modules/edit/{module}', [ModuleController::class, 'edit'])->name('modules.edit');
Route::put('/modules/{module}', [ModuleController::class, 'update'])->name('modules.update');
Route::get('changeStatus', [ModuleController::class, 'changeStatus']);

//roles
Route::controller(RoleController::class)->group(function (){
    Route::get('/roles', [RoleController::class, 'index'])->name('roles.index');
    Route::get('/roles/create', [RoleController::class, 'create'])->name('roles.create');
    Route::post('/roles/store', [RoleController::class, 'store'])->name('roles.store');
    Route::get('/roles/edit/{id}', [RoleController::class, 'edit'])->name('roles.edit');
    Route::put('/roles/update/{id}', [RoleController::class, 'update'])->name('roles.update');
    Route::delete('/roles/delete/{id}', [RoleController::class, 'delete']);
  });



// Route::get('/permissions', [PermissionController::class, 'index'])->name('permissions.index');
// Route::get('/permissions/create', [PermissionController::class, 'create'])->name('permissions.create');
// Route::post('/permissions', [PermissionController::class, 'store'])->name('permissions.store');
// Route::get('/permissions/edit/{permission}', [PermissionController::class, 'edit'])->name('permissions.edit');
// Route::put('/permissions/{permission}', [PermissionController::class, 'update'])->name('permissions.update');
// Route::put('/permissions/{id}', [PermissionController::class, 'update'])->name('permissions.update');
// Route::delete('/permissions/{permission}', [PermissionController::class, 'destroy'])->name('permissions.destroy');


// Route::group(['prefix' => 'auth'], function () {
//   Route::post('login', [AuthController::class, 'login']);
//   Route::post('register', [AuthController::class, 'register']);

//   Route::group(['middleware' => 'auth:sanctum'], function () {
//       Route::get('logout', [AuthController::class, 'logout']);
//       Route::get('user', [AuthController::class, 'user']);
//   });
// });


// Route::get('login', [AuthController::class, 'login'])->name('auth.login');
// Route::post('/login', [AuthController::class, 'login'])->name('auth.login');
// Route::post('/register', [AuthController::class, 'register'])->name('auth.register');
// Route::middleware('auth:sanctum')->get('/user', 'AuthController@user');
// Route::middleware('auth:sanctum')->post('/logout', 'AuthController@logout');

// Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
// Route::post('/login', [AuthController::class, 'login'])->name('login.submit');
