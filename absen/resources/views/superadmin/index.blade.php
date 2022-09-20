@extends('layout.layoutsuperadmin')

@section('content')
    <div class="page-wrapper ">
            <!-- <div class="page-breadcrumb">
                <div class="row align-items-center">
                    <div class="col-5">
                        <h4 class="page-title">Dashboard</h4>
                        <div class="d-flex align-items-center">
                            <nav aria-label="breadcrumb">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="#">Home</a></li>
                                    <li class="breadcrumb-item active" aria-current="page">Library</li>
                                </ol>
                            </nav>
                        </div>
                    </div>
                    <div class="col-7">
                       
                    </div>
                </div>
            </div> -->
            
            <div class="container-fluid ml-5">
                <!-- ============================================================== -->
                <!-- Sales chart -->
                <!-- ============================================================== -->
                <div class="row">
                    <div class="col-md-7">
                        <div class="card">
                            <div class="card-body">
                                
                                <div class="row">
                                    <div class="col-md-10">
                                        Tarik data
                                    </div>
                                    <input type="hidden" id="tanggal" value={{$tanggal}}>
                                    <input type="hidden" id="ibadah1" value={{$ibadah1}}>
                                    <input type="hidden" id="ibadah2" value={{$ibadah2}}>

                                    <div class="col-md-2">
                                        <a href="{{url('/tarikdata')}}"class="">Detail</a>
                                    </div>
                                </div>
                                    
                                <div class="row">
                                    <div>
                                        <canvas id="myChart"></canvas>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-5">
                        <div class="card">
                            <div class="card-body">
                                <div class="row">
                                   
                                    <div class="col-5">
                                        <h4 class="card-title p-3">Ulang Tahun</h4>
                                       
                                    </div>
                                    <div class="col-3">
                                        @if(Session::has('status'))
                                            <span class="error mb-2"> {{ Session::get('status') }}</span>
                                        @endif
                                    </div>
                                    <div class="col-4">
                                        <a id='connect-wa' class='btn btn-primary mb-2 smalsl' style='color:white;border-radius:.5rem'>Connect WA</a>  
                                    </div>
                                   
                                </div>
                                <div class="feed-widget">
                                    <ul class="list-style-none feed-body m-0 p-b-20">
                                    
                                    <?php $no = 1;?>
                                        @foreach($birthdays as $birthdayKey => $birthdayDate)
                                            <div class="row mb-3">
                                                <?php $explodeBirthdayDate = explode(";",$birthdayDate);
                                                    $phone = substr($explodeBirthdayDate[1],1);
                                                ?>

                                                <div class="col-6 pt-2">{{$no}}.&nbsp;&nbsp;{{$birthdayKey}}</div>
                                                <div class="col-3 pt-2">{{$explodeBirthdayDate[0]}}</div>
                                                <div class="col-3 btn-send">
                                                    <a href="{{url('/api/sendmessage',$explodeBirthdayDate[1])}}" id="phone-{{$phone}}" style="color:white;border-radius:.5rem" class="btn btn-success w-100 small">Kirim</a>
                                                </div>
                                                <?php $no += 1;?>
                                            </div>
                                        @endforeach
                                          
                                 
                                       
                                       
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div> 
                <!-- ============================================================== -->
                <!-- Sales chart -->
                <!-- ============================================================== -->
                <!-- ============================================================== -->
                <!-- Table -->
                <!-- ============================================================== -->
                <div class="row">
                    <!-- column -->
                    <div class="col-12">
                        <div class="card px-3">
                            <div class="card-body">
                                <!-- title -->
                                <div class="d-md-flex">
                                    <div>
                                        <h4 class="card-title">Absen</h4>
                                        <h5 class="card-subtitle">Detail absen</h5>
                                    </div>
                                    
                                </div>
                                <!-- title -->
                            </div>
                            <div class="table-responsive">
                                <table class="table v-middle table-striped">
                                    <thead>
                                        <tr class="bg-light">
                                            <th class="border-top-0">No</th>
                                            <th class="border-top-0">Ibadah</th>
                                            <th class="border-top-0">Tanggal</th>
                                            <th class="border-top-0">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $i = 1;?>
                                        @foreach($absens as $absen)
                                            <tr>
                                                <td>
                                                    {{$i}}
                                                </td>
                                                <td>{{$absen->jenis}}</td>
                                                <td>
                                                    {{$absen->tanggal}}
                                                </td>
                                                <td><a href="{{url('/absenlist',[$absen->jenis,$absen->tanggal])}}" class="btn btn-primary">Detail</a></td>
                                               
                                            </tr>
                                            <?php $i++?>
                                        @endforeach
                                        
                                    </tbody>
                                </table>
                                <div class="col-6 px-3 pt-2 pb-3">
                                    <a href="{{url('/allabsen')}}">Lihat</a>
                                </div>
                                
                            </div>
                            <div class="row">
                              
                            </div>
                        </div>
                    </div>
                </div>
                <!-- ============================================================== -->
                <!-- Table -->
                <!-- ============================================================== -->
                <!-- ============================================================== -->
                <!-- Recent comment and chats -->
                <!-- ============================================================== -->
                <div class="row">
                    
                </div>
                <!-- ============================================================== -->
                <!-- Recent comment and chats -->
                <!-- ============================================================== -->
            </div>
           
    </div>
@endsection

@section('script')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
    var tanggal = document.getElementById('tanggal').value;
    var ibadah1 = document.getElementById('ibadah1').value;
    var ibadah2 = document.getElementById('ibadah2').value;
    

    tanggal = tanggal.replace('[','');
    tanggal = tanggal.replace(']','');
    tanggal = tanggal.replace(/[^a-zA-Z0-9,:;\-.?! ]/g,"");
    var tanggalsplit = tanggal.split(',');
   

    ibadah1 = ibadah1.replace('[','');
    ibadah1 = ibadah1.replace(']','');
    var ibadah1split = ibadah1.split(',');

    ibadah2 = ibadah2.replace('[','');
    ibadah2 = ibadah2.replace(']','');
    var ibadah2split = ibadah2.split(',');

 
   
    const labels = tanggalsplit;
    const data1 = ibadah1split;
    const data2 = ibadah2split;

    const data = {
        labels: labels,
        datasets: [{
        label: 'Ibadah 1',
        backgroundColor: 'rgb(255, 99, 132)',
        borderColor: 'rgb(255, 99, 132)',
        data: data1,
        },
        {
        label: 'Ibadah 2',
        backgroundColor: 'rgb(25, 99, 132)',
        borderColor: 'rgb(25, 99, 132)',
        data: data2,
        }]
    };

    const config = {
        type: 'line',
        data: data,
        options: {}
    };

</script>

<script>
    const myChart = new Chart(
        document.getElementById('myChart'),
        config
    );
</script>

<script>
       $(document).ready(function(){
            var IDs = [];

            $('[id^="phone-"]').each(function(){
                var phone = this.id.substring(6);
                IDs.push(phone); 
            });
            console.log(IDs);
            for( i = 0 ; i < IDs.length ; i++){
                getFlag(IDs[i]);
            }

            function getFlag(phone){
                $.ajax({
                    url: "/absen/api/getwaflag",
                    datatype: "application/x-www-form-urlencoded",
                    method:"POST",
                    data:{
                        phone: phone
                    },
                    success: function(data)
                    {
                        response = JSON.parse(data);
                        if(response.success == true){
                            $("#phone-6287888088201").text("Terkirim");
                        }
                    },
                });
            }
            
     
            $.ajax({
                    url: "/absen/api/checkconnected",
                    datatype: "application/x-www-form-urlencoded",
                    method:"GET",
                    data:{
                        id: "Login"
                    },
                    success: function(data)
                    { 
                        response = JSON.parse(data);
                        if(response.success && response.data.status == "authenticated"){
                            $("#connect-wa").text("Connected");
                        }
                    },
            });

            $("#connect-wa").click(function(e){
                e.preventDefault();
                $.ajax({
                    url: "/absen/api/getqr",
                    datatype: "application/x-www-form-urlencoded",
                    method:"POST",
                    data:{
                        id: "Login"
                    },
                    success: function(data)
                    { 
                        qr = JSON.parse(data);
                        const winHtml = "<!DOCTYPE html><html><head><title>WA QR</title></head><body style='overflow:hidden'><img style='padding:0;margin:0;width:100vh;heigth:100vh;background-size:cover;background-repeat: no-repeat;' src="+qr.data.qr+"></body></html>";

                        const winUrl = URL.createObjectURL( 
                            new Blob([winHtml], { type: "text/html" })
                        );
                        const popup = window.open(winUrl,"win",`width=400,height=400,screenX=200,screenY=200`);
                    },
                });
                
            });
       });
</script>
@endsection