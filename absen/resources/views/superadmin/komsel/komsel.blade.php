@extends('layout.layoutsuperadmin')
 
@section('content') 
    <div class="page-wrapper">
        <div class="container-fluid">
           
            <div class="card p-3 ">  
                    <div class="row mb-3" >
                        <div class="col-2">
                            <a href="{{route('komsel.create')}}" class="btn btn-secondary ml-auto"><span class="mdi mdi-account-multiple-plus"> Tambah Komsel</span></a>
                        </div>
                        <div class="col-6">&nbsp;</div>
                        
                    </div>

                <div class="table-responsive">
                    <table class="table table-striped ">
                            <thead>
                                <th>No</th>
                                <th>Komsel</th>
                                <th>Pengurus</th>
                                <th>Action</th>
                            </thead>
                            <tbody id="body-table">
                                @php $i=1; @endphp
                                @forelse($komsels as $komsel)
                                    <tr>
                                        <td>{{$i}}</td>
                                        <td>{{$komsel->nama}}</td>
                                        <td>{{$komsel->user->name}}</td>
                                        <td><a href="{{route('komseldetail.show' , $komsel->id)}}" class="btn btn-primary">Detail</a></td>

                                    </tr>
                                    @php $i++; @endphp

                                @empty
                                    <tr>
                                        <td colspan="4" class="text-center">Kosong</td>
                                    </tr>
                                   
                                @endforelse
                            </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

  
@endsection


<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.12.1/js/bootstrap-select.js"></script>