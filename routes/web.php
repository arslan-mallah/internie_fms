<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\generalexportController;
use App\Http\Controllers\resultexportController;
use App\Http\Middleware\RedirectIfExpired;

use App\Http\Controllers\Admin\{
    ProfileController,
    MailSettingController,
};

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



Route::get('/', function () {
    return view('auth.login');
})->middleware('guest');


Route::get('/test-mail',function(){

    $message = "Testing mail";

    \Mail::raw('Hi, welcome!', function ($message) {
      $message->to('webdevgravitytech@gmail.com')
        ->subject('Testing mail');
    });

    dd('sent');

});

Route::get('/admin/general_ledger/export-csv', [generalexportController::class,'export']);
Route::get('/admin/result_ledger/export-csv', [resultexportController::class,'export']);

Route::get('/dashboard', function () {
    return view('front.dashboard');
})->middleware(['front'])->name('dashboard');


require __DIR__.'/front_auth.php';

// Admin routes
Route::get('/admin/dashboard', [App\Http\Controllers\Admin\NotificationController::class,'totalrecord'], function () {
})->middleware(['auth'])->name('admin.dashboard');



require __DIR__.'/auth.php';




Route::namespace('App\Http\Controllers\Admin')->name('admin.')->prefix('admin')->middleware(['auth', 'RedirectIfExpired'])
    ->group(function(){
        Route::resource('roles','RoleController');
        Route::resource('permissions','PermissionController');
        Route::resource('users','UserController');
        Route::resource('addpay','AddpayController');
        Route::resource('general_ledger','GeneralController');
        Route::resource('result_ledger','ResultController');
        Route::resource('graph_analysis','GraphController');
        Route::resource('employee','EmployeeController');
        Route::resource('attendance','AttendanceController');
        Route::resource('notification','NotificationController');
        Route::resource('categories','CategoriesController');

////////////custom routes

Route::post('general_ledger', [App\Http\Controllers\Admin\GeneralController::class, 'filter'])->name('general_ledger');
Route::post('result_ledger', [App\Http\Controllers\Admin\ResultController::class, 'filter'])->name('result_ledger');
Route::post('graph_analysis', [App\Http\Controllers\Admin\GraphController::class, 'filter'])->name('graph_analysis');
Route::post('graphs', [App\Http\Controllers\Admin\GraphController::class, 'ajaxData'])->name('graphs');
Route::post('graphss', [App\Http\Controllers\Admin\GraphController::class, 'ajaxDataa'])->name('graphss');
Route::post('graphsss', [App\Http\Controllers\Admin\GraphController::class, 'ajaxDataaa'])->name('graphsss');
Route::post('graphssss', [App\Http\Controllers\Admin\GraphController::class, 'ajaxDataaaa'])->name('graphssss');
Route::get('tabledata',[App\Http\Controllers\Admin\AttendanceController::class,'showData'])->name('tabledata');
Route::post('updateattend',[App\Http\Controllers\Admin\AttendanceController::class,'updateattendance'])->name('updateattend');
Route::post('attendance',[App\Http\Controllers\Admin\AttendanceController::class,'filterattendance'])->name('attendance');
Route::post('attendancee.action', [App\Http\Controllers\Admin\AttendanceController::class,'action'])->name('attendancee.action');
Route::post('updatenotification', [App\Http\Controllers\Admin\NotificationController::class,'mark']);
Route::get('notificationss', [App\Http\Controllers\Admin\NotificationController::class,'tabledata']);
Route::post('deletenotification', [App\Http\Controllers\Admin\NotificationController::class,'deletedata']);

///////////


        Route::get('/profile',[ProfileController::class,'index'])->name('profile');
        Route::put('/profile-update',[ProfileController::class,'update'])->name('profile.update');
        Route::get('/mail',[MailSettingController::class,'index'])->name('mail.index');
        Route::put('/mail-update/{mailsetting}',[MailSettingController::class,'update'])->name('mail.update');
});