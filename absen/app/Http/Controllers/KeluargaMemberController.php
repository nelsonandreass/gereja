<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Keluarga;
use App\KeluargaMember;
use App\Http\Services\JemaatService;


class KeluargaMemberController extends Controller
{

    public function __construct(JemaatService $jemaatServices){
        $this->jemaat_service = $jemaatServices;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {   
        $userIds = $request->input('tempUserId');
        $keluargaId = $request->input('keluargaid');
        if(is_null($userIds) || $userIds === " " || $userIds === ""){
            return redirect()->back();
        }
        $userIdsArray = explode(',',$userIds);
        for($i = 0 ; $i < sizeof($userIdsArray) ; $i++){
            $anggotaKeluarga = new KeluargaMember();
            $anggotaKeluarga->keluarga_id = $keluargaId;
            $anggotaKeluarga->user_id = $userIdsArray[$i];
            $anggotaKeluarga->save();
        }
        return redirect('/keluarga');

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $keluarga = Keluarga::with(['user'])->where('id',$id)->first();
        $users = $this->jemaat_service->getAllJemaat();
        $anggotaKeluarga = KeluargaMember::with(['user'])->where('keluarga_id',$id)->get();
        
        return view('superadmin.keluarga.tambahmember' , ['keluarga' => $keluarga , 'users' => $users , 'anggotaKeluarga' => $anggotaKeluarga , "keluargaid" => $id]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
