<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Komsel;
use App\KomselMember;
use App\User;

class KomselMemberController extends Controller
{
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
    public function create(Request $request)
    {
        $params = $request->query();
        foreach($params as $key => $value){
            $komsel_id = $key;
        }
        $users = User::where('name' , '!=' , 'admin')->where('name' , '!=' , 'superadmin')->select('id','name')->get();
        return view('superadmin.komsel.komselmember' , ['users' => $users , 'komsel_id' => $komsel_id]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $ids = $request->input('ids');
        $komsel_id = $request->input('komsel_id');
        $exploded_id = explode(',',$ids);

        foreach($exploded_id as $user){
            $komsel_member = new KomselMember();
            $komsel_member->komsel_id = $komsel_id;
            $komsel_member->user_id = $user;
            $komsel_member->save();
        }
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
        $ketua = Komsel::with(['user'])->where('id' , $id)->first();
        $members = KomselMember::with(['user'])->where('komsel_id' , $id)->get();
        return view('superadmin.komsel.komseldetail' , ['ketua' => $ketua , 'members' => $members ,'komsel_id' => $id]);
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
