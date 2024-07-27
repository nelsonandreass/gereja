<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Keluarga</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link rel="stylesheet" href="{{asset('dist/css/bootstrap.css')}}">
    <link rel="stylesheet" href="{{asset('dist/css/bootstrap-grid.css')}}">
    <link rel="stylesheet" href="{{asset('dist/css/bootstrap-reboot.css')}}">
    <link rel="stylesheet" href="{{asset('dist/css/custom.css')}}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.12.0-2/css/fontawesome.min.css" />  
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.12.0-2/css/all.min.css" />  
</head>
<body>
    <div class="table-responsive">
        <table class="table table-striped" id="table-keluarga">
            <thead>
                <th>Nama</th>
                <th>Panggilan</th>
                <th class="w-25">Alamat</th>
                <th>Gender</th>
                <th>Tempat Tanggal Lahir</th>
                <th>Tanggal Baptis</th>
                <th>Pendidikan</th>
                <th>Telepon</th>
               
            </thead>
            <tbody id="table-keluarga">
                @foreach($anggotaKeluarga as $anggota)
                    <tr class="anggota-keluarga">
                        <td>{{$anggota->user->name}}</td>
                        <td>{{$anggota->user->nama_panggilan}}</td>
                        <td>{{$anggota->user->alamat}}</td>
                        <td>{{$anggota->user->jenis_kelamin}}</td>
                        <td>{{$anggota->user->tempat_lahir}} {{$anggota->user->tanggal_lahir}}</td>
                        <td>@php isset($anggota->user->tanggal_baptis) ? $anggota->user->tanggal_baptis : "" @endphp</td>
                        <td>@php isset($anggota->user->pendidikan) ? $anggota->user->pendidikan : "" @endphp</td>
                        <td>{{$anggota->user->nomor_telepon}}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.12.1/js/bootstrap-select.js"></script>
    <script>
        $(document).ready(function() {
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

            $(newWin).on("load", function() {
                newWin.focus();
                newWin.print();
                newWin.close();
            });
        });
    </script>
    
    
</body>
</html>
   

            

