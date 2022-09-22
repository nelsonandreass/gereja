@extends('layout.layoutsuperadmin')
 
@section('content') 
    <div class="page-wrapper">
        <div class="container-fluid">
           
            <div class="card p-3 ">  
                    <div class="row mb-3" >
                        <div class="col-2">
                            
                        </div>
                        <div class="col-6">&nbsp;</div>
                        
                    </div>

                    <form method="post" action="{{route('komseldetail.store')}}">
                        @csrf
                        <div class="row">
                            <div class="col-lg-12">
                                <div id="inputFormRow">
                                    <div class="input-group mb-3">
                                        <select name="title[]" id="" class="form-select">
                                            <option value="">--Pilih--</option>
                                            @foreach($users as $user)
                                                <option value="{{$user->id}}">{{$user->name}}</option>
                                            @endforeach
                                        </select>
                                        <!-- <input type="text" name="title[]" class="form-control m-input" placeholder="Enter title" autocomplete="off"> -->
                                        <div class="input-group-append">
                                            <button id="removeRow" type="button" class="btn btn-danger" style="color:white; border-radius:.5rem;">Hapus</button>
                                        </div>
                                    </div>
                                </div>

                                <div id="newRow"></div>
                                <span id="addRow" type="button" class="btn btn-info" style="color:white; border-radius:.5rem;">Add Row</span>
                            </div>
                        </div>
                        <input type="hidden" name="komsel_id" value="{{$komsel_id}}">
                        <input type="hidden" id="id" name="ids">
                        <div class="row mt-3">
                            <div class="col-2">
                                <button id="simpan" class="btn btn-primary">Simpan</button>
                            </div>
                        </div>
                    </form>


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
        html += '<option value="{{$user->id}}">{{$user->name}}</option>';
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
</script>
@endsection
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.12.1/js/bootstrap-select.js"></script>