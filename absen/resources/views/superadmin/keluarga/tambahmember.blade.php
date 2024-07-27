@extends('layout.layoutsuperadmin')
 
@section('content') 
    <div class="page-wrapper">
        <div class="container-fluid">
           
            <div class="card p-3 ">  
                <div class="row mb-3">
                    <div class="table-responsive">
                        <table class="table table-striped" id="table-keluarga">
                            <thead>
                                <th>Nama</th>
                                <th>Panggilan</th>
                                <th class="w-25">Alamat</th>
                                <th class="removeCol">Foto</th>
                               
                            </thead>
                            <tbody id="table-keluarga">
                                @foreach($anggotaKeluarga as $anggota)
                                    <tr class="anggota-keluarga">
                                        <td>{{$anggota->user->name}}</td>
                                        <td>{{$anggota->user->nama_panggilan}}</td>
                                        <td>{{$anggota->user->alamat}}</td>
                                        <td class="removeCol"><img src="{{asset('/absen/storage/app/public/'.$anggota->user->foto)}}" class="icon" alt="{{$anggota->user->foto}}"></td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    <a href="{{url('/printkeluarga', $keluargaid)}}" class="btn btn-success" target="_blank" id="print" style="color:white;border-radius:.5rem">Print</a>
                    </div>
                </div>    
                <div class="row mb-3 px-3" >
                    <div class="col-2 mx-2"> 
                        <div class="row">
                            <b>Anggota Keluarga</b>
                        </div>
                        <div class="row my-2">
                            <input type="input" class="form-control rounded" placeholder="Search" id="search" autocomplete="off"/>
                        </div>
                    </div>
                </div>
                <form method="post" action="{{route('keluargamember.store')}}" style="margin-top:-1%; !important">
                    @csrf
                    <div class="card p-3 ">  
                        <div class="row mt-3">
                            <div class="col-2">
                                <button id="simpan" class="btn btn-primary">Simpan</button>
                            </div>
                        </div>
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
                                                    <input type="checkbox" name="userId" onchange="addId(this,{{$user->id}},{{$user}})" id="kepalakeluarga" value="{{$user->id}}">
                                                </td>
                                            </tr>
                                            @php $i += 1; @endphp
                                        @endforeach
                                    </tbody>
                            </table>
                        </div>
                    </div>
                    <input type="hidden" id="tempUserId" name="tempUserId">
                    <input type="hidden" name="keluargaid" value="{{$keluargaid}}">
                    
                </form>
               

                
            </div>
        </div>
    </div>

  
@endsection

@section('script')
<script type="text/javascript">
    
    var tempId = [];
    $(document).ready(function(){
        $("#search").focus();
        // $('#print').click(function () {
        //     var pageTitle = 'Keluarga';
        //     var clonedTable = $('#table-keluarga').clone();
        //     clonedTable.find('.removeCol').remove();
        //     var htmlTemp = clonedTable.wrap('<p>').parent().html();

        //     stylesheet = '//maxcdn.bootstrapcdn.com/bootstrap/3.3.2/css/bootstrap.min.css';

        //     var printContent = `
        //         <html>
        //         <head>
        //             <title>${pageTitle}</title>
        //             <link rel="stylesheet" href="${stylesheet}">
        //             <style type="text/css">
        //                 @media print {
        //                     @page {
        //                         size: landscape;
        //                     }
        //                 }
        //                 table th, table td {
        //                     border: 1px solid #000;
        //                     padding: 0.5em;
        //                 }
        //                 img {
        //                     width: 30px;
        //                     height: 30px;
        //                 }
        //             </style>
        //         </head>
        //         <body>
        //             ${htmlTemp}
        //         </body>
        //         </html>`;
        //     win = window.open('', 'Print', 'width=1000,height=1000');
        //     win.document.write(printContent);
        //     win.setTimeout(function(){
        //         win.document.close();
        //         win.print();
        //         win.close();
        //     } , 100);
        // });
    });


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

    $('#simpan').click(function(e){
        var values = $("select[name^='title']").map(function (idx, ele) {
            return $(ele).val();
        }).get();
        $('#id').val(values);
        console.log(values);
    });

    function addId(checkbox, id, data){
        if(checkbox.checked){
            var photo = '/absen/absen/storage/app/public/'+data.foto.split(" ").join('%20');
            $('#table-keluarga').append(`
                <tr class=${id}>
                    <td>${data.name}</td>
                    <td>${data.nama_panggilan === null ? "" : data.nama_panggilan}</td>
                    <td class="w-25">${data.alamat}</td>
                    <td><img class="icon" src="${photo}" alt="${data.name}"></td>
                </tr>
            `);
            tempId.push(id);
            $('#tempUserId').val(tempId)
        }else{
            var index = tempId.indexOf(id);
            if (index > -1) {
                tempId.splice(index, 1);
            }
            $('#tempUserId').val(tempId)
            $('.'+id).remove();
        }

    }
    
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
                        $('#body-table').append( `<tr class="row-table">
                            <td>${i + 1}</td>
                            <td>${data[i].name}</td>
                            <td>${data[i].nama_panggilan === null ? "" : data[i].nama_panggilan}</td>
                            <td class="w-25">${data[i].alamat}</td>
                            <td><img class="icon" src="${photo}" alt="${data[i].name}"></td>
                            <td>
                            <input 
                                type="checkbox" 
                                onchange='addId(this,${data[i].id}, ${JSON.stringify(data[i])})' 
                                value="${data[i].id}">
                            </td>
                        </tr>`);
                    }
                    if(data == ""){
                        $(".default-table").show();
                    }
            },
        });
        
    });

    function printData(){
        var divToPrint = document.getElementById("table-keluarga");
        var htmlToPrint = '' +
            '<style type="text/css">' +
            '@media print {' +
            '@page { size: landscape; }' +
            'table th, table td {' +
            'border:1px solid #000;' +
            'padding:0.5em;' +
            '}' +
            '}' +
            '</style>';
        htmlToPrint += divToPrint.outerHTML;
        newWin = window.open("");
        newWin.document.write(htmlToPrint);
        newWin.print();
        newWin.close();
    }  	

</script>
@endsection
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.12.1/js/bootstrap-select.js"></script>