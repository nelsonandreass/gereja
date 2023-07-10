 
<?php $__env->startSection('content'); ?> 
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
                            <?php $__empty_1 = true; $__currentLoopData = $users; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                <tr class="default-table">
                                    <td><input type="checkbox" name="user" value="<?php echo e($user->id); ?>"></td>
                                    <td><?php echo e($user->name); ?></td>
                                    <td><img src="<?php echo e(asset('/absen/storage/app/public/'.$user->foto)); ?>" class="icon" alt="<?php echo e($user->foto); ?>"></td>
                                    <td><?php echo e($user->created_at); ?></td>
                                </tr>

                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?> 
                                <tr>
                                    <td colspan="8" class="text-center">Kosong</td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                </table>
                <div class="row mt-3">
                    <div class="col-3">
                        <form action="<?php echo e(url('/publishprocess')); ?>" method="POST">
                            <?php echo csrf_field(); ?>
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

  
<?php $__env->stopSection(); ?>

<?php $__env->startSection('script'); ?>
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
<?php $__env->stopSection(); ?>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.12.1/js/bootstrap-select.js"></script>
<?php echo $__env->make('layout.layoutsuperadmin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\absen\absen\resources\views/superadmin/tempuser/publishtempuser.blade.php ENDPATH**/ ?>