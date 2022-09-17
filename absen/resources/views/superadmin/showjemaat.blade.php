@extends('layout.layoutsuperadmin')

@section('content')
    <div class="page-wrapper">
        <div class="container-fluid">
        
            <form action="{{url('/update/jemaat')}}" method="post" enctype="multipart/form-data">
            @csrf
                <input type="hidden" value="{{$datas->id}}" name="id">
                <div class="form-group row">
                    <label for="" class="col-sm-2 col-form-label">Nama</label>
                    <div class="col-sm-10">
                    <input type="text" readonly class="form-control" name="name" value="{{$datas->name}}">
                    </div>
                </div>
                <div class="form-group row">
                    <label for="" class="col-sm-2 col-form-label">Nama Panggilan</label>
                    <div class="col-sm-10">
                    <input type="text" class="form-control" name="nama_panggilan" value="{{$datas->nama_panggilan}}">
                    </div>
                </div>
                <div class="form-group row">
                    <label for="" class="col-sm-2 col-form-label">Jenis Kelamin</label>
                    <div class="col-sm-10">
                    <input type="text" readonly class="form-control" name="jenis_kelamin" value="{{$datas->jenis_kelamin}}">
                    </div>
                </div>
                <div class="form-group row">
                    <label for="" class="col-sm-2 col-form-label">Status Pernikahan</label>
                    <div class="col-sm-10">
                    <input type="text"  class="form-control" name="status_pernikahan" value="{{$datas->status_pernikahan}}">
                    </div>
                </div>
                <div class="form-group row">
                    <label for="" class="col-sm-2 col-form-label">Tempat Lahir</label>
                    <div class="col-sm-10">
                    <input type="text" class="form-control" value="{{$datas->tempat_lahir}}" name="tempatlahir">
                    </div>
                </div>
                <div class="form-group row">
                    <label for="" class="col-sm-2 col-form-label">Tanggal Lahir</label>
                    <div class="col-sm-10">
                    <input type="date" class="form-control" value="{{$datas->tanggal_lahir}}" name="tgllahir">
                    </div>
                </div>
                <div class="form-group row">
                    <label for="" class="col-sm-2 col-form-label">Nomor Telepon</label>
                    <div class="col-sm-10">
                    <input type="text"  class="form-control" name="telepon"  value="{{$datas->nomor_telepon}}">
                    </div>
                </div> 
                <div class="form-group row">
                    <label for="" class="col-sm-2 col-form-label">E-mail</label>
                    <div class="col-sm-10">
                    <input type="text"  class="form-control" name="email"  value="{{$datas->email}}">
                    </div>
                </div>
                <div class="form-group row">
                    <label for="" class="col-sm-2 col-form-label">Alamat</label>
                    <div class="col-sm-10">
                    <input type="text" class="form-control" name="alamat"  value="{{$datas->alamat}}">
                    </div>
                </div>
                <div class="form-group row">
                    <label for="" class="col-sm-2 col-form-label">Kecamatan</label>
                    <div class="col-sm-10">
                    <input type="text" class="form-control" name="kecamatan"  value="{{$datas->kecamatan}}">
                    </div>
                </div>

                <div class="form-group row">
                    <label for="" class="col-sm-2 col-form-label">Kelurahan</label>
                    <div class="col-sm-10">
                    <input type="text" class="form-control" name="kelurahan"  value="{{$datas->kelurahan}}">
                    </div>
                </div>
                <div class="form-group row">
                    <label for="" class="col-sm-2 col-form-label">Nomor Kartu</label>
                    <div class="col-sm-10">
                    <input type="text" class="form-control" name="nokartu"  value="{{$datas->kartu}}">
                    </div>
                </div>
                @php    

                    if($datas->foto == '' || is_null($datas->foto)){
                        echo ('
                        <div class="form-group row">
                            <label for="" class="col-sm-2 col-form-label">Foto</label>
                            <div class="col-sm-10">
                            <input type="file" class="form-control" name="foto">
                            </div>
                        </div>
                        ');
                      

                    }
                    

                @endphp
                <div class="form-group row" style="">
                    <label for="" class="col-sm-2 col-form-label" style="<?php if(!is_null($datas->foto ) ?  print('display: block;') : print('display: none;') )?>">Foto</label>
                    <div class="col-sm-10 h-50">
                        <img class="col-12 no-absen " style="width: 15%;<?php if(!is_null($datas->foto ) ?  print('display: block;') : print('display: none;') )?>" src="{{asset('/absen/storage/app/public/'.$datas->foto)}}" id="foto-jemaat" alt="{{$datas->foto}}">

                    </div>
                </div>
                <center>
                    <div class="row">
                        <div class="col-4">
                            <button class="btn btn-primary">Simpan</button>
                        </div>
                        <div class="col-1">&nbsp;</div>
                        <div class="col-4">
                            <form action="{{url('/delete/jemaat')}}" id="deleteuser">
                                @csrf
                                <input type="hidden" value="{{$datas->id}}" name="id">
                                <!-- <a class="btn btn-danger" onclick="submitform()" id="button-delete" style="color:white;width:100%;border-radius:.5em;">Delete</a> -->

                            </form>
                        </div>
                    </div>
                </center>
            </form>
                           
          
        </div>
    </div>

    <script>

        
        // $(document).ready(function(){
        //     $('#button-delete').click(function(e){
        //         e.preventDefault();
        //         $('#deleteuser').submit();
        //     });
        // });

    </script>
@endsection

@section('script')
    <script type="javascript">
       
        function submitform(){
            document.getElementById('deleteuser').submit();
        }
    </script>

@endsection