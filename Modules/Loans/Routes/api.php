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

Route::middleware('auth:customer')->prefix('loan')->group(function() {
    Route::post('/create', ['as' => 'api-loan.create', 'uses' => 'API\LoansController@store']);
    Route::get('/', ['as' => 'api-loan.get', 'uses' => 'API\LoansController@index']);
    Route::get('/info', ['as' => 'api-loan.getById', 'uses' => 'API\LoansController@detail']);

    Route::post('/repayment', ['as' => 'api-loan.repayment', 'uses' => 'API\LoansController@repayment']);
});