 
<?php $__env->startSection('content'); ?> 
    <div class="page-wrapper">
        <div class="container-fluid">
            
            <div class="card p-3">  
                <div class="row mb-3">
                    <div class="col-4"></div>
                    <div class="col-5"></div>
                    <div class="col-3"><a href="<?php echo e(url('/publish')); ?>" class="btn btn-primary">Publish</a></div>
                </div>
                <table class="table table-striped w-auto small">
                            <thead>
                                <th>No</th>
                                <th>Nama</th>
                                <th>Panggilan</th>
                                <th>No Telepon</th>
                                <th>Alamat</th>
                                <th>Foto</th>
                                <th>Tanggal Masuk</th>
                                <th>Action</th>
                            </thead>
                            <tbody id="body-table">

                                <?php $i = 1; ?>
                                <?php $__currentLoopData = $users; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <tr class="default-table">
                                        <td><?php echo e($i); ?></td>
                                        <td><?php echo e($user->name); ?></td>
                                        <td><?php echo e($user->nama_panggilan); ?></td>
                                        <td><?php echo e($user->nomor_telepon); ?></td>
                                        <td><?php echo e($user->alamat); ?></td>>
                                        <td><img src="<?php echo e(asset('/absen/storage/app/public/'.$user->foto)); ?>" class="icon" alt="<?php echo e($user->foto); ?>"></td>
                                        <td><?php echo e($user->created_at); ?></td>
                                        <td>
                                            <a href="<?php echo e(route('tempuser.show', $user->id)); ?>" class="btn btn-primary mb-2">Tetap</a>
                                            
                                            <form action="<?php echo e(route('tempuser.destroy' , $user->id)); ?>" method="post">
                                                <?php echo method_field('DELETE'); ?>    
                                                <?php echo csrf_field(); ?>
                                                <button class="btn btn-danger w-100" style="color:white;border-radius:.5rem">Delete</button>
                                            </form>
                                            
                                            <!-- <a href="<?php echo e(route('tempuser.destroy', $user->id)); ?>" class="btn btn-danger w-100 mt-1" style="color:white;border-radius:.5rem">Delete</a> -->

                                        </td>
                                    </tr>
                                    <?php $i += 1; ?>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </tbody>
                </table>
            </div>
        </div>
    </div>

  
<?php $__env->stopSection(); ?>

<?php $__env->startSection('script'); ?>
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
                                if(data[i].foto == null){
                                    var photo = "";
                                }
                                else{
                                    var photo = '/absen/absen/storage/app/public/'+data[i].foto.split(" ").join('%20');

                                }
                                $('#body-table').append('<tr class="row-table"><td>'+(i+1)+'</td><td>'+data[i].name+'</td><td>'+(data[i].nama_panggilan === null ? "":data[i].nama_panggilan)+'</td><td>'+data[i].nomor_telepon+'</td><td>'+data[i].alamat+'</td><td>'+data[i].kartu+'</td><td><img class="icon" src='+photo+'></td><td><a class="btn btn-primary" href=/absen/showjemaat/'+data[i].id+'>Edit</a></td></tr>');
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
<?php echo $__env->make('layout.layoutsuperadmin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\absen\absen\resources\views/superadmin/tempuser/tempuser.blade.php ENDPATH**/ ?>