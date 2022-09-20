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
            $datas = User::select('id','name' , 'nomor_telepon' , 'alamat' , 'kartu' , 'foto' , 'nama_panggilan')->where('name' , 'LIKE' , $username.'%')->orWhere('nama_panggilan' , 'LIKE' , $username.'%')->get();
            return $datas;
        }
    }

    public function searchulangtahun(Request $request){
        $month = $request->input('month');
        $datas = User::where('role' , 'user')->select('id','name' , 'nomor_telepon' , 'alamat' , DB::raw("DATE_FORMAT(tanggal_lahir,'%m-%d-%Y') as tanggal_lahir") , 'foto' , 'nama_panggilan')->whereMonth('tanggal_lahir',$month)->orderBy('tanggal_lahir','asc')->get();
        return $datas;
    }

   
}
