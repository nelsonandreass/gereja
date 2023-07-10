 
<?php $__env->startSection('content'); ?> 
    <div class="page-wrapper">
        <div class="container-fluid">

            <div class="card p-3 ">  
                <table id="sortedtable"  class="table table-striped">
                    <thead>
                        <th>No</th>
                        <th>Nama</th>
                        <th>Panggilan</th>
                        <th>No Telepon</th>
                        <th class="w-25">Alamat</th>
                        <th>Umur</th>
                        <th>Foto</th>
                    </thead>
                    <tbody id="body-table-komsel">
                        <?php $i = 1; ?>
                        <?php $__empty_1 = true; $__currentLoopData = $users; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                            <tr class="default-table">
                                <td><?php echo e($i); ?></td>
                                <td><?php echo e($user['name']); ?></td>
                                <td><?php echo e($user['nama_panggilan']); ?></td>
                                <td><?php echo e($user['nomor_telepon']); ?></td>
                                <td><?php echo e($user['alamat']); ?></td>
                                <td><?php echo e($user['umur']); ?></td>
                                <td><img src="<?php echo e(asset('/absen/storage/app/public/'.$user['foto'])); ?>" class="icon" alt="<?php echo e($user['foto']); ?>"></td>
                               
                            </tr>
                            <?php $i += 1; ?>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                            <tr class="default-table">
                                <td colspan=7 class="text-center">Kosong</td>  
                               
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

  
<?php $__env->stopSection(); ?>

<?php $__env->startSection('script'); ?>
    <script>
       
    </script>
<?php $__env->stopSection(); ?>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.12.1/js/bootstrap-select.js"></script>
<?php echo $__env->make('layout.layoutsuperadmin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\absen\absen\resources\views/superadmin/youth/index.blade.php ENDPATH**/ ?>