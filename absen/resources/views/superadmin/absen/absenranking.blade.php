@extends('layout.layoutsuperadmin')

@section('content')

    <div class="page-wrapper p-3">  
        <div class="row">
            <!-- column -->
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <!-- title -->
                        <div class="row">
                            <div class="col-md-2 mt-2"> Peringkat Tahun</div>
                            <div class="col-md-2">
                                <select name="tahun" id="tahun" class="form-control">
                                    <option value="2023">2023</option>
                                    <option value="2024">2024</option>
                                    <option value="2025">2025</option>
                                </select>
                            </div>
                        </div>
                      <!-- title -->
                    </div>
                    
                    <div class="table-responsive">
                        <table class="table table-striped" id="sortedtable">
                                <thead>
                                    <th>No</th>
                                    <th>Nama</th>
                                    <th>Jumlah Kehadiran</th>
                                    <th>Foto</th>
                                    
                                </thead>
                                <tbody id="body-table">

                                    @php $i = 1; @endphp
                                   
                                </tbody>
                        </table>
                    </div>
                    
                </div>
            </div>
        </div>
    </div>
<script>
$(document).ready(function(){
    var year = $('#tahun').val();
    $.ajax({
        url: "/gereja/api/ranking",
        datatype: "application/x-www-form-urlencoded",
        method:"POST",
        data:{
            year: year
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
                            var photo = '/gereja/absen/storage/app/public/'+data[i].foto.split(" ").join('%20');
                        }
                        $('#body-table').append('<tr class="row-table"><td>'+(i+1)+'</td><td>'+data[i].nama+'</td><td>'+data[i].kedatangan+'</td><td><img src='+photo+'></td></tr>');
                }
                if(data == ""){
                    $(".default-table").show();
                }
        },
    });
    $('#tahun').change(function(event){
        var year = $('#tahun').val();
        $.ajax({
            url: "/gereja/api/ranking",
            datatype: "application/x-www-form-urlencoded",
            method:"POST",
            data:{
                year: year
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
                            var photo = '/gereja/absen/storage/app/public/'+data[i].foto.split(" ").join('%20');
                        }
                        $('#body-table').append('<tr class="row-table"><td>'+(i+1)+'</td><td>'+data[i].nama+'</td><td>'+data[i].kedatangan+'</td><td><img src='+photo+'></td></tr>');
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