<?php $__env->startSection('content'); ?> 
<div class="page-wrapper">
    <div class="container-fluid">
        
            <!-- <form action="<?php echo e(url('/savejemaatbaru')); ?>" method="post" enctype="multipart/form-data"> -->
            <form action="<?php echo e(route('tempuser.store')); ?>" id="form" method="POST" enctype="multipart/form-data">
            <?php echo csrf_field(); ?>
                <div class="form-group row">
                    <label for="" class="col-sm-2 col-form-label">Nama</label>
                    <div class="col-sm-10">
                    <input type="text"  class="form-control" name="name" required>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="" class="col-sm-2 col-form-label">Nama Panggilan</label>
                    <div class="col-sm-10">
                    <input type="text"  class="form-control" name="nama_panggilan" required>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="" class="col-sm-2 col-form-label">Jenis Kelamin</label>
                    <div class="col-sm-10">
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="jeniskelamin" id="jeniskelaminpria">
                            <label class="form-check-label" for="jeniskelaminpria">
                                Pria
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="jeniskelamin" id="jeniskelaminwanita">
                            <label class="form-check-label" for="jeniskelaminwanita">
                                Wanita
                            </label>
                        </div>
                    <!-- <input type="text"  class="form-control" name="jenis_kelamin" > -->
                    </div>
                </div>
                <div class="form-group row">
                    <label for="" class="col-sm-2 col-form-label">Status Pernikahan</label>
                    <div class="col-sm-10">
                    <input type="text"  class="form-control" name="status_pernikahan" >
                    </div>
                </div>
                <div class="form-group row">
                    <label for="" class="col-sm-2 col-form-label">Tempat Lahir</label>
                    <div class="col-sm-10">
                    <input type="text" class="form-control"  name="tempatlahir">
                    </div>
                </div>
                <div class="form-group row">
                    <label for="" class="col-sm-2 col-form-label">Tanggal Lahir</label>
                    <div class="col-sm-10">
                    <input type="date" class="form-control" name="tgllahir">
                    </div>
                </div>
                <div class="form-group row">
                    <label for="" class="col-sm-2 col-form-label">Nomor Telepon</label>
                    <div class="col-sm-10">
                    <input type="text"  class="form-control" name="telepon"  >
                    </div>
                </div> 
                <div class="form-group row">
                    <label for="" class="col-sm-2 col-form-label">E-mail</label>
                    <div class="col-sm-10">
                    <input type="text"  class="form-control" name="email"  >
                    </div>
                </div>
                <div class="form-group row">
                    <label for="" class="col-sm-2 col-form-label">Alamat</label>
                    <div class="col-sm-10">
                    <input type="text" class="form-control" name="alamat"  >
                    </div>
                </div>
                <div class="form-group row">
                    <label for="" class="col-sm-2 col-form-label">Kecamatan</label>
                    <div class="col-sm-10">
                    <input type="text" class="form-control" name="kecamatan"  >
                    </div>
                </div>
                <div class="form-group row">
                    <label for="" class="col-sm-2 col-form-label">Kelurahan</label>
                    <div class="col-sm-10">
                    <input type="text" class="form-control" name="kelurahan"  >
                    </div>
                </div>
                <div class="form-group row">
                    <label for="" class="col-sm-2 col-form-label">Nomor Kartu</label>
                    <div class="col-sm-10">
                    <input type="text" class="form-control" name="nokartu"  >
                    </div>
                </div>
                <div class="form-group row">
                    <label for="" class="col-sm-2 col-form-label">Foto</label>
                    <div class="col-sm-10">
                    <input type="file" class="form-control" name="foto">
                    </div>
                </div>
                      

         
                
                <div class="row">
                    <center>
                        <div class="col-4">
                            <button class="btn btn-primary" id="simpan">Simpan</button>
                        </div>
                    </center>
                </div>
            </form>
                           
          
    </div>
</div>
  
<?php $__env->stopSection(); ?>

<script type="text/javascript">
    window.addEventListener('keydown', function(e) {
        if (e.keyIdentifier == 'U+000A' || e.keyIdentifier == 'Enter' || e.keyCode == 13) {
            if (e.target.nodeName == 'INPUT' && e.target.type == 'text') {
                e.preventDefault();
                return false;
            }
        }
    }, true);
</script>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.12.1/js/bootstrap-select.js"></script>

<?php echo $__env->make('layout.layoutsuperadmin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\absen\absen\resources\views/superadmin/jemaat/jemaatbaru.blade.php ENDPATH**/ ?>