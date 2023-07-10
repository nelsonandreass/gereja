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

use App\Http\Services\AbsenService;
use App\Http\Services\JemaatService;


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
        
        $birthday = $this->getBirthdayThisWeek();
        //$birthday = array("nelson"=>"08-19;+6287888088201");
     
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
    
    public function createQrId(){
        $users = User::select('id')->where('role' , 'user')->get();
        foreach($users as $user){
            $kartu = date('y') . substr(microtime(),2,3) . date('mdis')  . substr(microtime(),5,3);
            $array = array(
                'barcode' => $kartu
            );
            User::where('id' , $user->id)->update($array);
        }
        return redirect()->back();
    }

    //end of absen

    
}

