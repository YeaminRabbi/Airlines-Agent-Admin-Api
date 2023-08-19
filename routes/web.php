<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RoleManagementController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Auth;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Auth::routes(['verify' => true]);
Route::get('/', function () {
    return view('welcome');
});

Route::get('/home', function () {
    return redirect()->route('admin_dashboard');
});

Route::post('/user-login', [LoginController::class, 'LOGIN'])->name('LOGIN');

#~~~~~~~~~~~~ all admin panel routes ~~~~~~~~~~~~~~

Route::group(['prefix' => 'admin','middleware' => ['auth', 'role:admin']], function() {
    
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('admin_dashboard');

    Route::get('/profile', [ProfileController::class, 'profile'])->name('profile');
    Route::get('/profile/edit', [ProfileController::class, 'profile_edit'])->name('profile_edit');
    Route::post('/profile/update', [ProfileController::class, 'profile_update'])->name('profile_update');

    Route::get('/role-management', [RoleManagementController::class, 'index'])->name('role_management');
    Route::post('/role-management/add', [RoleManagementController::class, 'role_add'])->name('role_add');
    Route::get('/role-management/delete/{id}', [RoleManagementController::class, 'role_delete'])->name('role_delete');
    Route::post('/role-management/update', [RoleManagementController::class, 'role_update'])->name('role_update');
    Route::get('/get-role/{id}', [RoleManagementController::class, 'get_role'])->name('get_role');
    
    
    Route::post('/permission-management/add', [RoleManagementController::class, 'permission_add'])->name('permission_add');
    Route::get('/permission-management/delete/{id}', [RoleManagementController::class, 'permission_delete'])->name('permission_delete');
    Route::post('/permission-management/update', [RoleManagementController::class, 'permission_update'])->name('permission_update');
    Route::get('/get-permission/{id}', [RoleManagementController::class, 'get_permission'])->name('get_permission');
    Route::get('/fetch-permissions-by-role/{id}', [RoleManagementController::class, 'fetch_permissions'])->name('fetch_permissions_by_role');
    

    Route::post('/role-permission-assign', [RoleManagementController::class, 'role_permission_assign'])->name('role_permission_assign');
    Route::get('/role-permission-revoke/{id}', [RoleManagementController::class, 'role_permission_revoke'])->name('role_permission_revoke');

    Route::resource('users', UserController::class);
    Route::resource('service', ServiceController::class);
    

});