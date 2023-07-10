 
<?php $__env->startSection('content'); ?> 
    <div class="page-wrapper">
        <div class="container-fluid">
            <div class="card p-3">  
            <h1 class="text-center mb-3">Selamat Datang di GPdI Sahabat Allah</h1>

                <div class="row justify-content-center mt-3">
                    <?php $__currentLoopData = $users; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class="col-3 mb-3">
                            <div class="row mb-3">
                                <img src="<?php echo e(asset('/absen/storage/app/public/'.$user->foto)); ?>" class="mx-auto" style="height:50vh !important; width:100% !important; max-height: 50vh !important;max-width: 100% !important;" alt="<?php echo e($user->foto); ?>">
                            </div>
                            <div class="row">
                                <span class="text-center"><?php echo e($user->name); ?></span>
                            </div>
                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
               
            </div>
        </div>
    </div>

  
<?php $__env->stopSection(); ?>



<?php echo $__env->make('layout.layoutsuperadmin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\absen\absen\resources\views/superadmin/tempuser/publishtempuserlayout.blade.php ENDPATH**/ ?>