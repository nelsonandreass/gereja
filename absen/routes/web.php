<?php
use App\User;
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

Route::get('/', 'Controller@index');
Route::resource('/loginadmin' , 'AdminLoginController');
Route::resource('/registeradmin' , 'AdminRegisterController');
Route::get('/logout' , 'LogoutController@logout');
Route::get('/get' ,'LogoutController@check' );

Route::resource('/login' ,'LoginController');
Route::resource('/register' ,'RegisterController');

Route::get("/testumur" , function(){
    $users = User::select('tanggal_lahir',DB::raw('curdate() as tanggal'), DB::raw('ABS(DATEDIFF(tanggal_lahir, curdate())) as umur'))->get();
    $res = array();
    foreach($users as $user){
        $user->umur = floor($user->umur/365);
        if($user->umur >= 0 && $user->umur <= 30){
            array_push($res,$user);
        }
    }
    dd($res) ;
});

Route::group(['middleware' => ['authweb']],function(){
    Route::resource('/home' , 'HomeController');
    Route::resource('/berita' , 'BeritaController');
    Route::resource('/ayat' , 'AyatController');
    Route::resource('/profile' , 'ProfileController');
});

route::get('/uploadkartu','SuperAdminController@uploadkartu');

route::post('/uploadkartuprocess','SuperAdminController@uploadkartuprocess');


route::get('/clearcache' , function(){
   cache()->forget('users-keys');
});

Route::group(['middleware' => 'role'],function(){
    //home
    Route::get('/adminhome' , 'SuperAdminController@index');
    Route::get('/allabsen' , 'SuperAdminController@getAllAbsen');
    Route::get('/birthday' , 'SuperAdminController@getBirthdayThisWeek');

    //absen
    Route::get('/ibadah' , 'SuperAdminController@ibadah');
   // Route::post('/absenprocess' , 'SuperAdminController@absenProcess');
    Route::get('/getabsen' , 'SuperAdminController@getAbsen');
    Route::get('/absenlist/{ibadah}/{tanggal}','SuperAdminController@absenDetail');
    Route::get('/tarikdata' , 'SuperAdminController@tarikDataPage');
    Route::post('/tarikdataprocess' , 'SuperAdminController@tarikDataProcess');
    Route::get('/selesai/{jenis}/{tanggal}' , 'SuperAdminController@selesaiProcess');
    //jemaat
    Route::get('/listjemaat' , 'SuperAdminController@listjemaat');
    Route::get('/showjemaat/{id}' , 'SuperAdminController@showjemaat' );
    Route::post('/update/jemaat' , 'SuperAdminController@updatejemaat');
    Route::post('/searchjemaat' , 'SuperAdminController@searchJemaat');
    Route::get('/jemaatbaru' , 'SuperAdminController@jemaatbaru');
    Route::post('/savejemaatbaru' , 'SuperAdminController@savejemaatbaru');
    Route::get('/delete/{id}' , 'SuperAdminController@deleteJemaat');
    Route::get('/ulangtahun' , 'SuperAdminController@ulangtahun');

    //jemaat baru
    Route::resource('tempuser' , 'TempUserController');
    Route::get('/publish' , 'TempUserController@publishJemaatBaruVIew');
    Route::post('/publishprocess' , 'TempUserController@publishJemaatBaru');
    //end of jemaat baru

    // komsel
    Route::resource('komsel' , 'KomselController');
    Route::resource('komseldetail' , 'KomselMemberController');


    // end of komsel

    

    Route::get('/upload' , 'SuperAdminController@upload');
    Route::post('/uploadprocess' , 'SuperAdminController@uploadprocess');

    
    Route::get('/uploadfoto' , 'SuperAdminController@uploadfoto');
    Route::post('/uploadfotoprocess' , 'SuperAdminController@uploadfotoprocess');


    Route::get('/test' , 'SuperAdminController@test');
    Route::post('/testprocess' , 'SuperAdminController@testprocess');

});
Route::group(['middleware' => 'role'],function(){
    Route::resource('/tulisfirman' , 'AdminAyatController');
});