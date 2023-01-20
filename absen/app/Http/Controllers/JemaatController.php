<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Services\JemaatService;


use App\User;


class JemaatController extends Controller
{ 

    protected $jemaat_service;
    public function __construct(JemaatService $jemaatServices){
        $this->jemaat_service = $jemaatServices;
    }

    public function searchJemaat(Request $request){
        $username = $request->input('jemaat');
        $datas = $this->jemaat_service->searchJemaat($username);
        return $datas;
    }

    public function searchulangtahun(Request $request){
        $month = $request->input('month');
        $datas = $this->jemaat_service->searchulangtahun($month);
        return $datas;
    }

    public function sortByKecamatan(Request $request){
        $kecamatan = $request->input('kecamatan');
        $datas = $this->jemaat_service->sortByKecamatan($kecamatan);
        return $datas;
    }

    public function sortByUmur(Request $request){
        $dariumur = $request->input('dariumur');
        $sampaiumur = $request->input('sampaiumur');
        $res = $this->jemaat_service->sortByUmur( $dariumur,$sampaiumur);
        return $res;
    }

    public function sortJemaat(Request $request){
        $users = $this->jemaat_service->sortJemaat($request);
    }
   
}
