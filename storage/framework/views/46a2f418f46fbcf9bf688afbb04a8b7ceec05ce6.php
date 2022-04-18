<?php $__env->startSection('content'); ?>
    <div class="page-wrapper">
        <div class="container-fluid">
        
            <form action="<?php echo e(url('/update/jemaat')); ?>" method="post" enctype="multipart/form-data">
            <?php echo csrf_field(); ?>
                <input type="hidden" value="<?php echo e($datas->id); ?>" name="id">
                <div class="form-group row">
                    <label for="" class="col-sm-2 col-form-label">Nama</label>
                    <div class="col-sm-10">
                    <input type="text" readonly class="form-control" name="name" value="<?php echo e($datas->name); ?>">
                    </div>
                </div>
                <div class="form-group row">
                    <label for="" class="col-sm-2 col-form-label">Jenis Kelamin</label>
                    <div class="col-sm-10">
                    <input type="text" readonly class="form-control" name="jenis_kelamin" value="<?php echo e($datas->jenis_kelamin); ?>">
                    </div>
                </div>
                <div class="form-group row">
                    <label for="" class="col-sm-2 col-form-label">Status Pernikahan</label>
                    <div class="col-sm-10">
                    <input type="text"  class="form-control" name="status_pernikahan" value="<?php echo e($datas->status_pernikahan); ?>">
                    </div>
                </div>
                <div class="form-group row">
                    <label for="" class="col-sm-2 col-form-label">Tempat Lahir</label>
                    <div class="col-sm-10">
                    <input type="text" class="form-control" value="<?php echo e($datas->tempat_lahir); ?>" name="tempatlahir">
                    </div>
                </div>
                <div class="form-group row">
                    <label for="" class="col-sm-2 col-form-label">Tanggal Lahir</label>
                    <div class="col-sm-10">
                    <input type="date" class="form-control" value="<?php echo e($datas->tanggal_lahir); ?>" name="tgllahir">
                    </div>
                </div>
                <div class="form-group row">
                    <label for="" class="col-sm-2 col-form-label">Nomor Telepon</label>
                    <div class="col-sm-10">
                    <input type="text"  class="form-control" name="telepon"  value="<?php echo e($datas->nomor_telepon); ?>">
                    </div>
                </div> 
                <div class="form-group row">
                    <label for="" class="col-sm-2 col-form-label">E-mail</label>
                    <div class="col-sm-10">
                    <input type="text"  class="form-control" name="email"  value="<?php echo e($datas->email); ?>">
                    </div>
                </div>
                <div class="form-group row">
                    <label for="" class="col-sm-2 col-form-label">Alamat</label>
                    <div class="col-sm-10">
                    <input type="text" class="form-control" name="alamat"  value="<?php echo e($datas->alamat); ?>">
                    </div>
                </div>
                <div class="form-group row">
                    <label for="" class="col-sm-2 col-form-label">Nomor Kartu</label>
                    <div class="col-sm-10">
                    <input type="text" class="form-control" name="nokartu"  value="<?php echo e($datas->kartu); ?>">
                    </div>
                </div>
                <?php    

                    if(is_null($datas->foto)){
                        echo ('
                        <div class="form-group row">
                            <label for="" class="col-sm-2 col-form-label">Foto</label>
                            <div class="col-sm-10">
                            <input type="file" class="form-control" name="foto">
                            </div>
                        </div>
                        ');
                      

                    }
                    

                ?>
                <div class="form-group row" style="">
                    <label for="" class="col-sm-2 col-form-label" style="<?php if(!is_null($datas->foto ) ?  print('display: block;') : print('display: none;') )?>">Foto</label>
                    <div class="col-sm-10 h-50">
                        <img class="col-12 no-absen " style="width: 15%;<?php if(!is_null($datas->foto ) ?  print('display: block;') : print('display: none;') )?>" src="<?php echo e(asset('storage/'.$datas->foto)); ?>" id="foto-jemaat" alt="<?php echo e($datas->foto); ?>">

                    </div>
                </div>
                <div class="row">
                    <center>
                        <div class="col-4">
                            <button class="btn btn-primary">Simpan</button>
                        </div>
                    </center>
                </div>
            </form>
                           
          
        </div>
    </div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layout.layoutsuperadmin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\absen\resources\views/superadmin/showjemaat.blade.php ENDPATH**/ ?>