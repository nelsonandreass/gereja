@extends('layout.layoutsuperadmin')
 
@section('content') 
    <div class="page-wrapper">
        <div class="container-fluid">
           
            <div class="card p-3 ">  
            <form action="{{route('komsel.store')}}" id="form" method="POST" enctype="multipart/form-data">
            @csrf
                <div class="form-group row">
                    <label for="" class="col-sm-2 col-form-label">Nama</label>
                    <div class="col-sm-10">
                    <input type="text"  class="form-control" name="name" required>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="" class="col-sm-2 col-form-label">Alamat</label>
                    <div class="col-sm-10">
                    <input type="text"  class="form-control" name="alamat" required>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="" class="col-sm-2 col-form-label">Ketua</label>
                    <div class="col-sm-10">
                    <select name="ketua" id="" class="form-select">
                        <option value="">--Pilih--</option>
                        @foreach($users as $user)
                            <option value="{{$user->id}}">{{$user->name}}</option>
                        @endforeach
                    </select>
                    </div>
                </div>
                 

         
                
                <div class="row">
                    <center>
                        <div class="col-4">
                            <button class="btn btn-primary" id="simpan">Simpan</button>
                        </div>
                    </center>
                </div>
            </form>
            </div>
        </div>
    </div>

  
@endsection


<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.12.1/js/bootstrap-select.js"></script>