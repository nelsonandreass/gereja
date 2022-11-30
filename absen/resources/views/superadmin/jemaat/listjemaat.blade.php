@extends('layout.layoutsuperadmin')
 
@section('content') 
    <div class="page-wrapper">
        <div class="container-fluid">
           
            <div class="card p-3 ">  
                <div class="row mb-3" >
                    <div class="col-3">
                        <div class="row px-2">
                                <b>Umur</b>
                            </div>
                            <div class="row">
                                <div class="col-6">
                                    <input type="number" name="dariumur" id="dariumur" class="form-control" placeholder="Dari Umur">
                                </div>
                                <div class="col-6">
                                    <input type="number" name="sampaiumur" id="sampaiumur" class="form-control"placeholder="Sampai Umur">
                                </div>
                            </div>
                        </div>
                    <div class="col-3">
                        <div class="row">
                            <b>Kecamatan</b>
                        </div>
                        <div class="row">
                            <select class="form-control" name="" id="kecamatan">
                                <option value="semua">Semua Kecamatan</option>
                                @foreach($kecamatan as $kec)
                                    <option value="{{$kec->kecamatan}}">{{$kec->kecamatan}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-2 mx-2"> 
                        <div class="row">
                            <b>Nama</b>
                        </div>
                        <div class="row">
                            <input type="input" class="form-control rounded" placeholder="Search" id="search"  autocomplete="off"/>
                        </div>
                    </div>
                </div>
                
                <!-- <div class="row mb-3">
                    <div class="col-2">
                        <button class="btn btn-success" id="print" style="color:white;border-radius:.5rem">print</button>
                    </div>
                </div> -->

                <div class="table-responsive">
                    <table class="table table-striped" id="sortedtable">
                            <thead>
                                <th>No</th>
                                <th>Nama</th>
                                <th>Panggilan</th>
                                <th>No Telepon</th>
                                <th class="w-25">Alamat</th>
                                <th>No Kartu</th>
                                <th>Umur</th>
                                <th>Foto</th>
                                <th>Action</th>
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
                                        <td>{{$user->kartu}}</td>
                                        <td>{{$user->umur}}</td>
                                        <td><img src="{{asset('/absen/storage/app/public/'.$user->foto)}}" class="icon" alt="{{$user->foto}}"></td>
                                        <td>
                                            <a href="{{url('/showjemaat', $user->id)}}" class="btn btn-primary">Edit</a>
                                            <a href="{{url('/delete', $user->id)}}" class="btn btn-danger w-100 mt-1" style="color:white;border-radius:.5rem">Delete</a>
                                        </td>
                                    </tr>
                                    @php $i += 1; @endphp
                                @endforeach
                            </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

  
@endsection

@section('script')
    <script>
        $(document).ready(function(){
            $('#print').click(function () {
                console.log($('#sortedtable')[0].outerHTML);
                var pageTitle = 'Page Title',
                stylesheet = '//maxcdn.bootstrapcdn.com/bootstrap/3.3.2/css/bootstrap.min.css',
                win = window.open('', 'Print', 'width=1000,height=1000');
                win.document.write('<html><head><title>' + pageTitle + '</title>' +
                '<link rel="stylesheet" href="' + stylesheet + '">' +
                '<style type="text/css">'+'table th, table td {border:1px solid #000;padding:0.5em;} img{width:30px;height;30px}' +'</style>'+
                '</head><body>' + $('#sortedtable')[0].outerHTML + '</body></html>');
                win.setTimeout(function(){
                    win.document.close();
                    win.print();
                    win.close();
                } , 3500);
            });

            $('#sampaiumur').change(function(){
                var start = $('#dariumur').val();
                var to = $('#sampaiumur').val();
                if(dariumur > sampaiumur){
                    alert('dari dan sampai umur terbalik');
                }
                if($('#dariumur').val() == null || $('#dariumur').val() == ''){
                    start = 0;
                }
                $.ajax({
                    url: "/absen/api/sortjemaatbyumur",
                    datatype: "application/x-www-form-urlencoded",
                    method:"POST",
                    data:{
                        dariumur: start,
                        sampaiumur: to
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
                                $('#body-table').append('<tr class="row-table"><td>'+(i+1)+'</td><td>'+data[i].name+'</td><td>'+(data[i].nama_panggilan === null ? "":data[i].nama_panggilan)+'</td><td>'+data[i].nomor_telepon+'</td><td class="w-25">'+data[i].alamat+'</td><td>'+data[i].kartu+'</td><td><img class="icon" src='+photo+'></td><td><a class="btn btn-primary" href=/absen/showjemaat/'+data[i].id+'>Edit</a></td></tr>');
                            }
                            if(data == ""){
                                $(".default-table").show();
                            }
                    },
                });
            });

            $('#search').keyup(function(event){
                var name = $('#search').val();
                $.ajax({
                    url: "/absen/api/searchjemaat",
                    datatype: "application/x-www-form-urlencoded",
                    method:"POST",
                    data:{
                        jemaat: name
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
                                $('#body-table').append('<tr class="row-table"><td>'+(i+1)+'</td><td>'+data[i].name+'</td><td>'+(data[i].nama_panggilan === null ? "":data[i].nama_panggilan)+'</td><td>'+data[i].nomor_telepon+'</td><td class="w-25">'+data[i].alamat+'</td><td>'+data[i].kartu+'</td><td>'+data[i].umur+'</td><td><img class="icon" src='+photo+'></td><td><a class="btn btn-primary" href=/absen/showjemaat/'+data[i].id+'>Edit</a></td></tr>');
                            }
                            if(data == ""){
                                $(".default-table").show();
                            }
                    },
                });
                
            });
            
            $('#kecamatan').change(function(event){
                var datakecamatan = $('#kecamatan').val();
                $.ajax({
                    url: "/absen/api/sortjemaat",
                    datatype: "application/x-www-form-urlencoded",
                    method:"POST",
                    data:{
                        kecamatan: datakecamatan
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
                                $('#body-table').append('<tr class="row-table"><td>'+(i+1)+'</td><td>'+data[i].name+'</td><td>'+(data[i].nama_panggilan === null ? "":data[i].nama_panggilan)+'</td><td>'+data[i].nomor_telepon+'</td><td class="w-25">'+data[i].alamat+'</td><td>'+data[i].kartu+'</td><td>'+data[i].umur+'</td><td><img class="icon" src='+photo+'></td><td><a class="btn btn-primary" href=/absen/showjemaat/'+data[i].id+'>Edit</a></td></tr>');
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