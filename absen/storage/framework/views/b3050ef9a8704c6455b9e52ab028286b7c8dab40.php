 
<?php $__env->startSection('content'); ?> 
    <div class="page-wrapper">
        <div class="container-fluid">
           
            <div class="card p-3 ">  
                    <div class="row mb-3" >
                        <div class="col-2">
                            
                        </div>
                        <div class="col-6">&nbsp;</div>
                        
                    </div>

                    <form method="post" action="<?php echo e(route('komseldetail.store')); ?>">
                        <?php echo csrf_field(); ?>
                        <div class="row">
                            <div class="col-lg-12">
                                <div id="inputFormRow">
                                    <div class="input-group mb-3">
                                        <select name="title[]" id="" class="form-select">
                                            <option value="">--Pilih--</option>
                                            <?php $__currentLoopData = $users; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <option value="<?php echo e($user->id); ?>"><?php echo e($user->name); ?></option>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
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
                        <input type="hidden" name="komsel_id" value="<?php echo e($komsel_id); ?>">
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

  
<?php $__env->stopSection(); ?>

<?php $__env->startSection('script'); ?>
<script type="text/javascript">
    // add row
    

    $("#addRow").click(function () {
        var html = '';
        html += '<div id="inputFormRow">';
        html += '<div class="input-group mb-3">';
        html += '<select name="title[]" id="" class="form-select">';
        html += '<option value="">--Pilih--</option>';
        html += '<?php $__currentLoopData = $users; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>';
        html += '<option value="<?php echo e($user->id); ?>"><?php echo e($user->name); ?></option>';
        html += '<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>';
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
<?php $__env->stopSection(); ?>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.12.1/js/bootstrap-select.js"></script>
<?php echo $__env->make('layout.layoutsuperadmin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\absen\absen\resources\views/superadmin/komsel/komselmember.blade.php ENDPATH**/ ?>