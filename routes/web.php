<?php

use Illuminate\Support\Facades\Route;
  
use App\Http\Controllers\HomeController;
use App\Http\Controllers\GoogleController;
use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\EmployeeProfileController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\Admin\ProfileController;
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
});

Auth::routes();


Route::get('auth/google', [GoogleController::class, 'redirectToGoogle']);
Route::get('auth/google/callback', [GoogleController::class, 'handleGoogleCallback']);

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

//admin part start
Route::group(['prefix' =>'admin/', 'middleware' => ['auth', 'is_admin']], function(){

Route::get('dashboard', [HomeController::class, 'dashboard'])->name('admin.home');
// admin profile
Route::get('/profile', [ProfileController::class, 'index'])->name('admin.profile');
Route::put('/profile/{id}', [ProfileController::class, 'update']);

// change admin password
Route::get('password/edit', [ProfileController::class, 'passwordEdit'])->name('admin.password');
Route::post('changepassword', [ProfileController::class, 'changeUserPassword']);

// employee list
Route::get('/employee', [EmployeeController::class, 'index'])->name('admin.employeelist');
Route::post('/employee', [EmployeeController::class, 'index'])->name('admin.employeesearch');
Route::post('/employee-store', [EmployeeController::class, 'store']);
Route::get('/employee/{id}/edit', [EmployeeController::class, 'edit']);
Route::put('/employee/{id}', [EmployeeController::class, 'update']);
Route::get('/employee/{id}', [EmployeeController::class, 'delete']);

// employee details
Route::get('/employee-detail', [EmployeeController::class, 'employeedetail'])->name('admin.employeedetail');
Route::get('/employee-contact', [EmployeeController::class, 'employecontact'])->name('admin.employecontact');
Route::post('/employee-detail', [EmployeeController::class, 'employeedetailstore']);
Route::get('/employee-detail/{id}/edit', [EmployeeController::class, 'employeedetailedit']);
Route::put('/employee-detail/{id}', [EmployeeController::class, 'employeedetailupdate']);
Route::get('/employee-detail/{id}', [EmployeeController::class, 'employeedetaildelete']);

// change employee password
Route::get('all-employee', [EmployeeController::class, 'getEmployee'])->name('admin.allemployee');
Route::post('employee/changepassword', [EmployeeController::class, 'changeUserPassword']);
// attendance
Route::get('/attendance', [AttendanceController::class, 'showAdminAttendance'])->name('admin.attendance');
});

//employee part start
Route::group(['prefix' =>'employee/', 'middleware' => ['auth', 'is_employee']], function(){

Route::get('dashboard', [HomeController::class, 'employeeDashboard'])->name('employee.home');
// admin profile
Route::get('/profile', [EmployeeProfileController::class, 'index'])->name('employee.profile');
Route::put('/profile/{id}', [EmployeeProfileController::class, 'update']);

// attendance
Route::get('/attendance', [AttendanceController::class, 'employeeAttendance'])->name('employee.attendance');
Route::post('/attendance-start', [AttendanceController::class, 'employeeAttendanceStore']);
Route::post('/attendance-end', [AttendanceController::class, 'employeeAttendanceCloseStore']);
Route::get('/my-attendance', [AttendanceController::class, 'myAttendance'])->name('employee.myattendance');


// change admin password
Route::get('password/edit', [EmployeeProfileController::class, 'passwordEdit'])->name('employee.password');
Route::post('changepassword', [EmployeeProfileController::class, 'changeUserPassword']);
});