 
<?php $__env->startSection('content'); ?> 
    <div class="page-wrapper">
        <div class="container-fluid">
           
            <div class="card p-3">  
                    <div class="row mb-3" >
                        <div class="col-2">
                            <a href="/absen/jemaatbaru" class="btn btn-secondary ml-auto"><span class="mdi mdi-account-multiple-plus"> Tambah Jemaat</span></a>
                        </div>
                        <div class="col-6">&nbsp;</div>
                        <div class="col-4"> 
                            <input type="input" class="form-control rounded" placeholder="Search" id="search"  autocomplete="off"/>
                        </div>
                    </div>

                <table class="table table-striped">
                        <thead>
                            <th>No</th>
                            <th>Nama</th>
                            <th>No Telepon</th>
                            <th>Alamat</th>
                            <th>No Kartu</th>
                            <th>Foto</th>
                            <th>Action</th>
                        </thead>
                        <tbody id="body-table">

                            <?php $i = 1; ?>
                            <?php $__currentLoopData = $users; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr class="default-table">
                                    <td><?php echo e($i); ?></td>
                                    <td><?php echo e($user->name); ?></td>
                                    <td><?php echo e($user->nomor_telepon); ?></td>
                                    <td><?php echo e($user->alamat); ?></td>
                                    <td><?php echo e($user->kartu); ?></td>
                                    <td><img src="<?php echo e(asset('storage/app/public/'.$user->foto)); ?>" class="icon" alt="<?php echo e($user->foto); ?>"></td>
                                    <td>
                                        <a href="<?php echo e(url('/showjemaat', $user->id)); ?>" class="btn btn-primary">Edit</a>
                                    </td>
                                </tr>
                                <?php $i += 1; ?>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </tbody>
                </table>
                <?php echo e($users->links()); ?> 
            </div>
        </div>
    </div>

    <script>

            $(document).ready(function(){
            
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
                                    $('#body-table').append('<tr class="row-table"><td>'+(i+1)+'</td><td>'+data[i].name+'</td><td>'+data[i].nomor_telepon+'</td><td>'+data[i].alamat+'</td></tr>');
                                }
                                if(data == ""){
                                    $(".default-table").show();
                                }
                        },
                    });
                    
                });
            });

    </script>
<?php $__env->stopSection(); ?>



<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.12.1/js/bootstrap-select.js"></script>

<?php echo $__env->make('layout.layoutsuperadmin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\absen\absen\resources\views/superadmin/listjemaat.blade.php ENDPATH**/ ?>