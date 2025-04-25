@extends('layout.layoutsuperadmin')
 
@section('content') 
    <div class="page-wrapper">
        <div class="container-fluid">

            <div class="card p-3 ">  
                <table id="sortedtable"  class="table table-striped">
                    <thead>
                        <th>No</th>
                        <th>Nama</th>
                        <th>Panggilan</th>
                        <th>No Telepon</th>
                        <th class="w-25">Alamat</th>
                        <th>Umur</th>
                        <th>Foto</th>
                    </thead>
                    <tbody id="body-table-komsel">
                        @php $i = 1; @endphp
                        @forelse($users as $user)
                            <tr class="default-table">
                                <td>{{$i}}</td>
                                <td>{{$user['name']}}</td>
                                <td>{{$user['nama_panggilan']}}</td>
                                <td>{{$user['nomor_telepon']}}</td>
                                <td>{{$user['alamat']}}</td>
                                <td>{{$user['umur']}}</td>
                                <td><img src="{{asset('/absen/storage/app/public/'.$user['foto'])}}" class="icon" alt="{{$user['foto']}}"></td>
                               
                            </tr>
                            @php $i += 1; @endphp
                        @empty
                            <tr class="default-table">
                                <td colspan=7 class="text-center">Kosong</td>  
                               
                            </tr>
                        @endforelse
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