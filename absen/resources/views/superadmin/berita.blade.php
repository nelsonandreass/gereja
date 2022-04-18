@extends('layout.layoutsuperadmin')

@section('content')
   
    <div class="page-wrapper ">
        <div class="container-fluid">
        <center>
            <div class="row">
                <div class="col-2">
                    <a href="{{url('/createberita')}}" class="btn btn-success mdi mdi-library-plus"style="color:white !important;">&nbsp;Buat Berita</a>
                </div>
            </div>
            <div class="row mt-3">
                <table class="table table-striped">
                    <thead>
                        <th>No</th>
                        <th>Judul</th>
                        <th>Berita</th>
                        <th>Wadah</th>
                        <th>Tanggal</th>
                        <th>Action</th>
                    </thead>
                    <tbody>
                        <?php $i = 1?>
                        @foreach($datas as $data)
                            <tr>
                                <td>{{$i}}</td>
                                <td>{{$data->judul}}</td>
                                <td>{{$data->berita}}</td>
                                <td>{{$data->wadah}}</td>
                                <td>{{$data->created_at}}</td>
                                <td>
                                    <a href="{{url('/updateberita',$data->id)}}" class="btn btn-primary" >Lihat</a>
                                </td>
                            </tr>
                            <?php $i++?>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </center>
        </div>
    </div>
@endsection