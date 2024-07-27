@extends('layout.layoutsuperadmin')
 
@section('content') 
    <div class="page-wrapper">
        <div class="container-fluid">

            <div class="card p-3 ">  
                <div class="row mb-3" >
                    <div class="col-2">
                        <a href="{{route('keluarga.create')}}" class="btn btn-secondary ml-auto"><span class="mdi mdi-account-multiple-plus"> Tambah Keluarga</span></a>
                    </div>
                    <div class="col-6">&nbsp;</div>    
                </div>

                <table id="sortedtable"  class="table table-striped">
                    <thead>
                        <th>No</th>
                        <th>Nama</th>
                        <th>Action</th>
                    </thead>
                    <tbody>
                        @php $i = 1; @endphp
                        @foreach($keluargas as $keluarga)
                        <tr>
                            <td>{{$i}}</td>
                            <td>{{$keluarga->user->name}}</td>
                            <td style="width:10rem !important"> 
                                <a href="{{url('/keluargamember', $keluarga->id)}}" class="btn btn-primary">Detail</a>
                            </td>
                        </tr>
                        @php $i++; @endphp
                        @endforeach

                    </tbody>
                </table>
            </div>
        </div>
    </div>

  
@endsection

@section('script')
    <script>
       
    </script>
@endsection
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.12.1/js/bootstrap-select.js"></script>