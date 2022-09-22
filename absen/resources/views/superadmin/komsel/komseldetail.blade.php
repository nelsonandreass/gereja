@extends('layout.layoutsuperadmin')
 
@section('content') 
    <div class="page-wrapper">
        <div class="container-fluid">
           
            <div class="card p-3 ">  
                    <div class="row mb-3" >
                        <div class="col-3">
                            <a href="{{route('komseldetail.create',$komsel_id)}}" class="btn btn-secondary ml-auto"><span class="mdi mdi-account-multiple-plus"> Tambah Member</span></a>
                        </div>
                        <div class="col-6">&nbsp;</div>
                        
                    </div>

                <div class="table-responsive">
                    <table class="table table-striped ">
                            <thead>
                                <th>No</th>
                                <th>Nama</th>
                                <th>Telepon</th>
                                <th>Action</th>
                            </thead>
                            <tbody id="body-table">
                                <tr>
                                    <td>1</td>
                                    <td>{{$ketua->user->name}}</td>
                                    <td>{{$ketua->user->nomor_telepon}}</td>
                                    <td></td>
                                </tr>
                                @php $i=2; @endphp
                                @foreach($members as $member)
                                    <tr>
                                        <td>{{$i}}</td>
                                        <td>{{$member->user->name}}</td>
                                        <td>{{$member->user->nomor_telepon}}</td>
                                        <td></td>
                                    </tr>
                                    @php $i++; @endphp
                                @endforeach
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