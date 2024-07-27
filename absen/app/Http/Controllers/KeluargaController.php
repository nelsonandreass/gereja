<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Keluarga;
use App\KeluargaMember;
use App\User;
use App\Http\Services\JemaatService;

class KeluargaController extends Controller
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
        $keluargas = Keluarga::with('user')->get();
        return view('superadmin.keluarga.index', ['keluargas' => $keluargas]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $users = $this->jemaat_service->getAllJemaat();
        return view('superadmin.keluarga.tambahkeluarga' , ['users' => $users]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $tempKeluarga = $request->input('tempKeluarga');

        $keluarga = new Keluarga();
        $keluarga->user_id = $tempKeluarga;
        $keluarga->save();

        $keluargaMember = new KeluargaMember();
        $keluargaMember->keluarga_id = $keluarga->id;
        $keluargaMember->user_id = $tempKeluarga;
        $keluargaMember->save();
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
        //
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
