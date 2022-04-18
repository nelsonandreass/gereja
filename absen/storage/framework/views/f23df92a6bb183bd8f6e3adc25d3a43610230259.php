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
                                <h1>
                                    <?php    
                                        $string = strtoupper($ibadah);
                                        if($string == 'IBADAH1'){
                                            $string = 'IBADAH 1';
                                        }
                                        else if($string == 'IBADAH2'){
                                            $string = 'IBADAH 2';
                                        }
                                        echo ($string);
                                    ?>
                                </h1>
                                <h2>
                                    <?php echo e($tanggal); ?>

                                </h2>
                            </div>
                            <div>
                               
                                <a href="<?php echo e(url('/selesai',[$ibadah,$tanggal])); ?>" class="btn btn-primary">Selesai</a>
                            </div>
                        </div>
                        <!-- title -->
                    </div>
                    <div class="table-responsive">
                        <table class="table v-middle table-striped">
                            <thead>
                                <tr class="bg-light">
                                    <th class="border-top-0">No</th>
                                    <th class="border-top-0">Nama</th>
                                    <th class="border-top-0">Nomor Telepon</th>
                                    <th class="border-top-0">Foto</th>
                                    <th class="border-top-0">Jam Kehadiran</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $i = 1;?>
                                <?php $__currentLoopData = $datas; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $data): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <?php $__currentLoopData = $data->users; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <tr>
                                            <td><?php echo e($i); ?></td>
                                            <td><?php echo e($user->name); ?></td>
                                            <td><?php echo e($user->nomor_telepon); ?></td>
                                            <td><img src="<?php echo e(asset('absen/storage/app/public/'.$user->foto)); ?>" class="icon" alt="<?php echo e($user->foto); ?>"></td>
                                            <td><?php echo e($data->created_at); ?></td>
                                        </tr>
                                        <?php $i++?>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                
                            </tbody>
                        </table>
                    
                        
                    </div>
                    <div class="row">
                        <div class="col-3 m-3">Jumlah Kehadiran <?php echo $i-1;?></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layout.layoutsuperadmin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\absen\absen\resources\views/superadmin/absendetail.blade.php ENDPATH**/ ?>