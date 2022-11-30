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

use App\Services\AbsenService;
use App\Services\JemaatService;


class SuperAdminController extends Controller
{
    protected $absen_service;
    protected $jemaat_service;
   
    public function __construct(AbsenService $absenServices,JemaatService $jemaatServices){
        $this->absen_service = $absenServices;
        $this->jemaat_service = $jemaatServices;

    }
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
        return view('superadmin.absen.tarikdata' , ['dates' => $getDate]);
    }

    public function getAllAbsen(){
        $absens = Absen::select('jenis','tanggal')->distinct('tanggal','jenis')->orderBy('tanggal',"desc")->get();
        return view('superadmin.absen.absen' , ['absens' => $absens]);
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
        return view('superadmin.absen.ibadah', ['tanggal' => date('Y-m-d')]);
    }

    public function absenDetail($ibadah,$tanggal){
        $datas = Absen::with('users')->select('user_id','jenis','tanggal')->where('jenis',$ibadah)->where('tanggal',$tanggal)->distinct('user_id')->get();
    
        return view('superadmin.absen.absendetail' , ['datas' => $datas, 'ibadah' => $ibadah , 'tanggal' => $tanggal]);
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

    public function clearcache(){
        cache()->forget('users-key');
    }

    public function listjemaat(){
        $users = $this->jemaat_service->getAllJemaat();
        $kecamatan = $this->jemaat_service->getKecamatan();
        return view('superadmin.jemaat.listjemaat' , ['users' => $users, 'json' => json_encode($users) , 'kecamatan' => $kecamatan]);
    }

    public function showjemaat($id){
        $data = $this->jemaat_service->showJemaat($id);
        return view('superadmin.jemaat.showjemaat' , ['datas' => $data]);
    }

    public function updatejemaat(Request $request){
        $this->clearcache();
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
        if(!is_null($foto)){
            $namafoto = $name.'.' . $foto->getClientOriginalExtension();
            $save = Storage::putFileAs('public',$foto, $namafoto);
            $array['foto'] = $namafoto;
            // $array = array(
            //     'email' => $email,
            //     'nomor_telepon' => $telepon,
            //     'alamat' => $alamat,
            //     'kecamatan' => $kecamatan,
            //     'kelurahan' => $kelurahan,
            //     'kartu' => $nokartu,
            //     'foto' => $namafoto,
            //     'tanggal_lahir' => $tanggallahir,
            //     'tempat_lahir' => $tempatlahir,
            //     'status_pernikahan' => $status_pernikahan,
            //     'nama_panggilan' => $nama_panggilan
            // );
        }
        $user = User::where('id', $id)->update($array);
        return redirect('/listjemaat');
    }

    public function jemaatbaru(){
        return view('superadmin.jemaat.jemaatbaru');
    }

    public function deleteJemaat($id){
        $this->clearcache();
        $user = User::find($id);
        $image_path = '/public/'.$user->foto;
        if(Storage::exists($image_path)){
            Storage::delete($image_path);
           
        } 
        else{
            die("Failed");
        }
        $user->delete();
        return redirect()->back();
    }

    public function ulangtahun(){
        $month = date('m');
        $datas = User::where('role' , 'user')->select('id','name' , 'nomor_telepon' , 'alamat' , DB::raw("DATE_FORMAT(tanggal_lahir,'%m-%d-%Y') as tanggal_lahir") , 'foto' , 'nama_panggilan')->whereMonth('tanggal_lahir',$month)->orderBy('tanggal_lahir','asc')->get();
        return view('superadmin.jemaat.ulangtahun' , ['users' => $datas]);
    }
   
    //end of jemaat

    
}

