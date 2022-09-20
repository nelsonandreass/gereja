@extends('layout.layoutsuperadmin')
 
@section('content') 
    <div class="page-wrapper">
        <div class="container-fluid">
           
            <div class="card p-3">  
                <table class="table table-striped w-auto small">
                        <thead>
                            <th></th>
                            <th>Nama</th>
                            <th>Foto</th>
                            <th>Tanggal Masuk</th>
                        </thead>
                        <tbody id="body-table">
                            @foreach($users as $user)
                                <tr class="default-table">
                                    <td><input type="checkbox" name="user" value="{{$user->id}}"></td>
                                    <td>{{$user->name}}</td>
                                    <td><img src="{{asset('/absen/storage/app/public/'.$user->foto)}}" class="icon" alt="{{$user->foto}}"></td>
                                    <td>{{$user->created_at}}</td>
                                </tr>
                            @endforeach
                        </tbody>
                </table>
                <div class="row mt-3">
                    <div class="col-3">
                        <form action="{{url('/publishprocess')}}" method="POST">
                            @csrf
                            <input type="hidden" id="id" name="id">
                            <button  id="publish" class="btn btn-primary">Publish</button>
                        </form>
                    </div>
                    <div class="col-4"></div>
                    <div class="col-4"></div>
                </div>

            </div>
        </div>
    </div>

  
@endsection

@section('script')
    <script>

        $(document).ready(function(){
            $("#publish").click(function(e) {
               
                var ids = [];
                $.each($("input[name='user']:checked"), function() {
                    ids.push($(this).val());
                });
                $('#id').val(ids);
                // alert("Your preferred programming language is: " + ids.join(", "));
            });
        });
    </script>
@endsection
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.12.1/js/bootstrap-select.js"></script>