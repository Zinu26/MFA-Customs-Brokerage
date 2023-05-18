<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;

use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ConsigneeController;
use App\Http\Controllers\ShipmentController;
use App\Http\Controllers\ActivityLogController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\NotificationController;
use App\Http\Controllers\ChatBotController;
use App\Http\Controllers\FeedbackController;
use Illuminate\Auth\Events\Verified;

use Illuminate\Support\Facades\Auth;

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

// Route::get('/', function () {
//     return view('landing');
// });



// Route::get('/users/{user}/activity-logs', [ActivityLogController::class, 'index']);

// Route::post('/chatbot', [ChatBotController::class, 'handleRequest']);

Auth::routes(['verify' => true]);

//UNKNOWN USERS
Route::get('/', [ChatbotController::class, 'home'])->name('landing');

Route::post('send', [ChatBotController::class, 'sendChat'])->name('sendChat');
Route::post('/guest/send', [ChatBotController::class, 'guest_send'])->name('guest_send');


Route::get('/Track-Now', function () {
    return view('track');
})->name('track');

Route::get('/about', function () {
    return view('about-us');
})->name('about');

Route::get('/services', function () {
    return view('service');
})->name('service');

Route::get('/contact', function () {
    return view('contact');
})->name('contact');

Route::get('/login', function () {
    return view('login');
})->name('login');

Route::get('/client/login', function () {
    return view('client_login');
})->name('login.client');

Route::get('/search', [ShipmentController::class, 'search'])->name('search');

Route::post('/shipments/details', [NotificationController::class, 'getShipmentDetails'])->name('getShipmentDetails');

Route::post('/send/feedback', [FeedbackController::class, 'sendFeedback'])->name('sendFeedback');

//LOGIN
Route::post('/user/login', [AuthController::class, 'login'])->name('submit.login');
Route::post('/client/login', [AuthController::class, 'login_client'])->name('submit.login.client');
Route::post('/otp-verification', [AuthController::class, 'otpActivation'])->name('submit.otp');

//LOG OUT
Route::get('/user/logout', [AuthController::class, 'logout'])->name('logout');
Route::get('/logout', [AuthController::class, 'logout_client'])->name('logout_client');


//ADMIN PANEL
Route::middleware(['auth', 'user-type:admin'])->group(function () {
    Route::get('/admin/dashboard', [DashboardController::class, 'dashboard'])
        ->name('admin.dashboard')->middleware('verified');

    Route::controller(ActivityLogController::class)->group(function () {
        Route::get('/users/{user}/activity-logs', 'index');
        Route::get('/activity-logs/download', 'download')->name('activity-logs.download');
    });

    Route::get('/admin/feedback', [FeedbackController::class, 'index'])->name('admin.feedback');
    Route::post('/admin/read_feedback/{id}', [FeedbackController::class, 'read'])->name('admin.read');
    Route::post('/admin/unread_feedback/{id}', [FeedbackController::class, 'unread'])->name('admin.unread');

    Route::controller(UserController::class)->group(function () {
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

    Route::controller(ConsigneeController::class)->group(function () {
        Route::get('/admin/client_list', 'client_page')->name('client_list');
        Route::post('admin/add_client', 'add')->name('add_client');
        Route::put('/admin/clients/{id}', 'update')->name('update_client');
        Route::get('/admin/archive_consignee', 'archive_list')->name('consignee_archive_list');
        Route::post('/admin/archive_consignee/{id}', 'archive_client')->name('archive_client');
        Route::post('/admin/restore_consignee/{id}', 'restore_client')->name('restore_client');
        Route::get('/admin/consignee/{id}/open_shipment', 'open_shipment')->name('open_shipment');
        Route::get('/admin/consignee/{id}/closed_shipment', 'close_shipment')->name('close_shipment');
    });

    Route::controller(ShipmentController::class)->group(function () {
        Route::get('/admin/shipments', 'index')->name('shipments');
        Route::post('/admin/shipments', 'add')->name('add_shipment');
        Route::post('/admin/update_shipments/{id}', 'edit')->name('edit_shipment');
        Route::get('/admin/close_shipments', 'close_shipment')->name('close_shipments');
        Route::post('/admin/upload-files', 'uploadFiles')->name('upload_files');
        Route::get('/admin/files/{id}', 'download')->name('download_file');
    });
});

//EMPLOYEE PANEL
Route::middleware(['auth', 'user-type:employee'])->group(function () {
    Route::get('/employee/dashboard', [DashboardController::class, 'dashboard'])
        ->name('employee.dashboard')->middleware('verified');

    Route::get('/employee/feedback', [FeedbackController::class, 'index'])->name('employee.feedback');
    Route::post('/employee/read_feedback/{id}', [FeedbackController::class, 'read'])->name('employee.read');
    Route::post('/employee/unread_feedback/{id}', [FeedbackController::class, 'unread'])->name('employee.unread');

    Route::controller(ConsigneeController::class)->group(function () {
        Route::get('/employee/client_list', 'client_page')->name('client_list.employee');
        Route::post('employee/add_client', 'add')->name('add_client.employee');
        Route::put('/employee/clients/{id}', 'update')->name('update_client.employee');
        Route::get('/employee/archive_consignee', 'archive_list')->name('consignee_archive_list.employee');
        Route::post('/employee/archive_consignee/{id}', 'archive_client')->name('archive_client.employee');
        Route::post('/employee/restore_consignee/{id}', 'restore_client')->name('restore_client.employee');
        Route::get('/employee/consignee/{id}/open_shipment', 'open_shipment')->name('open_shipment.employee');
        Route::get('/employee/consignee/{id}/closed_shipment', 'close_shipment')->name('close_shipment.employee');
    });

    Route::controller(ShipmentController::class)->group(function () {
        Route::get('/employee/shipments', 'index')->name('shipments.employee');
        Route::post('/employee/shipments', 'add')->name('add_shipment.employee');
        Route::post('/employee/update_shipments/{id}', 'edit')->name('edit_shipment.employee');
        Route::get('/employee/close_shipments', 'close_shipment')->name('close_shipments.employee');
        Route::post('/employee/upload-files', 'uploadFiles')->name('upload_files.employee');
        Route::get('/employee/files/{id}', 'download')->name('download_file.employee');
    });
});

//CONSIGNEE PANEL
Route::middleware(['auth', 'user-type:consignee'])->group(function () {

    Route::controller(ConsigneeController::class)->group(function () {
        Route::get('/clients/dashboard', 'consignee_dashboard')->name('client.dashboard');
        Route::get('/clients/open_shipment', 'consignee_open_shipment')->name('consignee_open_shipment');
        Route::get('/clients/close_shipment', 'consignee_close_shipment')->name('consignee_close_shipment');
        Route::get('/clients/download/report', 'downloadCsv')->name('downloadCsv');
        Route::get('/clients/download-by-date/report/', 'downloadCsv_by_date')->name('downloadCsv_by_date');
    });

    Route::post('/notifications/{id}/mark-as-read', [NotificationController::class, 'markAsRead']);

    Route::get('/client/notification', function () {
        return view('clients.notification');
    })->name('notification');
});
