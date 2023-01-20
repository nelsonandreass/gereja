<?php

namespace App\Services;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\TempUser;
use App\User;

use App\Repositories\JemaatRepository;

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
        $users = $this->jemaat_repo->sortJemaat($request);
        return $users;
    }

    public function searchJemaat($request){
        if(!is_null($request)){
            $datas = $this->jemaat_repo->searchJemaat($request);
            foreach($datas as $data){
                $data->umur = floor($data->umur/365);
            }
            return $datas;
        }
        return $users;
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
    
}

