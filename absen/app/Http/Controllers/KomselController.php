<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\User;
use App\Komsel;
use App\KomselMember;

use App\Services\JemaatService;


class KomselController extends Controller
{

    protected $jemaat_service;
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
        $komsels = Komsel::with(['user'])->get();
        $users = $this->jemaat_service->getAllJemaat();
        $kecamatan = $this->jemaat_service->getKecamatan();
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


    public function sortKomsel(Request $request){
        $id = $request->input('id');
        $komselmember = KomselMember::with(['users'])->where('komsel_id', $id)->get();
        $komsel = Komsel::with(['user'])->where("id" , $id)->first();
        
        $datas = array();
        $user_data = array();
        
        array_push($user_data,$komsel->user);
        
        foreach($komselmember as $member){
            foreach($member->users as $key => $user){
                array_push($user_data,$user);
            }
            
        }

        foreach($user_data as $data){
            $days = (date_diff(date_create($data->tanggal_lahir),date_create(date("Y-m-d"))));
            $days = $days->format("%a");
            $data["umur"] = floor($days/365);
        }
        return $user_data;
    }
}
