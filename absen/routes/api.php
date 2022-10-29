<?php

use Illuminate\Http\Request;
use App\User;

/*
|--------------------------------------------------------------------------
| API Routes
-----------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/



//Jemaat section
Route::post('/searchjemaat' , 'JemaatController@searchJemaat');
Route::post('/tarikdataprocess' , 'AbsenController@tarikDataProcess');
Route::post('/absenprocess' , 'AbsenController@absenProcess');
Route::post('/searchulangtahun' , 'JemaatController@searchulangtahun');
Route::post('/sortjemaat' , 'JemaatController@sortByKecamatan');
Route::post('/sortjemaatbyumur' , 'JemaatController@sortByUmur');


//end of Jemaat section

// WA Connection
Route::post('/getqr','SuperAdminController@getQr');
Route::get('/checkconnected','WaController@isWaConnected');
Route::get('/sendmessage/{id}','WaController@sendMessage');
Route::post('/getwaflag' , 'WaController@getWaFlag');
//end of WA Connection

