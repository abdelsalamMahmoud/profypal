<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\UserController;
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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group([
    'prefix' => 'auth'
], function () {
    Route::post('/login', [AuthController::class, 'login']);
    Route::post('/register/user', [AuthController::class, 'registerUser']);
    Route::post('/register/company', [AuthController::class, 'registerCompany']);
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::post('/refresh', [AuthController::class, 'refresh']);
    Route::get('/user-profile', [AuthController::class, 'userProfile']);
});


############### start Company Routes #################

Route::get('/show/{company_id}/applications', [CompanyController::class, 'show_all_applications']);
Route::post('/create/{company_id}/application', [CompanyController::class, 'add_application']);
Route::post('/accept/profile/{id}', [CompanyController::class, 'acceptProfile']);
Route::post('/reject/profile/{id}', [CompanyController::class, 'rejectProfile']);
Route::post('/ban/application/{id}', [CompanyController::class, 'ban_application']);
Route::post('/edit/application/{id}', [CompanyController::class, 'update_application']);
Route::post('/destroy/application/{id}', [CompanyController::class, 'destroy_application']);

############### end Company Routes #################


############### start user Routes #################
Route::get('/view/applications', [UserController::class, 'view_all_posts']);
Route::post('/update/profile/{id}', [UserController::class, 'update_profile']);
Route::post('/apply/for/job/{application_id}', [UserController::class, 'apply_for_job']);
Route::get('/search/company', [UserController::class, 'search_for_company']);
############### end user Routes #################
