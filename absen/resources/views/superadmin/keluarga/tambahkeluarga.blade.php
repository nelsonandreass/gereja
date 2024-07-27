@extends('layout.layoutsuperadmin')
 
@section('content') 
    <div class="page-wrapper">
        <div class="container-fluid">
           
            <div class="card p-3 ">  
                <div class="container-fluid">
                    <div class="row mb-3" >
                        <div class="col-2 mx-2"> 
                            <div class="row">
                                <b>Kepala Keluarga</b>
                            </div>
                            <div class="row">
                                <input type="input" class="form-control rounded" placeholder="Search" id="search" autocomplete="off"/>
                            </div>
                        </div>
                    </div>
                    <form method="post" action="{{route('keluarga.store')}}" enctype="multipart/form-data">
                        @csrf
                        <div class="card p-3 ">  
                            <div class="table-responsive">
                                <table class="table table-striped" id="sortedtable">
                                        <thead>
                                            <th>No</th>
                                            <th>Nama</th>
                                            <th>Panggilan</th>
                                            <th class="w-25">Alamat</th>
                                            <th>Foto</th>
                                            <th >Action</th>
                                        </thead>
                                        <tbody id="body-table">
                                            @php $i = 1; @endphp
                                            @foreach($users as $user)
                                                <tr class="default-table">
                                                    <td>{{$i}}</td>
                                                    <td>{{$user->name}}</td>
                                                    <td>{{$user->nama_panggilan}}</td>
                                                    <td>{{$user->alamat}}</td>
                                                    <td><img src="{{asset('/absen/storage/app/public/'.$user->foto)}}" class="icon" alt="{{$user->foto}}"></td>
                                                    <td >
                                                        <input type="radio" name="kepalakeluarga" onchange="changeid({{$user->id}})" id="kepalakeluarga" value="{{$user->id}}">
                                                    </td>
                                                </tr>
                                                @php $i += 1; @endphp
                                            @endforeach
                                        </tbody>
                                </table>
                            </div>
                        </div>
                        <input type="hidden" id="tempKeluarga" name="tempKeluarga">
                        <div class="row mt-3">
                            <div class="col-2">
                                <button id="simpan" class="btn btn-primary" type="submit">Simpan</button>
                            </div>
                        </div>
                    </form>
                </div>

                
            </div>
        </div>
    </div>

  
@endsection

@section('script')
<script type="text/javascript">
    // add row
    

    $("#addRow").click(function () {
        var html = '';
        html += '<div id="inputFormRow">';
        html += '<div class="input-group mb-3">';
        html += '<select name="title[]" id="" class="form-select">';
        html += '<option value="">--Pilih--</option>';
        html += '@foreach($users as $user)';
        html += '<option value="{{$user->kartu}}">{{$user->name}}</option>';
        html += '@endforeach';
        html += '</select>';
        html += '<div class="input-group-append">';
        html += '<button id="removeRow" type="button" class="btn btn-danger" style="color:white; border-radius:.5rem;">Hapus</button>';
        html += '</div>';
        html += '</div>';

        $('#newRow').append(html);
    });

    // remove row
    $(document).on('click', '#removeRow', function () {
        $(this).closest('#inputFormRow').remove();
    });

    // $('#simpan').click(function(e){
    //     var values = $("select[name^='title']").map(function (idx, ele) {
    //         return $(ele).val();
    //     }).get();
    //     $('#id').val(values);
    //     console.log(values);
    // });

    function changeid(request){
        $('#kepalakeluarga').val(request);
        $('#tempKeluarga').val(request);
    }
    
    $('#search').keyup(function(event){
        var name = $('#search').val();
        var kepalaKeluarga = $('#kepalakeluarga').val();
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
                        $('#body-table').append('<tr class="row-table"><td>'+(i+1)+'</td><td>'+data[i].name+'</td><td>'+(data[i].nama_panggilan === null ? "":data[i].nama_panggilan)+'</td><td class="w-25">'+data[i].alamat+'</td><td><img class="icon" src='+photo+'></td><td><input type="radio" onchange="changeid('+data[i].id+')" value="'+data[i].id+'"></td></tr>');
                    }
                    if(data == ""){
                        $(".default-table").show();
                    }
            },
        });
        
    });

</script>
@endsection
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.12.1/js/bootstrap-select.js"></script>