<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\User;
use App\Absen;


class AbsenController extends Controller
{
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

    public function absenProcess(Request $request){
        $user_id = $request->input('user_id');
        $jenis = $request->input('jenis');
        $date = date('Y-m-d');

        $cardshort = substr($user_id,1,strlen($user_id));
    
        $checkUser = User::where('kartu','LIKE',"%$cardshort%")->orWhere('fingerprint','LIKE',"%$cardshort%")->orWhere('barcode','LIKE',"%$cardshort%")->first();
      
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
}
