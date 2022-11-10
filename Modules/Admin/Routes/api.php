<?php

use Illuminate\Http\Request;

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

Route::prefix('admin')->group(function() {
    Route::group(['middleware' => ['guest:admin_api']], function() {
        Route::post('/login', ['as' => 'api-admin.login', 'uses' => 'API\AdminController@login']);
    });

    Route::group(['middleware' => ['auth:admin_api']], function() {
        Route::get('/loans', ['as' => 'api-admin.loan', 'uses' => 'API\AdminController@loan']);
        Route::post('/loan/approved', ['as' => 'api-admin.approved-loan', 'uses' => 'API\AdminController@loanApproved']);
    });
});