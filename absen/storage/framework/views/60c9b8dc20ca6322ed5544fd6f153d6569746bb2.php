 
<?php $__env->startSection('content'); ?> 
    <div class="page-wrapper">
        <div class="container-fluid">
           
            <div class="card p-3 ">  
                    <div class="row mb-3" >
                        <div class="col-3">
                            <a href="<?php echo e(route('komseldetail.create',$komsel_id)); ?>" class="btn btn-secondary ml-auto"><span class="mdi mdi-account-multiple-plus"> Tambah Member</span></a>
                        </div>
                        <div class="col-6">&nbsp;</div>
                        
                    </div>

                <div class="table-responsive">
                    <table class="table table-striped ">
                            <thead>
                                <th>No</th>
                                <th>Nama</th>
                                <th>Telepon</th>
                                <th>Action</th>
                            </thead>
                            <tbody id="body-table">
                                <tr>
                                    <td>1</td>
                                    <td><?php echo e($ketua->user->name); ?></td>
                                    <td><?php echo e($ketua->user->nomor_telepon); ?></td>
                                    <td style="width:10rem !important">
                                        <a href="" class="w-25 btn btn-primary">Edit</a>
                                        <a href="" class="btn btn-danger w-100 mt-1" style="color:white;border-radius:.5rem">Delete</a>
                                    </td>
                                </tr>
                                <?php $i=2; ?>
                                <?php $__currentLoopData = $members; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $member): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <tr>
                                        <td><?php echo e($i); ?></td>
                                        <td><?php echo e($member->user->name); ?></td>
                                        <td><?php echo e($member->user->nomor_telepon); ?></td>
                                        <td style="width:10rem !important">
                                            <a href="" class="btn btn-primary">Edit</a>
                                            <a href="" class="btn btn-danger w-100 mt-1" style="color:white;border-radius:.5rem">Delete</a>
                                        </td>
                                    </tr>
                                    <?php $i++; ?>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

  
<?php $__env->stopSection(); ?>


<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.12.1/js/bootstrap-select.js"></script>
<?php echo $__env->make('layout.layoutsuperadmin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\absen\absen\resources\views/superadmin/komsel/komseldetail.blade.php ENDPATH**/ ?>