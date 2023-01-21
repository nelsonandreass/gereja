<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Services\JemaatService;


use App\User;


class JemaatController extends Controller
{ 

    protected $jemaat_service;
    public function __construct(JemaatService $jemaatServices){
        $this->jemaat_service = $jemaatServices;
    }

    public function clearcache(){
        cache()->forget('users-key');
    }

    public function listjemaat(){
        $users = $this->jemaat_service->getAllJemaat();
        $kecamatan = $this->jemaat_service->getKecamatan();
        return view('superadmin.jemaat.listjemaat' , ['users' => $users, 'json' => json_encode($users) , 'kecamatan' => $kecamatan]);
    }

    public function showjemaat($id){
        $data = $this->jemaat_service->showJemaat($id);
        return view('superadmin.jemaat.showjemaat' , ['datas' => $data]);
    }

    public function updatejemaat(Request $request){
        $this->clearcache();
        $this->jemaat_service->updatejemaat($request);
       
        return redirect('/listjemaat');
    }

    public function deleteJemaat($id){
        $this->clearcache();
        $this->jemaat_service->deleteJemaat($id);
        return redirect()->back();
    }

    public function ulangtahun(){
        $month = date('m');
        $datas = $this->jemaat_service->ulangtahun();
       
        return view('superadmin.jemaat.ulangtahun' , ['users' => $datas]);
    }

    public function jemaatbaru(){
        return view('superadmin.jemaat.jemaatbaru');
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
