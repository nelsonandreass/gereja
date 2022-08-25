<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\User;
use App\Absen;
Use App\Ibadah;
Use App\Berita;
Use App\Counter;
Use App\wa_sent_flags;

use App\Imports\UsersImport;
use Illuminate\Foundation\Auth\User as AuthUser;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Date;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Storage;
use DateTime;
use Session;


class SuperAdminController extends Controller
{
    //home
    
    public function curl($url,$method,$request,$contentType){
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30000,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => $method,
            CURLOPT_POSTFIELDS => $request ,
            CURLOPT_HTTPHEADER => array(
                "content-type: application/".$contentType
            ),
        ));
        
        $response = curl_exec($curl);
        $err = curl_error($curl);
        
        curl_close($curl);
        
        if ($err) {
            echo "cURL Error #:" . $err;
        } else {
            return $response;
        }
    }
   
    public function getQr(Request $request){
        $id = $request->input('id');
        $requestBody = "id=".$id."&isLegacy=false";
        $curl = $this->curl('http://127.0.0.1:8000/sessions/add','POST',$requestBody,"x-www-form-urlencoded");
        return $curl;
    }

    public function isWaConnected(Request $request){
        $isWaConnected = $this->curl("http://127.0.0.1:8000/sessions/status/Login","GET","","json");
        return $isWaConnected;
    }

    public function sendMessage($id){
        $getUser = User::select("name","tanggal_lahir","jenis_kelamin")->where("nomor_telepon","LIKE",$id)->first();
        $now = date("Y-m-d");
        $umur = date_diff(date_create($now),date_create($getUser->tanggal_lahir));
        $umur = $umur->format("%y");
        $salute="";
        if($getUser->jenis_kelamin == "Pria" && $umur >= 25){
            $salute = "Bapak";
        }
        else if($getUser->jenis_kelamin == "Wanita" && $umur >= 25){
            $salute = "Ibu";
        }
        $requestBody = array(
            "receiver" => $id,
            "message" => array(
                "text" => "Selamat Ulang Tahun ".$salute."".$getUser->name."\n"."'Kiranya diberikan-Nya kepadamu apa yang kaukehendaki dan dijadikan-Nya berhasil apa yang kaurancangkan.'(Maz 20:5) "."\n"."Dari GPdI Sahabat Allah"
            ),
        );
        $sendMessage = json_decode($this->curl("http://127.0.0.1:8000/chats/send?id=Login","POST",json_encode($requestBody),"json"));
        //$sendMessage = json_decode($this->curl("","POST",json_encode($requestBody),"json"));
      
        if($sendMessage->success){ 
            $flaggingSentBody = array(
                'phone' => $id,
                'year' => date("Y"),
                'created_at' => date("Y-m-d H:i:s"),
                'updated_at' => date("Y-m-d H:i:s"),
            ); 
            $insertFlaggingSent = wa_sent_flags::insert($flaggingSentBody);
            return redirect()->back();
        }
        else{
            return redirect()->back();
        }
    }

    public function getWaFlag(Request $request){
        $phone = $request->input("phone");
        $year = date("Y");
     
        $isSent = wa_sent_flags::where('phone',$phone)->where('year',$year)->first();
       
        if(!is_null($isSent)){
            $response = array("success"=>true);
            return json_encode($response);
        }
        else{
            $response = array("success"=>false);
            return json_encode($response);
        }
    }

    public function index(){
        $absens = Absen::select('jenis','tanggal')->orderBy('tanggal','DESC')->distinct('tanggal','jenis')->take('5')->get();
        $tanggalDB = Absen::select('tanggal')->distinct('tanggal')->orderBy('tanggal','DESC')->take('6')->get()->toArray();
    
        
        $this->selesaiProcess('ibadah1');
        $this->selesaiProcess('ibadah2');

        $arrayTanggal = array();
            
        
        foreach($tanggalDB as $dataTanggal){
            array_push($arrayTanggal,$dataTanggal['tanggal']);
        }
        sort($arrayTanggal);
       
      
        $ibadah1 = Counter::select('jumlah' , 'tanggal')->where('jenis' , 'ibadah1')->whereIn('tanggal' , $arrayTanggal)->get()->toJson();
        $jumlahIbadah1 = array();
        foreach(json_decode($ibadah1) as $data){
            array_push($jumlahIbadah1,$data->jumlah);
        }
        $ibadah2 =  Counter::select('jumlah' , 'tanggal')->where('jenis' , 'ibadah2')->whereIn('tanggal' , $arrayTanggal)->get()->toJson();
        $jumlahIbadah2 = array();
        foreach(json_decode($ibadah2) as $data){
            array_push($jumlahIbadah2,$data->jumlah);
        }
        
        //$birthday = $this->getBirthdayThisWeek();
        $birthday = array("nelson"=>"08-19;+6287888088201");
     
        return view('superadmin.index' , ['absens' => $absens, 'tanggal' => json_encode($arrayTanggal), 'ibadah1' => json_encode($jumlahIbadah1) , 'ibadah2' => json_encode($jumlahIbadah2), 'birthdays' => $birthday]);
    }

    public function tarikDataPage(){
        $getDate = Absen::select('tanggal')->orderBy('tanggal','DESC')->distinct('tanggal')->get();

        return view('superadmin.tarikdata' , ['dates' => $getDate]);
    
    }

    public function tarikDataProcess(Request $request){
        $date = $request->input("tanggal"); 
       
        $getPeople = Absen::select('user_id')->where('tanggal' , $date)->distinct('user_id')->get();
        $getAllPeople = User::select('kartu')->get();

        
        $tempArrayGetPeople = $getPeople->toArray();
        $tempArrayGetAllPeople = $getAllPeople->toArray();
        $arrayGetPeople = array();
        $arrayGetAllPeople = array();

      
        foreach($tempArrayGetAllPeople as $key => $dataPeople){
           array_push($arrayGetAllPeople ,$dataPeople['kartu']);           
        }
        foreach($tempArrayGetPeople as $key => $dataAbsen){
            array_push($arrayGetPeople ,$dataAbsen['user_id']);           
        }

        $arraydiff = array_diff($arrayGetAllPeople,$arrayGetPeople);
        $notAbsen = User::select("name",'nomor_telepon','alamat')->whereIn('kartu',$arraydiff)->orWhere('kartu','=',null)->get();
        
        return response([
            'data' => $notAbsen
        ]);
    }

    public function getAllAbsen(){
        $absens = Absen::select('jenis','tanggal')->distinct('tanggal','jenis')->orderBy('tanggal',"desc")->get();
        return view('superadmin.absen' , ['absens' => $absens]);
    }

    public function getBirthdayThisWeek(){
        $users = User::select("name","nomor_telepon",DB::raw("DATE_FORMAT(tanggal_lahir,'%m-%d') as tanggal_lahir"))->whereRaw('WEEKOFYEAR(tanggal_lahir) = WEEKOFYEAR(curdate())')->get()->toArray();
        $tempUsers = ($users);
        $tempArray = array();
        foreach($tempUsers as $tempUser){
            $tempArray[$tempUser['name']] = $tempUser['tanggal_lahir'].";".$tempUser["nomor_telepon"];
        }
        asort($tempArray);
        
        return ($tempArray);
    }

    //end of home


    //absen
    public function ibadah(){
        return view('superadmin.ibadah', ['tanggal' => date('Y-m-d')]);
    }

    public function absenProcess(Request $request){
        $user_id = $request->input('user_id');
        $jenis = $request->input('jenis');
        $date = date('Y-m-d');

        $cardshort = substr($user_id,1,strlen($user_id));
    
        $checkUser = User::where('kartu','LIKE',"%$cardshort%")->orWhere('fingerprint','LIKE',"%$cardshort%")->first();
      
        $response="";
        if(!is_null($checkUser)){
            $checkAbsen = Absen::where('user_id', $checkUser['kartu'])->where('jenis' , $jenis)->where('tanggal' , $date)->first();
            if(is_null($checkAbsen)){
                $data = new Absen();
                $data->user_id = $checkUser['kartu'];
                $data->jenis = $jenis;
                $data->tanggal = $date;
                $data->save();
            }
            $user = Absen::with(['users'])->where('user_id',$checkUser['kartu'])->first();
            
            
            foreach($user->users as $userdata){
                $response = array(
                    "error_code" => '0000',
                    "error_message" => "Success",
                    "name" => $userdata->name,
                    "foto" => $userdata->foto,
                    "greet" => "Selamat Beribadah"
                );
            }
            
        }
        else{
            $response = array(
                "error_code" => '0001',
                "error_message" => "tidak terdaftar",
                "greet" => "Tidak Terdaftar"
            );
        }
        return json_encode($response);
    }

    public function absenDetail($ibadah,$tanggal){
        $datas = Absen::with('users')->select('user_id','jenis','tanggal')->where('jenis',$ibadah)->where('tanggal',$tanggal)->distinct('user_id')->get();
    
        return view('superadmin.absendetail' , ['datas' => $datas, 'ibadah' => $ibadah , 'tanggal' => $tanggal]);
    }

    public function selesaiProcess($jenis){
        try {
            //code...
            $getLastInserted = Absen::select("tanggal")->orderBy("created_at","desc")->first();
            if(!is_null($getLastInserted)){
                $getLastInserted->toArray();
            }
        } catch (\Throwable $th) {
            //throw $th;
            return false;
        }
        $count = Absen::where('jenis',$jenis)->where('tanggal',$getLastInserted['tanggal'])->distinct('user_id')->count();
        $checkCount = Counter::where('jenis',$jenis)->where('tanggal',$getLastInserted['tanggal'])->exists();
       
        if($checkCount == false){
            $data = new Counter;
            $data->jenis = $jenis;
            $data->tanggal = $getLastInserted['tanggal'];
            $data->jumlah = $count;
    
            $data->save();
        }
        else{
            $dataUpdate = array(
                'jumlah' => $count
            );
           Counter::where('jenis',$jenis)->where('tanggal',$getLastInserted['tanggal'])->update($dataUpdate);
        }
    }
    
    public function removeDuplicate(){
        //$absens = Absen::select("user_id")->distinct("user_id","tanggal","jenis")->get()->toArray();
        $duplicated =DB::table('absens')
        ->select('user_id', DB::raw('count(`user_id`) as occurences'))
        ->groupBy('user_id','tanggal','jenis')
        ->having('occurences', '>', 1)
        ->get();
        //dd($duplicated);
        foreach ($duplicated as $duplicate) {
            Absen::where('user_id', $duplicate->user_id)->delete();
        }
        return redirect()->back();
    }


    //end of absen

    //jemaat
    public function listjemaat(){
        $users = cache()->remember('users-key' ,60*60*24,function(){
            return User::where('role' , 'user')->select('id','name' , 'nomor_telepon' , 'alamat' , 'kartu' , 'foto' , 'nama_panggilan')->orderBy('name','asc')->get();
        }); 
        return view('superadmin.listjemaat' , ['users' => $users, 'json' => json_encode($users)]);
    }

    public function showjemaat($id){
        $data = User::select('id' , 'name' , 'nomor_telepon' , 'alamat' , 'kartu' , 'foto' ,'tempat_lahir', 'status_pernikahan', 'tanggal_lahir', 'jenis_kelamin' , 'email' , 'foto','nama_panggilan')->find($id);

        return view('superadmin.showjemaat' , ['datas' => $data]);
    }

    public function updatejemaat(Request $request){
        cache()->forget('users-key');
        $id = $request->input('id');
        $email = $request->input('email');
        $telepon = $request->input('telepon');
        $alamat = $request->input('alamat');
        $nokartu = $request->input('nokartu');
        $tanggallahir = $request->input('tgllahir');
        $status_pernikahan = $request->input('status_pernikahan');
        $tempatlahir = $request->input('tempatlahir');
        $name = $request->input('name');
        $nama_panggilan = $request->input('nama_panggilan');
        $foto = $request->file('foto');
        
     
        if(!is_null($foto)){
            $namafoto = $name.'.' . $foto->getClientOriginalExtension();
            $save = Storage::putFileAs('public',$foto, $namafoto);
            $array = array(
                'email' => $email,
                'nomor_telepon' => $telepon,
                'alamat' => $alamat,
                'kartu' => $nokartu,
                'foto' => $namafoto,
                'tanggal_lahir' => $tanggallahir,
                'tempat_lahir' => $tempatlahir,
                'status_pernikahan' => $status_pernikahan,
                'nama_panggilan' => $nama_panggilan
            );
        }
        else{
            $array = array(
                'email' => $email,
                'nomor_telepon' => $telepon,
                'alamat' => $alamat,
                'kartu' => $nokartu,
                'tanggal_lahir' => $tanggallahir,
                'tempat_lahir' => $tempatlahir,
                'status_pernikahan' => $status_pernikahan,
                'nama_panggilan' => $nama_panggilan
            );
        }
   
        $user = User::where('id', $id)->update($array);
        return redirect('/listjemaat');
    }

    public function searchJemaat(Request $request){
        $username = $request->input('jemaat');
        
        if(!is_null($username)){
            $datas = User::select('id','name' , 'nomor_telepon' , 'alamat' , 'kartu' , 'foto' , 'nama_panggilan')->where('name' , 'LIKE' , $username.'%')->orWhere('nama_panggilan' , 'LIKE' , $username.'%')->get();
            return $datas;
        }
      
    }

    public function jemaatbaru(){
        return view('superadmin.jemaatbaru');
    }
    public function savejemaatbaru(Request $request){
        cache()->forget('users-key');
        $email = $request->input('email');
        $telepon = $request->input('telepon');
        $alamat = $request->input('alamat');
        $nokartu = $request->input('nokartu');
        $tanggallahir = $request->input('tgllahir');
        $status_pernikahan = $request->input('status_pernikahan');
        $tempatlahir = $request->input('tempatlahir');
        $name = $request->input('name');
        $nama_panggilan = $request->input('nama_panggilan');
        $jenisKelamin = $request->input('jenis_kelamin');
        $foto = $request->file('foto');
        if(!is_null($foto)){
            $date = date("d-m-Y");
            $namaFoto = $name.$date.'.' . $foto->getClientOriginalExtension();
            $saveFoto = Storage::putFileAs('public',$foto, $namaFoto);
        }
        else{
            $namaFoto = "";
        }
        $user = new User();
        $user->name = $name;
        $user->nama_panggilan = $nama_panggilan;
        $user->email = $email;
        $user->foto = $namaFoto;
        $user->jenis_kelamin = $jenisKelamin;
        $user->status_pernikahan = $status_pernikahan;
        $user->tanggal_lahir = $tanggallahir;
        $user->tempat_lahir = $tempatlahir;
        $user->nomor_telepon = $telepon;
        $user->alamat = $alamat;
        $user->kartu = $nokartu;
        
        $user->save();
        return redirect('/listjemaat');
        
    }

    public function deleteJemaat($id){
        cache()->forget('users-key');
       
        User::where('id',$id)->delete();
        return redirect()->back();
    }

    public function ulangtahun(){
        $month = date('m');
        $datas = User::where('role' , 'user')->select('id','name' , 'nomor_telepon' , 'alamat' , DB::raw("DATE_FORMAT(tanggal_lahir,'%m-%d-%Y') as tanggal_lahir") , 'foto' , 'nama_panggilan')->whereMonth('tanggal_lahir',$month)->orderBy('tanggal_lahir','asc')->get();
        return view('superadmin.ulangtahun' , ['users' => $datas]);
    }
    public function searchulangtahun(Request $request){
        $month = $request->input('month');
        $datas = User::where('role' , 'user')->select('id','name' , 'nomor_telepon' , 'alamat' , DB::raw("DATE_FORMAT(tanggal_lahir,'%m-%d-%Y') as tanggal_lahir") , 'foto' , 'nama_panggilan')->whereMonth('tanggal_lahir',$month)->orderBy('tanggal_lahir','asc')->get();
        return $datas;
    }
    //end of jemaat

    //berita
    public function berita(){
        $datas = Berita::get();
        return view('superadmin.berita' , ['datas' => $datas]);
    }

    public function createBerita(){
        return view('superadmin.createberita');
    }

    public function createBeritaProcess(Request $request){
        $judul = $request->input('judul');
        $berita = $request->input('berita');
        $wadah = $request->input('wadah');

        $data = new Berita();
        $data->judul = $judul;
        $data->berita = $berita;
        $data->wadah = $wadah;
        $data->save();

        return redirect('/berita');
    }

    public function updateBerita($id){
        $data = Berita::where('id', $id)->first();
        return view('superadmin.updateberita', ['berita' => $data]);
    }

    public function updateBeritaProcess(Request $request){
        $id = $request->input('id');
        $judul = $request->input('judul');
        $berita = $request->input('berita');
        $wadah = $request->input('wadah');
        $data = Berita::where('id',$id)->update([
            'judul' => $judul,
            'berita' => $berita,
            'wadah' => $wadah
        ]);
        return redirect('/berita');
    }
    //end of berita


    public function test(){
        $absen = Absen::with(['users'])->get();
        return view('superadmin.kartu');
    }

    public function testprocess(Request $request){
        $kartu = $request->input('kartu');

        $absen = Absen::with('users')->where('user_id',$kartu)->first();
        foreach($absen->users as $key =>  $data){
            $response = array(
                "name" => $data->name,
                "foto" =>$data->foto,
                "greet" => "Selamat Beribadah"
            );
        }
        
        echo json_encode($response);

    }
    
    public function getAbsen(){
        $datas = DB::table('absens')->select('tanggal',DB::raw('count(id) as total'))->orderBy('tanggal','asc')->groupBy('tanggal')->get();
        dd($datas);
    }

    public function upload(){
        return view('superadmin.upload');
    }
    public function uploadprocess(Request $request){
        $excel = $request->file('excel');
        $rows = Excel::toArray(new UsersImport,$excel);

        
        for($i = 0 ; $i < sizeof($rows[0]) ; $i++){
           
            if(!is_null($rows[0][$i][6])){
                $ttl = explode("," , $rows[0][$i][6]);
            }
       
            
            $user = new User();
            $user->name = $rows[0][$i][0];
            $user->kartu = $rows[0][$i][2];
            $user->email = $rows[0][$i][0].$ttl[1].'@gmail.com';
            $user->password = $rows[0][$i][0];
            $user->jenis_kelamin = $rows[0][$i][4];
            $user->status_pernikahan = $rows[0][$i][5];
            $user->alamat = $rows[0][$i][7];
            if(!is_null($rows[0][$i][6])){
                $tanggal = str_replace(' ','',$ttl[1]);
                $tanggal = str_replace('/','-',$tanggal);
    
                $user->tanggal_lahir = date('Y-m-d', strtotime($tanggal));        
                $user->tempat_lahir = $ttl[0];
            }
            $user->nomor_telepon = $rows[0][$i][8];
            $user->save();
        }
       
    }

    public function uploadkartu(){
        return view('superadmin.uploadkartu');
    }

    public function uploadkartuprocess(Request $request){
        $excel = $request->file('excel');
        $rows = Excel::toArray(new UsersImport,$excel);

       
        
        for($i = 0 ; $i < sizeof($rows[0]) ; $i++){
            if(!is_null($rows[0][$i][3])){
                $array = array(
                    'kartu' => $rows[0][$i][3]
                );
                $user = User::where('name', $rows[0][$i][0])->update($array);
            }

           
        }
    }


   

    public function uploadfoto(){
        return view('superadmin.uploadfoto');
    }
    public function uploadfotoprocess(Request $request){
        $foto = $request->file('foto');
        $name = $foto->getClientOriginalName();
        $save = Storage::putFileAs('public',$foto, $name);

        $data = User::where('email' , 'nelson@gmail.com')->update([
            'foto' => $name
        ]);

    }
}

