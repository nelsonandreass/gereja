<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\User;
use App\Komsel;

class KomselController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $komsels = Komsel::with(['user'])->get();
        $users = cache()->remember('users-key' ,60*60*24,function(){
            return User::where('role' , 'user')->select('id','name' , 'nomor_telepon' , 'alamat' , 'kartu' , 'foto' , 'nama_panggilan')->orderBy('name','asc')->get();
        }); 
        $kecamatan = User::where('kecamatan','!=',"NULL")->select('kecamatan')->orderBy('kecamatan','asc')->distinct()->get();
        return view('superadmin.komsel.komsel' , ['komsels' => $komsels , 'users' => $users, 'kecamatan' => $kecamatan]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $users = User::where('name' , '!=' , 'admin')->where('name' , '!=' , 'superadmin')->select('id','name')->get();
        return view('superadmin.komsel.komselbaru' , ['users' => $users]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $nama = $request->input("name");
        $alamat = $request->input("alamat");
        $ketua = $request->input("ketua");

        $komsel = new Komsel();
        $komsel->nama = $nama;
        $komsel->alamat = $alamat;
        $komsel->user_id = $ketua;
        $komsel->save();
        return redirect('/komsel');
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
