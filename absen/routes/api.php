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
Route::post('/sortjemaatbykecamatan' , 'JemaatController@sortByKecamatan');
Route::post('/sortjemaatbyumur' , 'JemaatController@sortByUmur');
//Route::post('/sortjemaat' , 'JemaatController@sortJemaat'); unknown effect
Route::post('/sortkomsel' , 'KomselController@sortKomsel');


//end of Jemaat section

// WA Connection
Route::post('/getqr','WaController@getQr');
Route::get('/checkconnected','WaController@isWaConnected');
Route::get('/sendmessage/{id}','WaController@sendMessage');
Route::post('/getwaflag' , 'WaController@getWaFlag');
Route::get('/sendqr/{id}','WaController@sendQrCodeUser');



//end of WA Connection

