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
}

