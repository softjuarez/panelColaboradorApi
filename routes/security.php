<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\UsuarioExternoController;
use Illuminate\Support\Facades\Route;


Route::middleware(['auth'])->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::controller(UserController::class)->group(function () {
        Route::get('/users/index/{search?}', 'index')->middleware('permission:show-user')->name('users.index');
        Route::get('/users/new', 'new')->middleware('permission:new-user')->name('users.new');
        Route::post('/users/store', 'store')->middleware('permission:new-user')->name('users.store');
        Route::get('/users/edit/{user}', 'edit')->middleware('permission:edit-user')->name('users.edit');
        Route::post('/users/update/{user}', 'update')->middleware('permission:edit-user')->name('users.update');
        Route::get('/users/delete/{user}', 'delete')->middleware('permission:delete-user')->name('users.delete');
        Route::post('/users/attachRoles/{user}', 'attachRoles')->middleware('permission:edit-user')->name('users.attachRoles');
        Route::post('/users/updatePassword/{user}', 'updatePassword')->middleware('permission:edit-user')->name('users.updatePassword');
    });

    Route::controller(UsuarioExternoController::class)->group(function () {
        Route::get('/externos/index/{search?}', 'index')->middleware('permission:show-externo')->name('externos.index');
        Route::get('/externos/new', 'new')->middleware('permission:new-externo')->name('externos.new');
        Route::post('/externos/store', 'store')->middleware('permission:new-externo')->name('externos.store');
        Route::get('/externos/edit/{user}', 'edit')->middleware('permission:edit-externo')->name('externos.edit');
        Route::post('/externos/update/{user}', 'update')->middleware('permission:edit-externo')->name('externos.update');
        Route::get('/externos/delete/{user}', 'delete')->middleware('permission:delete-externo')->name('externos.delete');
        Route::post('/externos/attachRoles/{user}', 'attachRoles')->middleware('permission:edit-externo')->name('externos.attachRoles');
        Route::post('/externos/updatePassword/{user}', 'updatePassword')->middleware('permission:edit-externo')->name('externos.updatePassword');
    });

    Route::controller(RoleController::class)->group(function () {
        Route::get('/roles/index/{search?}', 'index')->middleware('permission:show-role')->name('roles.index');
        Route::get('/roles/new', 'new')->middleware('permission:new-role')->name('roles.new');
        Route::post('/roles/store', 'store')->middleware('permission:new-role')->name('roles.store');
        Route::get('/roles/edit/{role}', 'edit')->middleware('permission:edit-role')->name('roles.edit');
        Route::post('/roles/update/{role}', 'update')->middleware('permission:edit-role')->name('roles.update');
        Route::get('/roles/delete/{role}', 'delete')->middleware('permission:delete-role')->name('roles.delete');
        Route::post('/roles/attachPermissions/{role}', 'attachPermissions')->middleware('permission:edit-role')->name('roles.attachPermissions');
    });

    Route::controller(PermissionController::class)->group(function () {
        Route::get('/permissions/index/{search?}', 'index')->middleware('permission:show-permission')->name('permissions.index');
        Route::get('/permissions/new', 'new')->middleware('permission:new-permission')->name('permissions.new');
        Route::post('/permissions/store', 'store')->middleware('permission:new-permission')->name('permissions.store');
        Route::get('/permissions/edit/{permission}', 'edit')->middleware('permission:edit-permission')->name('permissions.edit');
        Route::post('/permissions/update/{permission}', 'update')->middleware('permission:edit-permission')->name('permissions.update');
        Route::get('/permissions/delete/{permission}', 'delete')->middleware('permission:delete-permission')->name('permissions.delete');
    });
});
