<?php $__env->startSection('content'); ?>
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

                    <form action="<?php echo e(url('/tarikdataprocess')); ?>" method="get">
                     
                        <div class="row">
                            <div class="col-6">
                                <select name="tanggal" id="tanggal" onchange="change()" class="form-control">
                                    <option value="default" style="color: #DBDBDB">Pilih Tanggal...</option>    
                                    <?php $__currentLoopData = $dates; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $date): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($date->tanggal); ?>"><?php echo e($date->tanggal); ?></option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>
                            </div>
                            <div class="col-2">
                                <button class="btn btn-primary" id='tarik'>Tarik</button>
                            </div>
                        </div>
                    </form>
                    <br>&nbsp;
                    <br>&nbsp;

                    <table class="table table-striped">
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
<?php $__env->stopSection(); ?>


<?php $__env->startSection('script'); ?>
    <script>
        var tanggal;    
        function change(){
            tanggal = $("#tanggal").val();
        }
        $(document).ready(function(){
            $("#tarik").click(function(e){
                e.preventDefault();
                var http = new XMLHttpRequest();
                var url = '/tarikdataprocess';
                var params = 'tanggal='+tanggal+'&_token=<?php echo e(csrf_token()); ?>';
                http.open('POST', url, true);
                http.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
                http.send(params);
                http.onreadystatechange = function() {
                    $(this).parents('.row-table').remove();
                    var data= JSON.parse(http.responseText);
                    for(var i = 0 ; i < data.data.length ; i++){
                        $('#body-table').append('<tr class="row-table"><td>'+(i+1)+'</td><td>'+data.data[i].name+'</td><td>'+data.data[i].nomor_telepon+'</td><td>'+data.data[i].alamat+'</td></tr>');;
                    }
                }
            });
        });
    </script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layout.layoutsuperadmin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\absen\resources\views/superadmin/tarikdata.blade.php ENDPATH**/ ?>