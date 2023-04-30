<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ConsigneeController;
use App\Http\Controllers\ShipmentController;



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
    return view('welcome');
});

Auth::routes(['verify' => true]);


Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::prefix('admin')->group(function() {

    Route::get('/dashboard',[App\Http\Controllers\Admin\DashboardController::class, 'index']);
});

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');


Route::get('/about', function(){
    return view('about-us');
})->name('about');

Route::get('/services', function(){
    return view('service');
})->name('service');

Route::get('/contact', function(){
    return view('contact');
})->name('contact');

Route::get('/login', function(){
    return view('login');
})->name('login');

Route::post('/user/login', [AuthController::class, 'login'])->name('submit.login');
Route::get('/logout', [AuthController::class, 'logout'])->name('logout');

Route::get('/admin/dashboard', function(){
    return view('admin.dashboard');
})->name('admin.dashboard');

Route::controller(UserController::class)->group(function(){
    Route::get('/admin/admin_list', 'admin_page')->name('admin_list');
    Route::get('/admin/employee_list', 'employee_page')->name('employee_list');
    Route::post('/admin/add_admin', 'add_admin')->name('add_admin');
    Route::post('/admin/add_employee', 'add_employee')->name('add_employee');
    Route::post('/admin/edit_admin/{id}', 'edit_admin')->name('edit_admin');
    Route::put('/admin/edit_employee/{id}', 'edit_employee')->name('edit_employee');
    Route::post('/admin/archive_user/{id}', 'archive_user')->name('archive_user');
    Route::post('/admin/restore_user/{id}', 'restore_user')->name('restore_user');
    Route::get('/admin/archive_admin', 'admin_archived_list')->name('admin_archive_list');
    Route::get('/admin/archive_employee', 'employee_archived_list')->name('employee_archived_list');
});

Route::controller(ConsigneeController::class)->group(function(){
    Route::get('/admin/client_list', 'client_page')->name('client_list');
    Route::post('admin/add_client', 'add')->name('add_client');
    Route::put('/clients/{id}', 'update')->name('update_client');
    Route::get('/admin/archive_consignee', 'archive_list')->name('consignee_archive_list');
    Route::post('/admin/archive_consignee/{id}', 'archive_client')->name('archive_client');
    Route::post('/admin/restore_consignee/{id}', 'restore_client')->name('restore_client');
    Route::get('/admin/consignee/{id}/open_shipment', 'open_shipment')->name('open_shipment');
    Route::get('/admin/consignee/{id}/closed_shipment', 'close_shipment')->name('close_shipment');
});

Route::controller(ShipmentController::class)->group(function(){
    Route::get('/admin/shipments', 'index')->name('shipments');
    Route::post('/admin/shipments', 'add')->name('add_shipment');
    Route::post('/admin/update_shipments/{id}', 'edit')->name('edit_shipment');
    Route::get('/admin/close_shipments', 'close_shipment')->name('close_shipments');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
