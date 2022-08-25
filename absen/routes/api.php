<?php

use Illuminate\Http\Request;
use App\User;

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

Route::post('/searchjemaat' , 'SuperAdminController@searchJemaat');
Route::post('/tarikdataprocess' , 'SuperAdminController@tarikDataProcess');
Route::post('/absenprocess' , 'SuperAdminController@absenProcess');
Route::post('/getqr','SuperAdminController@getQr');
Route::get('/checkconnected','SuperAdminController@isWaConnected');
Route::get('/sendmessage/{id}','SuperAdminController@sendMessage');
Route::post('/getwaflag' , 'SuperAdminController@getWaFlag');
Route::post('/searchulangtahun' , 'SuperAdminController@searchulangtahun');
