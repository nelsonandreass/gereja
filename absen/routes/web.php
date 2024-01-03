<?php
use App\User;
use App\Absen;
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
    var_dump($res) ;
});
Route::get("/checkuser",function(){
    $users = Absen::select('user_id','tanggal','jenis')
    ->where('user_id','0573309913')
    ->whereYear('tanggal', "2023")
    ->distinct()
    ->get();
    foreach ($users as $user) {
        # code...
        echo($user->user_id." ".$user->jenis." ".$user->tanggal ."|");

    }
    //echo(sizeof($users));
});
Route::get("/testrank" , function(){
    $year = 2023;
    $result = array();
    $absens = Absen::with('users')->select('user_id' , DB::raw('COUNT(*) as attendance_count'))
        ->whereYear('tanggal', $year)
        ->groupBy('user_id')
        ->orderByDesc('attendance_count')
        ->limit(10)
        ->get()
        ->toArray();
    foreach ($absens as $absen) {
        foreach ($absen['users'] as $user) {
            # code...
            array_push($result,['Nama' => $user['name'] , 'Kedatangan' => $absen['attendance_count'] , 'NoKartu' => $user['kartu']]);
        }
    }
    var_dump(json_encode($result));
    die();
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

//use this for delete wa session
Route::get('/deletewa' , 'WaController@delete');

Route::group(['middleware' => 'role'],function(){
    //home
    Route::get('/adminhome' , 'SuperAdminController@index');
    Route::get('/allabsen' , 'SuperAdminController@getAllAbsen');
    Route::get('/birthday' , 'SuperAdminController@getBirthdayThisWeek');

    //absen
    Route::get('/ibadah' , 'SuperAdminController@ibadah');
    Route::get('/getabsen' , 'SuperAdminController@getAbsen');
    Route::get('/absenlist/{ibadah}/{tanggal}','SuperAdminController@absenDetail');
    Route::get('/tarikdata' , 'SuperAdminController@tarikDataPage');
    Route::post('/tarikdataprocess' , 'SuperAdminController@tarikDataProcess');
    Route::get('/selesai/{jenis}/{tanggal}' , 'SuperAdminController@selesaiProcess');
    Route::get('/rankingabsen','AbsenController@rankingPage');

    
    //jemaat
    Route::get('/listjemaat' , 'JemaatController@listjemaat');
    Route::get('/showjemaat/{id}' , 'JemaatController@showjemaat' );
    Route::post('/update/jemaat' , 'JemaatController@updatejemaat');
    Route::get('/jemaatbaru' , 'JemaatController@jemaatbaru');
    Route::get('/delete/{id}' , 'JemaatController@deleteJemaat');
    Route::get('/ulangtahun' , 'JemaatController@ulangtahun');

    //jemaat baru
    Route::resource('tempuser' , 'TempUserController');
    Route::get('/publish' , 'TempUserController@publishJemaatBaruVIew');
    Route::post('/publishprocess' , 'TempUserController@publishJemaatBaru');
    //end of jemaat baru

    // komsel
    Route::resource('komsel' , 'KomselController');
    Route::resource('komseldetail' , 'KomselMemberController');
    // end of komsel

    // BIC
    Route::resource('bic' , 'BicController');
    Route::get('/createqrid','SuperAdminController@createQrId');
    // end of BIC
  
    // Youth
    Route::resource('youth' , 'YouthController');
    //end of Youth

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