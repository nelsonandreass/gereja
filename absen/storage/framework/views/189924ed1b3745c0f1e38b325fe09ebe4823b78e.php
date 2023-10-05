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
                            <?php $__currentLoopData = $absens; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $absen): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr>
                                    <td>
                                        <?php echo e($i); ?>

                                    </td>
                                    <td><?php echo e($absen->jenis); ?></td>
                                    <td>
                                        <?php echo e($absen->tanggal); ?>

                                    </td>
                                    <td><a href="<?php echo e(url('/absenlist',[$absen->jenis,$absen->tanggal])); ?>" class="btn btn-primary">Detail</a></td>
                                   
                                </tr>
                                <?php $i++?>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            
                        </tbody>
                    </table>
                   
                    
                </div>
                <div class="row">
                  
                </div>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layout.layoutsuperadmin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\absen\absen\resources\views/superadmin/absen/absen.blade.php ENDPATH**/ ?>