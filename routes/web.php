<?php

use App\Http\Controllers;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\ModuleController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\UsersController;
use App\Http\Controllers\authentications\LoginBasic;
use App\Http\Controllers\UserSideController;
use App\Http\Controllers\InvitationController;
use App\Http\Controllers\PeoplesController;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\NoteController;
use App\Http\Controllers\MeetingController;
use App\Http\Controllers\ActivityController;
// use Illuminate\Support\Facades\Auth;

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


//login
// Public routes
Route::get('/', [LoginBasic::class, 'index'])->name('auth-login-basic');
Route::post('/login', [LoginBasic::class, 'login'])->name('login');

Route::middleware('auth:sanctum')->group(function () {
    //admin side
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    //permissions routes
    Route::get('permissions', [PermissionController::class, 'index'])->name('permissions.index');
    Route::post('/permissions', [PermissionController::class, 'store'])->name('permissions.store');
    Route::get('/permissions/create', [PermissionController::class, 'create'])->name('permissions.create');
    Route::get('/permissions/edit/{id}', [PermissionController::class, 'edit'])->name('permissions.edit');
    Route::put('/permissions/{id}', [PermissionController::class, 'update'])->name('permissions.update');
    Route::delete('/permissions/{id}', [PermissionController::class, 'destroy'])->name('permissions.destroy');
    Route::post('/permissions/toggleStatus/{permission_id}', [PermissionController::class, 'toggleStatus'])->name('permissions.toggleStatus');

    //Modules routes
    Route::get('/modules', [ModuleController::class, 'index'])->name('modules.index');
    Route::get('/modules/edit/{module}', [ModuleController::class, 'edit'])->name('modules.edit');
    Route::put('/modules/{module}', [ModuleController::class, 'update'])->name('modules.update');
    Route::get('changeStatus', [ModuleController::class, 'changeStatus']);
    Route::put('modules/toggleStatus/{submoduleId}', [ModuleController::class, 'toggleStatus'])->name('modules.toggleStatus');

    //roles routes
    Route::get('/roles', [RoleController::class, 'index'])->name('roles.index');
    Route::get('/roles/create', [RoleController::class, 'create'])->name('roles.create');
    Route::get('/roles/edit/{id}', [RoleController::class, 'edit'])->name('roles.edit');
    Route::post('/roles/store', [RoleController::class, 'store'])->name('roles.store');
    Route::delete('/roles/delete/{id}', [RoleController::class, 'delete'])->name('roles.destroy');
    Route::put('/roles/update/{id}', [RoleController::class, 'update'])->name('roles.update');
    Route::post('/roles/updateStatus', [RoleController::class, 'updateStatus'])->name('roles.updateStatus');

    //user controller route for admin side
    Route::get('/users', [UsersController::class, 'index'])->name('users.index');
    Route::get('/users/create', [UsersController::class, 'create'])->name('users.create');
    Route::get('/users/{user}/edit', [UsersController::class, 'edit'])->name('users.edit');
    Route::post('/users', [UsersController::class, 'store'])->name('users.store');
    Route::delete('/users/{user}', [UsersController::class, 'destroy'])->name('users.destroy');
    Route::put('/users/{id}', [UsersController::class, 'update'])->name('users.update');
    Route::post('/users/toggle-status', [UsersController::class, 'toggleStatus'])->name('users.toggle-status');
    Route::get('/resetPassword/{userId}', [UsersController::class, 'showResetPasswordForm'])->name('resetPass');
    Route::post('/reset-password/{userId}', [UsersController::class, 'resetPassword'])->name('user.resetPassword');
    Route::post('/force-logout/{userId}', [UsersController::class, 'forceLogout'])->name('forceLogout');

    //userside routes
    //userside controller route for user side
    Route::get('/user-details', [UserSideController::class, 'show'])->name('userside.details');
    Route::get('/user-details/edit', [UserSideController::class, 'edit'])->name('userside.edit');
    Route::post('/user-details/update', [UserSideController::class, 'update'])->name('userside.update');
    Route::get('/change-password', [UserSideController::class, 'showChangePasswordForm'])->name('changePassword');
    Route::post('/change-password', [UserSideController::class, 'changePassword'])->name('savePassword');

    //Invitation token route
    Route::get('/accept-invite/{token}', [InvitationController::class, 'acceptInvite'])->name('acceptinvite');
    Route::post('/accept-invite/set-password', [InvitationController::class, 'setPassword'])->name('setpassword');


    //companies route
    Route::get('/companies', [CompanyController::class, 'index'])->name('companies.index')->middleware('access:1.1,view');
    Route::get('/companies/create', [CompanyController::class, 'create'])->name('companies.create')->middleware('access:1.1,create');
    Route::post('/companies', [CompanyController::class, 'store'])->name('companies.store')->middleware('access:1.1,create');
    Route::get('/companies/{company}', [CompanyController::class, 'show'])->name('companies.show')->middleware('access:1.1,view');
    Route::get('/companies/edit/{company}', [CompanyController::class, 'edit'])->name('companies.edit')->middleware('access:1.1,edit');
    Route::put('/companies/{company}', [CompanyController::class, 'update'])->name('companies.update')->middleware('access:1.1,edit');
    Route::delete('/companies/{company}', [CompanyController::class, 'destroy'])->name('companies.destroy')->middleware('access:1.1,delete');


    //people route
    Route::get('/people', [PeoplesController::class, 'index'])->name('people.index')->middleware('access:1.2,view');
    Route::get('/people/create', [PeoplesController::class, 'create'])->name('people.create')->middleware('access:1.2,create');
    Route::post('/people/store', [PeoplesController::class, 'store'])->name('people.store')->middleware('access:1.2,create');
    Route::get('/people/edit/{id}', [PeoplesController::class, 'edit'])->name('people.edit')->middleware('access:1.2,edit');
    Route::put('/people/update/{id}', [PeoplesController::class, 'update'])->name('people.update')->middleware('access:1.2,edit');
    Route::delete('/people/delete/{id}', [PeoplesController::class, 'destroy'])->name('people.destroy')->middleware('access:1.2,delete');
    Route::post('/people/updateStatus', [PeoplesController::class, 'updateStatus'])->name('people.updateStatus')->middleware('access:1.2,edit');


    //Notes route
    Route::get('/notes', [NoteController::class, 'index'])->name('notes.index')->middleware('access:2.1,view');
    Route::get('/notes/create', [NoteController::class, 'create'])->name('notes.create')->middleware('access:2.1,create');
    Route::post('/notes', [NoteController::class, 'store'])->name('notes.store')->middleware('access:2.1,create');
    Route::get('/notes/{note}', [NoteController::class, 'show'])->name('notes.show')->middleware('access:2.1,view');
    Route::get('/notes/edit/{note}', [NoteController::class, 'edit'])->name('notes.edit')->middleware('access:2.1,edit');
    Route::put('/notes/{note}', [NoteController::class, 'update'])->name('notes.update')->middleware('access:2.1,edit');
    Route::delete('/notes/{note}', [NoteController::class, 'destroy'])->name('notes.destroy')->middleware('access:2.1,delete');



    //activity route
    Route::get('/activities', [ActivityController::class, 'index'])->name('activities.index')->middleware('access:2.2,view');
    Route::get('/activities/create', [ActivityController::class, 'create'])->name('activities.create')->middleware('access:2.2,create');
    Route::post('/activities', [ActivityController::class, 'store'])->name('activities.store')->middleware('access:2.2,create');
    Route::get('/activities/{activity}/edit', [ActivityController::class, 'edit'])->name('activities.edit')->middleware('access:2.2,edit');
    Route::put('/activities/{activity}', [ActivityController::class, 'update'])->name('activities.update')->middleware('access:2.2,edit');
    Route::delete('/activities/{activity}', [ActivityController::class, 'destroy'])->name('activities.destroy')->middleware('access:2.2,delete');
    Route::post('/activities/updateStatus', [ActivityController::class, 'updateStatus'])->name('activities.updateStatus')->middleware('access:2.2,edit');


    // Meetings routes
    Route::get('/meetings', [MeetingController::class, 'index'])->name('meetings.index')->middleware('access:2.3,view');
    Route::get('/meetings/create', [MeetingController::class, 'create'])->name('meetings.create')->middleware('access:2.3,create');
    Route::post('/meetings/store', [MeetingController::class, 'store'])->name('meetings.store')->middleware('access:2.3,create');
    Route::get('/meetings/{meeting}/edit', [MeetingController::class, 'edit'])->name('meetings.edit')->middleware('access:2.3,edit');
    Route::put('/meetings/{meeting}/update', [MeetingController::class, 'update'])->name('meetings.update')->middleware('access:2.3,edit');
    Route::delete('/meetings/{meeting}/delete', [MeetingController::class, 'destroy'])->name('meetings.destroy')->middleware('access:2.3,delete');
    Route::post('/meetings/updateStatus', [MeetingController::class, 'updateStatus'])->name('meetings.updateStatus')->middleware('access:2.3,edit');

});

Route::post('/logout', function () {
    auth()->logout();
    return redirect()->route('auth-login-basic');
})->name('logout');
