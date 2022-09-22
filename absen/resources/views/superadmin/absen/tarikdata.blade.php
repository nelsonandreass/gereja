@extends('layout.layoutsuperadmin')

@section('content')
<div class="page-wrapper p-3">  
    <div class="row">
        <!-- column -->
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <!-- title -->
                    <div class="d-md-flex">
                        <div>
                            <h4 class="card-title">Jemaat Tidak Hadir</h4>
                            <pre></pre>
                            

                        </div>
                    </div>
                    <!-- title -->

                    <form action="{{url('/absen/tarikdataprocess')}}" method="get">
                     
                        <div class="row">
                            <div class="col-6">
                                <select name="tanggal" id="tanggal" onchange="change()" class="form-control">
                                    <option value="default" style="color: #DBDBDB">Pilih Tanggal...</option>    
                                    @foreach($dates as $date)
                                        <option value="{{$date->tanggal}}">{{$date->tanggal}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-2">
                                <button class="btn btn-primary" id='tarik'>Tarik</button>
                            </div>
                        </div>
                    </form>
                    <br>&nbsp;
                    <br>&nbsp;
                    <div class="col-2">
                        <button class="btn btn-success" id="print" style="display:none;color:white;border-radius:.5rem">print</button>
                    </div>
                    <br>
                    <table id="table-absen" class="table table-striped table-bordered">
                        <thead>
                            <th>No</th>
                            <th>Nama</th>
                            <th>No Telepon</th>
                            <th>Alamat</th>
                        </thead>
                        <tbody id="body-table">
                          
                        </tbody>
                </table> 



                </div>
              
            </div>
        </div>
    </div>
</div>
@endsection


@section('script')
    <script>
        var tanggal;   

        function printData(){
            var divToPrint = document.getElementById("table-absen");
            var htmlToPrint = '' +
                '<style type="text/css">' +
                'table th, table td {' +
                'border:1px solid #000;' +
                'padding:0.5em;' +
                '}' +
                '</style>';
            htmlToPrint += divToPrint.outerHTML;
            newWin = window.open("");
            newWin.document.write(htmlToPrint);
            newWin.print();
            newWin.close();
        }  	
       
        function change(){
            tanggal = $("#tanggal").val();
        }
        $(document).ready(function(){
            $("#tarik").click(function(e){
                e.preventDefault();
                $.ajax({
                        url: "/absen/api/tarikdataprocess",
                        datatype: "application/x-www-form-urlencoded",
                        method:"POST",
                        data:{
                            tanggal: tanggal
                        },
                        success: function(data)
                        {
                            $(this).parents('.row-table').remove();
                                for(var i = 0 ; i < data.data.length ; i++){
                                    $('#body-table').append('<tr class="row-table"><td>'+(i+1)+'</td><td>'+data.data[i].name+'</td><td>'+data.data[i].nomor_telepon+'</td><td>'+data.data[i].alamat+'</td></tr>');;
                                }
                                $('#print').css("display","block");
                        },
                    });
            });

            $('#print').on('click', function(e) {
                e.preventDefault();
                printData();
            })
        });
    </script>
@endsection