<?php

namespace App\Http\Services;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\TempUser;
use App\User;

use App\Http\Repositories\JemaatRepository;

use DateTime;
use Session;

class JemaatService
{

    protected $jemaat_repo;

    public function __construct(JemaatRepository $jemaatRepository){
        $this->jemaat_repo = $jemaatRepository;
    }

    public function JemaatBaru(){
        $users = $this->jemaat_repo->JemaatBaru();    
        return $users;
    }
    
    public function getAllJemaat(){
        $users = $this->jemaat_repo->getAllJemaat();    
        return $users;
    }

    public function getKecamatan(){
        $kecamatan = $this->jemaat_repo->getKecamatan();
        return $kecamatan; 
    }
    
    public function showJemaat($id){
        $user = $this->jemaat_repo->showJemaat($id); 
        return $user;
    }

    public function sortJemaat($request){
        $res = array();
        $users = $this->jemaat_repo->sortJemaat($request);
        if(!isset($request['dariUmur']) || null == $request['dariUmur']){
            $request['dariUmur'] = 0;
        }
        if( !isset($request['sampaiUmur']) || null ==$request['sampaiUmur']){
            $request['sampaiUmur'] = 9999;
        }
        foreach($users as $user){
            $user->umur = floor($user->umur/365);
            if($user->umur >= $request['dariUmur'] && $user->umur <= $request['sampaiUmur']){
                array_push($res,$user);
            }
        }
        return $res;
    }

    public function searchJemaat($request){
        if(!is_null($request)){
            $datas = $this->jemaat_repo->searchJemaat($request);
            foreach($datas as $data){
                $data->umur = floor($data->umur/365);
            }
            return $datas;
        }
        else{
            $datas = $this->jemaat_repo->getAllJemaat($request);
            return $datas;
        }
    }

    public function searchulangtahun($request){
        $datas = $this->jemaat_repo->searchulangtahun($request);
        return $datas;
    }

    public function sortByKecamatan($request){
        if($request == "semua"){
            $datas = $this->jemaat_repo->sortByKecamatanCache($request);
        }
        else{
            $datas = $this->jemaat_repo->sortByKecamatan($request);
        }
        foreach($datas as $data){
            $data->umur = floor($data->umur/365);
        }
        return $datas;
    }

    public function sortByUmur($dariumur,$sampaiumur){
        $res = array();
        if(($dariumur == NULL || $dariumur == "") || $sampaiumur == NULL || $sampaiumur == ""){
            $res = $this->jemaat_repo->sortByUmurCache();
        }
        else{
            $users = $this->jemaat_repo->sortByUmur();
            foreach($users as $user){
                $user->umur = floor($user->umur/365);
                if($user->umur >= $dariumur && $user->umur <= $sampaiumur){
                    array_push($res,$user);
                }
            }
        }

        foreach($res as $data){
            $days = (date_diff(date_create($data->tanggal_lahir),date_create(date("Y-m-d"))));
            $days = $days->format("%a");
            $data["umur"] = floor($days/365);
        }
        return $res;
    }

    public function updatejemaat($request){
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
        $bic = $request->input('bic') == null ? "N" : "Y";
        $youth = $request->input('youth') == null ? "N" : "Y";
        $pria = $request->input('pria') == null ? "N" : "Y";
        $blesskids = $request->input('blesskids') == null ? "N" : "Y";
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
            'nama_panggilan' => $nama_panggilan,
            'isBic' => $bic,
            'isYouth' => $youth,
            'isPria' => $pria,
            'isGA' => $blesskids
        );
        if(!is_null($foto)){
            $namafoto = $name.'.' . $foto->getClientOriginalExtension();
            $save = Storage::putFileAs('public',$foto, $namafoto);
            $array['foto'] = $namafoto;
        }
        try {
            $datas = $this->jemaat_repo->updatejemaat($id,$array);
        } catch (\Throwable $th) {
            return $th;
        }
        return true;
    }
    
    public function deleteJemaat($id){
        $user = $this->jemaat_repo->deleteJemaat($id);
        $image_path = '/public/'.$user->foto;
        if(Storage::exists($image_path)){
            Storage::delete($image_path);
        } 
        $user->delete();
    }

    public function ulangtahun(){
        $month = date('m');
        $datas = $this->jemaat_repo->ulangtahun($month);
      
        return $datas;
    }

    public function genderCounter(){
        return $this->jemaat_repo->genderCounter();
    }

    public function isYouth(){
        return $this->jemaat_repo->isYouth();
    }

    public function isBic(){
        return $this->jemaat_repo->isBic();
    }

    public function isBlessKids(){
        return $this->jemaat_repo->isBic();
    }

    public function isPria(){
        return $this->jemaat_repo->isPria();
    }
}

