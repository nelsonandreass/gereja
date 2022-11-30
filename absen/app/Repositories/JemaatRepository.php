<?php

namespace App\Repositories;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use App\TempUser;
use App\User;

class JemaatRepository
{
    public function JemaatBaru(){
        $users = TempUser::select('id' , 'name' , 'nama_panggilan' , 'nomor_telepon' , 'alamat' , 'foto' , 'created_at')->get();
        return $users;
    }

    public function getAllJemaat(){
        // $users = cache()->remember('users-key' ,60*60*24,function(){
        //     return User::where('role' , 'user')->select('id','name' , 'nomor_telepon' , 'alamat' , 'kartu' , 'foto' , 'nama_panggilan','tanggal_lahir', DB::raw('ABS(DATEDIFF(tanggal_lahir, curdate())) as umur'))->orderBy('name','asc')->get();
        // }); 
        $res = array();
        $users =  User::where('role' , 'user')->select('id','name' , 'nomor_telepon' , 'alamat' , 'kartu' , 'foto' , 'nama_panggilan','tanggal_lahir', DB::raw('ABS(DATEDIFF(tanggal_lahir, curdate())) as umur'))->orderBy('name','asc')->get();
        foreach($users as $user){
            $user->umur = floor($user->umur/365);
        }
        return $users;
    }

    public function getKecamatan(){
        $kecamatan = User::where('kecamatan','!=',"NULL")->select('kecamatan')->orderBy('kecamatan','asc')->distinct()->get();
        return $kecamatan;
    }

    public function showJemaat($id){
        $data = User::select('id' , 'name' , 'nomor_telepon' , 'alamat' , 'kecamatan' , 'kelurahan' , 'kartu' , 'foto' ,'tempat_lahir', 'status_pernikahan', 'tanggal_lahir', 'jenis_kelamin' , 'email' , 'foto','nama_panggilan')->find($id);
        return $data;
    }
    
}

