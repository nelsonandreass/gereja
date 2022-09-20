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
Use App\TempUser;

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

    public function absenDetail($ibadah,$tanggal){
        $datas = Absen::with('users')->select('user_id','jenis','tanggal')->where('jenis',$ibadah)->where('tanggal',$tanggal)->distinct('user_id')->get();
    
        return view('superadmin.absendetail' , ['datas' => $datas, 'ibadah' => $ibadah , 'tanggal' => $tanggal]);
    }

    public function selesaiProcess($jenis){
        try {
            $getLastInserted = Absen::select("tanggal")->orderBy("created_at","desc")->first();
            if(!is_null($getLastInserted)){
                $getLastInserted->toArray();
            }
        } catch (\Throwable $th) {
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
    

    //end of absen

    //jemaat
    public function listjemaat(){
        $users = cache()->remember('users-key' ,60*60*24,function(){
            return User::where('role' , 'user')->select('id','name' , 'nomor_telepon' , 'alamat' , 'kartu' , 'foto' , 'nama_panggilan')->orderBy('name','asc')->get();
        }); 
        return view('superadmin.listjemaat' , ['users' => $users, 'json' => json_encode($users)]);
    }

    public function showjemaat($id){
        $data = User::select('id' , 'name' , 'nomor_telepon' , 'alamat' , 'kecamatan' , 'kelurahan' , 'kartu' , 'foto' ,'tempat_lahir', 'status_pernikahan', 'tanggal_lahir', 'jenis_kelamin' , 'email' , 'foto','nama_panggilan')->find($id);
        return view('superadmin.showjemaat' , ['datas' => $data]);
    }

    public function updatejemaat(Request $request){
        cache()->forget('users-key');
        $id = $request->input('id');
        $email = $request->input('email');
        $telepon = $request->input('telepon');
        $alamat = $request->input('alamat');
        $kecamatan = $request->input('kecamatan');
        $kelurahan = $request->input('kelurahan');
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
                'kecamatan' => $kecamatan,
                'kelurahan' => $kelurahan,
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
                'kecamatan' => $kecamatan,
                'kelurahan' => $kelurahan,
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

    public function jemaatbaru(){
        return view('superadmin.jemaatbaru');
    }

    public function savejemaatbaru(Request $request){
        cache()->forget('users-key');
        $email = $request->input('email');
        $telepon = $request->input('telepon');
        $alamat = $request->input('alamat');
        $kecamatan = $request->input('kecamatan');
        $kelurahan = $request->input('kelurahan');
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
        $user->kecamatan = $kecamatan;
        $user->kelurahan = $kelurahan;
        $user->kartu = $nokartu;
        
        $user->save();
        return redirect('/listjemaat');
        
    }

    public function deleteJemaat($id){
        cache()->forget('users-key');
        $user = User::find($id);
        $image_path = '/public/'.$user->foto;
        if(Storage::exists($image_path)){
            Storage::delete($image_path);
            $user->delete();
            return redirect()->back();
        } 
        else{
            die("Failed");
        }
    }

    public function ulangtahun(){
        $month = date('m');
        $datas = User::where('role' , 'user')->select('id','name' , 'nomor_telepon' , 'alamat' , DB::raw("DATE_FORMAT(tanggal_lahir,'%m-%d-%Y') as tanggal_lahir") , 'foto' , 'nama_panggilan')->whereMonth('tanggal_lahir',$month)->orderBy('tanggal_lahir','asc')->get();
        return view('superadmin.ulangtahun' , ['users' => $datas]);
    }
   
    //end of jemaat

    
}

