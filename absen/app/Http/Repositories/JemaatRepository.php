<?php

namespace App\Http\Repositories;

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
        $data = User::select('id' , 'name' , 'nomor_telepon' , 'alamat' , 'kecamatan' , 'kelurahan' , 'kartu' , 'foto' ,'tempat_lahir', 'status_pernikahan', 'tanggal_lahir', 'jenis_kelamin' , 'email' , 'foto','nama_panggilan' , 'isBic' , 'isYouth', 'isPria', 'isGa')->find($id);
        return $data;
    }

    public function sortJemaat($request){
        if(sizeof($request) == 0){
            $datas = User::select('id','name' , 'nomor_telepon' , 'alamat' , 'kartu' , 'foto' , 'nama_panggilan' , DB::raw('ABS(DATEDIFF(tanggal_lahir, curdate())) as umur'))
            ->get();
        }else{
            $datas = User::select('id','name' , 'nomor_telepon' , 'alamat' , 'kartu' , 'foto' , 'nama_panggilan' , DB::raw('ABS(DATEDIFF(tanggal_lahir, curdate())) as umur'))
            ->where($request)
            ->get();
        }
        return $datas;
    }

    public function searchJemaat($request){
        $datas = User::where('role' , 'user')->select('id','name' , 'nomor_telepon' , 'alamat' , 'kartu' , 'foto' , 'nama_panggilan', DB::raw('ABS(DATEDIFF(tanggal_lahir, curdate())) as umur'))->where('name' , 'LIKE' , $request.'%')->orWhere('nama_panggilan' , 'LIKE' , '$username%')->get();
        return $datas;
    }
    
    public function searchulangtahun($request){
        $datas = User::where('role' , 'user')->select('id','name' , 'nomor_telepon' , 'alamat' , DB::raw("DATE_FORMAT(tanggal_lahir,'%d-%m-%Y') as tanggal_lahir") , 'foto' , 'nama_panggilan')->whereMonth('tanggal_lahir',$request)->orderBy('tanggal_lahir','asc')->get();
        return $datas;
    }

    public function sortByKecamatanCache($request){
        $datas = cache()->remember('users-key' ,60*60*24,function(){
            User::where('role' , 'user')->select('id','name' , 'nomor_telepon' , 'alamat' , 'kartu' , 'foto' , 'nama_panggilan', DB::raw('ABS(DATEDIFF(tanggal_lahir, curdate())) as umur'))->where('kecamatan', $request)->get();
        });
        return $datas;
    }
    
    public function sortByKecamatan($request){
        $datas = User::select('id','name' , 'nomor_telepon' , 'alamat' , 'kartu' , 'foto' , 'nama_panggilan' , DB::raw('ABS(DATEDIFF(tanggal_lahir, curdate())) as umur'))->where('kecamatan', $request)->get();
        return $datas;
    }

    public function sortByUmurCache(){
        $datas = cache()->remember('users-key' ,60*60*24,function(){
            User::where('role' , 'user')->select('id','name' , 'nomor_telepon' , 'alamat' , 'kartu' , 'foto' , 'nama_panggilan')->get();
        });
        return $datas;
    }

    public function sortByUmur(){
        $datas = User::where('role' , 'user')->select('id','name' , 'nomor_telepon' , 'alamat' , 'kartu' , 'foto' , 'nama_panggilan','tanggal_lahir', DB::raw('ABS(DATEDIFF(tanggal_lahir, curdate())) as umur'))->get();
        return $datas;
    }

    public function updatejemaat($id,$array){
        $user = User::where('id', $id)->update($array);
        return $user;
    }

    public function deleteJemaat($id){
        $user = User::find($id);
        return $user;
    }

    public function ulangtahun($month){
        $datas = User::where('role' , 'user')->select('id','name' , 'nomor_telepon' , 'alamat' , DB::raw("DATE_FORMAT(tanggal_lahir,'%d-%m-%Y') as tanggal_lahir") , 'foto' , 'nama_panggilan')->whereMonth('tanggal_lahir',$month)->orderBy('tanggal_lahir','asc')->get();
        return $datas;
    }

    public function genderCounter(){
        $countMale = User::where("jenis_kelamin" , "=" , "Pria")->count();
        $countFemale = User::where("jenis_kelamin" , "=" , "Wanita")->count();
        return [$countMale , $countFemale];
    }

    public function isYouth(){
        $users = User::where('role' , 'user')->where('isYouth' , "=" , "Y")->select('id','name' , 'nomor_telepon' , 'alamat' , 'kartu' , 'foto' , 'nama_panggilan','tanggal_lahir', DB::raw('ABS(DATEDIFF(tanggal_lahir, curdate())) as umur'))->get();
        foreach($users as $user){
            $user->umur = floor($user->umur/365);
        }
        return $users;
    }

    public function isBic(){
        $users = User::where('role' , 'user')->where('isBic' , "=" , "Y")->select('id','name' , 'nomor_telepon' , 'alamat' , 'kartu' , 'foto' , 'nama_panggilan','tanggal_lahir', DB::raw('ABS(DATEDIFF(tanggal_lahir, curdate())) as umur'))->get();
        foreach($users as $user){
            $user->umur = floor($user->umur/365);
        }
        return $users;
    }

    public function isBlessKids(){
        $users = User::where('role' , 'user')->where('isGa' , "=" , "Y")->select('id','name' , 'nomor_telepon' , 'alamat' , 'kartu' , 'foto' , 'nama_panggilan','tanggal_lahir', DB::raw('ABS(DATEDIFF(tanggal_lahir, curdate())) as umur'))->get();
        foreach($users as $user){
            $user->umur = floor($user->umur/365);
        }
        return $users;
    }

    public function isPria(){
        $users = User::where('role' , 'user')->where('isPria' , "=" , "Y")->select('id','name' , 'nomor_telepon' , 'alamat' , 'kartu' , 'foto' , 'nama_panggilan','tanggal_lahir', DB::raw('ABS(DATEDIFF(tanggal_lahir, curdate())) as umur'))->get();
        foreach($users as $user){
            $user->umur = floor($user->umur/365);
        }
        return $users;
    }
}

