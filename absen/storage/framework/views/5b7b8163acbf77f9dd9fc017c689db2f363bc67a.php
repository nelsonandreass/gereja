<?php $__env->startSection('content'); ?>
   
    <div class="page-wrapper ">
        <div class="container-fluid" id="container-fluid">
           
            <center>
                <div class="row">&nbsp;</div>
                <div class="row">&nbsp;</div>
                <div class="row">&nbsp;</div>
                   <form action="" class="col-5" method="POST" id="option">
                        <?php echo csrf_field(); ?>
                        <label for="" class="text-center">Jenis Ibadah</label>
                        <select name="jenis" id="option-ibadah" class="form-control" onchange="change()">
                            <option value="default" style="color: #DBDBDB">Pilih jenis ibadah...</option>    
                            <option value="ibadah1">Ibadah 1</option>
                            <option value="ibadah2">Ibadah 2</option>
                            <option value="bic">BIC</option>
                            <option value="youth">Youth</option>
                        </select>
                        <button class="btn btn-primary mt-3" id="btn">Lanjutkan</button>
                   </form>
                    <?php
                        $tanggal;
                    ?>
                    <input type="hidden" id="tanggal" value='<?php echo e($tanggal); ?>'>
                   <center id="absen" style="display:none;">
                        <div class="row">
                            <div class="col-10">&nbsp;</div>
                            <div class="col-2">
                                <a id="url" >Selesai</a>
                            </div>
                        </div>
                        <div class="row">
                            <center>
                                <h2 id="jenis" class="mb-2 font-weight-bold" style="display:none;"></h2>
                            </center>
                            <center>
                                <h4 id="greeting" class="mt-2" style="display:none;"></h4>
                            </center>
                        </div>
                        <div class="row">&nbsp;</div>
                        <div class="row">&nbsp;</div>
                        <div class="row">&nbsp;</div>

                        <div class="row">
                            <div class="col-4"></div>
                            <div class="col-4">
                                <img class="col-12 no-absen" style="width: 85%" src="<?php echo e(asset('/assets/img/user-black.png')); ?>" id="foto-jemaat" alt="">
                            </div>
                            <div class="col-4"></div>
                            
                        </div>
                        <div class="row mt-3">
                            <div class="col-4"></div>
                            <div class="col-4">
                                <input type="hidden" name="jenis" id="jenis" value="">
                                <input type="text" class="form-control"  id="userid" name="absen">
                            </div>
                            <div class="col-4"></div>
                            
                        </div>
                        <button class="btn btn-primary" id="btn-absen" style="display:none;">Absen</button>
                </center>
                <div class="row">&nbsp;</div>
                <div class="row">&nbsp;</div> <div class="row">&nbsp;</div>
                <div class="row">&nbsp;</div> <div class="row">&nbsp;</div>
                <div class="row">&nbsp;</div> <div class="row">&nbsp;</div>
                <div class="row">&nbsp;</div>
            </center>
        </div>
    </div>
    <script> 
        
        
        function change(){
            var jenisibadah = $("#option-ibadah").val();
        }
       

        $(document).ready(function(){
           

            $("#btn").click(function(e){
                e.preventDefault();
                var jenisibadah = $("#option-ibadah").val();
                var tanggal = $("#tanggal").val();
                var string = "/absen/selesai/"+jenisibadah+"/"+tanggal;
              
                var url = $("#url").attr('href',string);
                if(jenisibadah != 'default'){
                    $("#option").hide();
                    $("#absen").show();
                    $("#userid").focus();
                    $("#jenis").show();
                    if(jenisibadah == 'ibadah1'){
                        $("#jenis").text("Ibadah 1");
                    }
                    else if(jenisibadah == "ibadah2"){
                        $("#jenis").text("Ibadah 2");
                    }
                    else if(jenisibadah == "bic"){
                        $("#jenis").text("BIC");
                    }
                    else if(jenisibadah == "youth"){
                        $("#jenis").text("Youth");
                    }
                }
                else{
                    alert("Pilih jenis ibadah");
                }
            });

            $("#userid").on('input',function(e){
                e.preventDefault();
		        var temp = $("#userid").val();
                var userid = temp.substring(0,10);
                if(userid.length >= 7){
                    var http = new XMLHttpRequest();
                    var url = '/absen/absenprocess';
                    var params = 'user_id='+userid+'&jenis='+$("#option-ibadah").val()+'&_token=<?php echo e(csrf_token()); ?>';
                    http.open('POST', url, true);
                    http.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
                    http.send(params);
                    http.responseType = 'text';
                    http.onreadystatechange = function() {
                        if (this.readyState == 4 && this.status == 200) {
                            //Call a function when the state changes.'
                            var data = JSON.parse(http.responseText);
                            if(data.error_code == '0000'){
                                $("#userid").val("");
                                $("#userid").focus();
                                var foto = '/absen/absen/storage/app/public/'+data.foto;
                                $("#foto-jemaat").attr("src",foto);
                                $("#greeting").text("Selamat Beribadah " + data.name);
                                $("#greeting").show();
                                setInterval(function() {
                                    var foto = '/absen/assets/img/user-black.png';
                                    $("#foto-jemaat").attr("src",foto);
                                    $("#greeting").hide();
                                }, 9000);
                                
                            }
                            else if(data.error_code != '0000'){
                                $("#userid").val("");
                                $("#userid").focus();
                                $("#greeting").text(data.greet);
                                $("#greeting").show();
                                setInterval(function(){
                                    $("#greeting").hide();
                                }, 5000);
                            }
                        }
                       
                      
                    }
                }
            });
          
        });

        function swapImage(){

        }
       
    </script>
<?php $__env->stopSection(); ?>


<?php echo $__env->make('layout.layoutsuperadmin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\absen\absen\resources\views/superadmin/ibadah.blade.php ENDPATH**/ ?>