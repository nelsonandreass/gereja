@extends('layout.layoutsuperadmin')
 
@section('content') 
    <div class="page-wrapper">
        <div class="container-fluid">
           
            <div class="card p-3">  
                <div class="row justify-content-center">
                    @foreach($users as $user)
                        <div class="col-3 mb-3">
                            <div class="row mb-3">
                                <img src="{{asset('/absen/storage/app/public/'.$user->foto)}}" class="mx-auto" style="height:40vh !important; width:30vh !important; max-height: 40vh !important;max-width: 30vh !important;" alt="{{$user->foto}}">
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


