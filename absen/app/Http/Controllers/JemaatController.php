<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


use App\User;


class JemaatController extends Controller
{
    public function searchJemaat(Request $request){
        $username = $request->input('jemaat');
        if(!is_null($username)){
            $datas = User::select('id','name' , 'nomor_telepon' , 'alamat' , 'kartu' , 'foto' , 'nama_panggilan', DB::raw('ABS(DATEDIFF(tanggal_lahir, curdate())) as umur'))->where('name' , 'LIKE' , $username.'%')->orWhere('nama_panggilan' , 'LIKE' , $username.'%')->get();
            foreach($datas as $data){
                $data->umur = floor($data->umur/365);
            }
            return $datas;
        }
    }

    public function searchulangtahun(Request $request){
        $month = $request->input('month');
        $datas = User::where('role' , 'user')->select('id','name' , 'nomor_telepon' , 'alamat' , DB::raw("DATE_FORMAT(tanggal_lahir,'%m-%d-%Y') as tanggal_lahir") , 'foto' , 'nama_panggilan')->whereMonth('tanggal_lahir',$month)->orderBy('tanggal_lahir','asc')->get();
        return $datas;
    }

    public function sortByKecamatan(Request $request){
        $kecamatan = $request->input('kecamatan');
        if($kecamatan == "semua"){
            $datas = cache()->remember('users-key' ,60*60*24,function(){
                User::select('id','name' , 'nomor_telepon' , 'alamat' , 'kartu' , 'foto' , 'nama_panggilan', DB::raw('ABS(DATEDIFF(tanggal_lahir, curdate())) as umur'))->get();
            });
        }
        else{
            $datas = User::select('id','name' , 'nomor_telepon' , 'alamat' , 'kartu' , 'foto' , 'nama_panggilan' , DB::raw('ABS(DATEDIFF(tanggal_lahir, curdate())) as umur'))->where('kecamatan', $kecamatan)->get();
        }
        foreach($datas as $data){
            $data->umur = floor($data->umur/365);
        }
        return $datas;
    }

    public function sortByUmur(Request $request){
        $dariumur = $request->input('dariumur');
        $sampaiumur = $request->input('sampaiumur');
        $res = array();
        if(($dariumur == NULL || $dariumur == "") || $sampaiumur == NULL || $sampaiumur == ""){
            $res = cache()->remember('users-key' ,60*60*24,function(){
                User::select('id','name' , 'nomor_telepon' , 'alamat' , 'kartu' , 'foto' , 'nama_panggilan')->get();
            });
        }
        else{
            $users = User::select('id','name' , 'nomor_telepon' , 'alamat' , 'kartu' , 'foto' , 'nama_panggilan','tanggal_lahir', DB::raw('ABS(DATEDIFF(tanggal_lahir, curdate())) as umur'))->get();
            foreach($users as $user){
                $user->umur = floor($user->umur/365);
                if($user->umur >= $dariumur && $user->umur <= $sampaiumur){
                    array_push($res,$user);
                }
            }
        }
        return $res;
    }
   
}
