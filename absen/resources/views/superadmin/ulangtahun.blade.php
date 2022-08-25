@extends('layout.layoutsuperadmin')
 
@section('content') 
    <div class="page-wrapper">
        <div class="container-fluid">
           
            <div class="card p-3">  
                    <div class="row mb-3" >
                        <div class="col-2">
                           
                        </div>
                        <div class="col-6">&nbsp;</div>
                        <div class="col-4"> 
                            <div class="row">
                                <div class="col-7">
                                    <select name="month" class="form-control" id="month">
                                        <option value="1" id="1" class="form-control">Januari</option>
                                        <option value="2" id="2" class="form-control">Februari</option>
                                        <option value="3" id="3" class="form-control">Maret</option>
                                        <option value="4" id="4" class="form-control">April</option>
                                        <option value="5" id="5" class="form-control">Mei</option>
                                        <option value="6" id="6" class="form-control">Juni</option>
                                        <option value="7" id="7" class="form-control">Juli</option>
                                        <option value="8" id="8" class="form-control">Agustus</option>
                                        <option value="9" id="9" class="form-control">September</option>
                                        <option value="10" id="10" class="form-control">Oktober</option>
                                        <option value="11" id="11" class="form-control">November</option>
                                        <option value="12" id="12" class="form-control">Desember</option>
                                    </select>
                                </div>
                                <div class="col-4">
                                    <button id="searchulangtahun" class="btn-primary form-control">Search</button>
                                </div>
                                
                            </div>
                            <!-- <input type="input" class="form-control rounded" placeholder="Search" id="search"  autocomplete="off"/> -->
                        </div>
                    </div>

                <table class="table table-striped">
                        <thead>
                            <th>No</th>
                            <th>Nama</th>
                            <th>Panggilan</th>
                            <th>No Telepon</th>
                            <th>Alamat</th>
                            <th>Tanggal Lahir</th>
                            <th>Foto</th>
                        </thead>
                        <tbody id="body-table">

                            @php $i = 1; @endphp
                            @foreach($users as $user)
                                <tr class="default-table">
                                    <td>{{$i}}</td>
                                    <td>{{$user->name}}</td>
                                    <td>{{$user->nama_panggilan}}</td>
                                    <td>{{$user->nomor_telepon}}</td>
                                    <td>{{$user->alamat}}</td>
                                    <td>{{$user->tanggal_lahir}}</td>
                                    <td><img src="{{asset('/absen/storage/app/public/'.$user->foto)}}" class="icon" alt="{{$user->foto}}"></td>
                                    <td>
                                        <a href="{{url('/showjemaat', $user->id)}}" class="btn btn-primary">Show</a>
                                    </td>
                                </tr>
                                @php $i += 1; @endphp
                            @endforeach
                        </tbody>
                </table>
            </div>
        </div>
    </div>

  
@endsection

@section('script')
    <script>
        $(document).ready(function(){
            var date = new Date();
            var month = date.getMonth()+1;
            $('#'+month).attr('selected', 'selected');
            $('#searchulangtahun').click(function(event){
                var month = $('#month').val();
                $.ajax({
                    url: "/absen/api/searchulangtahun",
                    datatype: "application/x-www-form-urlencoded",
                    method:"POST",
                    data:{
                        month: month
                    },
                    success: function(data)
                    {
                        $(".default-table").hide();
                        $('.row-table').remove();
                            for(var i = 0; i < data.length ; i++){
                                if(data[i].foto == null){
                                    var photo = "";
                                }
                                else{
                                    var photo = '/absen/absen/storage/app/public/'+data[i].foto.split(" ").join('%20');

                                }
                                $('#body-table').append('<tr class="row-table"><td>'+(i+1)+'</td><td>'+data[i].name+'</td><td>'+(data[i].nama_panggilan === null ? "":data[i].nama_panggilan)+'</td><td>'+data[i].nomor_telepon+'</td><td>'+data[i].alamat+'</td><td>'+data[i].tanggal_lahir+'</td><td><img class="icon" src='+photo+'></td><td><a class="btn btn-primary" href=/absen/showjemaat/'+data[i].id+'>Show</a></td></tr>');
                            }
                            if(data == ""){
                                $(".default-table").show();
                            }
                    },
                });
                
            });
        });
    </script>
@endsection
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.12.1/js/bootstrap-select.js"></script>