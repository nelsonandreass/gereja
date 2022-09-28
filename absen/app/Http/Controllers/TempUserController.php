<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\TempUser;
use App\User;


class TempUserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = TempUser::select('id' , 'name' , 'nama_panggilan' , 'nomor_telepon' , 'alamat' , 'foto' , 'created_at')->get();
        return view('superadmin.tempuser.tempuser' , ['users' => $users]);
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
        cache()->forget('users-key');
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
        $jenisKelamin = $request->input('jenis_kelamin');
        $foto = $request->file('foto');
        if(!is_null($foto)){
            $date = date("d-m-Y");
            $namaFoto = $name.$date.'.' . $foto->getClientOriginalExtension();
            $saveFoto = Storage::putFileAs('public',$foto, $namaFoto);
        }
        else{
            $namaFoto = "";
        }

        $user = new TempUser();
        $user->name = $name;
        $user->nama_panggilan = $nama_panggilan;
        $user->email = $email;
        $user->foto = $namaFoto;
        $user->jenis_kelamin = $jenisKelamin;
        $user->status_pernikahan = $status_pernikahan;
        $user->tanggal_lahir = $tanggallahir;
        $user->tempat_lahir = $tempatlahir;
        $user->nomor_telepon = $telepon;
        $user->alamat = $alamat;
        $user->kecamatan = $kecamatan;
        $user->kelurahan = $kelurahan;
        $user->kartu = $nokartu;
        $user->save();
        
        return redirect('/tempuser');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $temp_user = TempUser::find($id);
        $user = new User();
        $user->name= $temp_user->name;
        $user->nama_panggilan= $temp_user->nama_panggilan;
        $user->email= $temp_user->email;
        $user->foto= $temp_user->foto;
        $user->nama_ayah= $temp_user->nama_ayah;
        $user->nama_ibu= $temp_user->nama_ibu;
        $user->jenis_kelamin=$temp_user->jenis_kelamin;
        $user->status_pernikahan=$temp_user->status_pernikahan;
        $user->tanggal_lahir=$temp_user->tanggal_lahir;
        $user->tempat_lahir=$temp_user->tempat_lahir;
        $user->nomor_telepon=$temp_user->nomor_telepon;
        $user->no_keluarga=$temp_user->no_keluarga;
        $user->alamat=$temp_user->alamat;
        $user->kelurahan=$temp_user->kelurahan;
        $user->kecamatan=$temp_user->kecamatan;
        $user->kartu=$temp_user->kartu;
        $user->save();

        $temp_user->delete();
        cache()->forget('users-key');
        return redirect('/listjemaat');
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
        cache()->forget('users-key');
        $user = TempUser::find($id);
        $image_path = '/public/'.$user->foto;
        if(Storage::exists($image_path)){
            Storage::delete($image_path);
        } 
        $user->delete();
        return redirect()->back();
    }

    public function publishJemaatBaruVIew(){
        $users = TempUser::select('id' , 'name' , 'foto' , 'created_at' )->get();
        return view('superadmin.tempuser.publishtempuser' , ['users' => $users]);
    }
    public function publishJemaatBaru(Request $request){
        $ids = $request->input('id');
        $arrayId = explode(',',$ids);
        $users = TempUser::select('id' , 'name' , 'foto' )->whereIn('id',$arrayId)->get();

        return view('superadmin.tempuser.publishtempuserlayout' , ['users' => $users]);
    }
   
}
