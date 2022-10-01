@extends('layout.layoutsuperadmin')
 
@section('content') 
    <div class="page-wrapper">
        <div class="container-fluid">
            <div class="card p-3">  
            <h1 class="text-center mb-3">Selamat Datang di GPdI Sahabat Allah</h1>

                <div class="row justify-content-center mt-3">
                    @foreach($users as $user)
                        <div class="col-3 mb-3">
                            <div class="row mb-3">
                                <img src="{{asset('/absen/storage/app/public/'.$user->foto)}}" class="mx-auto" style="height:50vh !important; width:100% !important; max-height: 50vh !important;max-width: 100% !important;" alt="{{$user->foto}}">
                            </div>
                            <div class="row">
                                <span class="text-center">{{$user->name}}</span>
                            </div>
                        </div>
                    @endforeach
                </div>
               
            </div>
        </div>
    </div>

  
@endsection


