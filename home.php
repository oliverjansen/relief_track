<?php include 'db_connect.php' ?>

<?php 

if(!isset($_SESSION['login_id']))
  header('location:login.php');

?>
<style>
    #preview{
       width:500px;
       height: 500px;
   
    }
</style>
    <div>
       
    </div>
    
    
<script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
<script src="https://rawgit.com/schmich/instascan-builds/master/instascan.min.js" rel="nofollow"></script>
<script type="text/javascript">


</script>


<style>
   span.float-right.summary_icon {
    font-size: 3rem;
    position: absolute;
    right: 1rem;
    color: #ffffff96;
}
</style>
<div class="containe-fluid">
    <div class="row">
        <div class="text-center">
        <video id="preview" ></video>
        </div>
    </div>
			<div class="col-lg-12" >
    			<div class="card" style="width:900px; margin-left:auto;margin-right:auto">
    				<div class="card-body">
    				<!-- <?php echo "Welcome back ". $_SESSION['login_name']."!"  ?> -->
    					<hr>	

                        <div class="row">
                            <div class="col-sm-8 offset-2">
                                <div class="container-fluid">
                                    <form action="" id="manage-records">
                                    <input type="hidden" name="id" value="<?php echo isset($id) ? $id :'' ?>">
                                    <div class="form-group">
                                        <label for="" class="control-label">Tracking ID</label>
                                        <input type="number" class="form-control" id="tracking_id" name="tracking_id"  value="<?php echo isset($tracking_id) ? $tracking_id :'' ?>" required autocomplete="off">
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <button class="btn btn-sm btn-primary btn-sm col-sm-2 btn-block float-right mb-5" type="button" id="check">Check</button>
                                        </div>
                                    </div>

                                     <div id="details" <?php echo isset($id) ? "style='display:block'" : 'style="display:none"' ?>>
                                 
                                        <p><b>Address:</b> <span id="address"><?php echo isset($id) ? $caddress : ''?></span>,
                                        <span id="street"><?php echo isset($id) ? $street : ''?></span>,
                                       <span id="baranggay"><?php echo isset($id) ? $baranggay : ''?></span>,
                                       <span id="city"><?php echo isset($id) ? $city : ''?></span>,

                                       <span id="state"><?php echo isset($id) ? $state : ''?></span>,
                                        <span id="zip_code"><?php echo isset($id) ? $zip_code : ''?></span>,
                    

                                        </p>
                                        <p><b>No of Relief Pack:</b> <span id="reliefpacks"><?php echo isset($id) ? $reliefpacks :  ''?></span></p>
                                        <p>
                                            
                                            <b>Status:</b> <span id="status"><?php echo isset($id) ? $status :  ''?></span>

                                        </p>
                                        <p><b>Date Distributed:</b> <span id="date_created"><?php echo date("M d,Y h:i A",strtotime(isset($id)? $date_created : '')) ?></span></p>

                                        <!-- <div class="form-group">
                                            <label for="" class="control-label">Temperature</label>
                                            <input type="text" class="form-control" name="temperature"  value="<?php echo isset($temperature) ? $temperature :'' ?>" required>
                                        </div> -->
                                        <?php if($_SESSION['login_type'] == 1): ?>
                                        <div class="form-group">
                                            <!-- <label for="" class="control-label">Status</label> -->
                                            <!-- <select name="status" id="" class="custom-select select2">
                                                <option value=""></option>
                                        <?php 
                                            $establishment = $conn->query("SELECT * FROM records order by address asc");
                                            while($row= $establishment->fetch_assoc()):
                                        ?>
                                                <option value="<?php echo $row['address'] ?>" <?php echo isset($status) && $row['status'] == $status ? 'selected' : '' ?>><?php echo $row['status'] ?></option>
                                        <?php endwhile; ?>
                                            </select> -->
                                        </div>
                                        <?php else: ?>
                                        <input type="hidden" name="status" value="<?php echo isset($status) ? $establishment_id : $_SESSION['login_establishment_id'] ?>">
                                        <?php endif; ?>
                                <hr>
                                <!-- <div class="row">
                                    <div class="col-md-12">
                                    <button class="btn btn-sm btn-secondary btn-block col-sm-2 float-right" type="button" onlclick='reset_form()'>Cancel</button>
                                        <button class="btn btn-sm btn-primary btn-block col-sm-2 float-right mt-0 mr-2">Save</button>

                                    </div>
                                    
                                </div> -->
                                </div>
                            </form>
                        </div>
                    </div>
                </div>      			
    		</div>		


<hr>
</div>
<script>

	$('#manage-records').submit(function(e){
        e.preventDefault()
        start_load()
        $.ajax({
            url:'function.php?action=save_track',
            data: new FormData($(this)[0]),
            cache: false,
            contentType: false,
            processData: false,
            method: 'POST',
            type: 'POST',
            success:function(resp){
                resp=JSON.parse(resp)
                if(resp.status1==1){
                    alert_toast("Data successfully saved",'success')
                    setTimeout(function(){
                        location.reload()
                    },800)

                }
                
            }
        })
    })
    
    $('#tracking_id').on('keypress',function(e){
        if(e.which == 13){
            get_person()
        }
    })

    $('#check').on('click',function(e){
            get_person()
    })

    function get_person(){
            start_load()
        $.ajax({
                url:'function.php?action=get_pdetails',
                method:"POST",
                data:{tracking_id : $('#tracking_id').val()},
                success:function(resp){
                    if(resp){
                        resp = JSON.parse(resp)
                        if(resp.status1 == 1){
                            $('#name').html(resp.name)
                            $('#status').html(resp.status)
                            $('#address').html(resp.address)
                            $('#date_created').html(resp.date_created)
                            $('#street').html(resp.street)
                            $('#baranggay').html(resp.baranggay)
                            $('#city').html(resp.city)
                            $('#state').html(resp.state)
                            $('#zip_code').html(resp.zip_code)
                            $('#reliefpacks').html(resp.reliefpacks)
                            $('[name="person_id"]').val(resp.id)
                            $('#details').show()
                            end_load()

                        }else if(resp.status1 == 2){
                            alert_toast("Unknow tracking id.",'danger');
                            end_load();
                        } else{
                            alert_toast("Unknow tracking id.",'danger');
                            end_load(); 
                        }
                    }
                }
            })
    }


    

  var scanner = new Instascan.Scanner({ video: document.getElementById('preview'), scanPeriod: 5, mirror: false });

    scanner.addListener('scan',function(content){
        // alert(content);
        $('#tracking_id').val(content)
        get_person()
        //window.location.href=content;
    });

    Instascan.Camera.getCameras().then(function (cameras){
        if(cameras.length>0){
            scanner.start(cameras[0]);
            $('[name="options"]').on('change',function(){
                if($(this).val()==1){
                    if(cameras[0]!=""){
                        scanner.start(cameras[0]);
                    }else{
                        alert('No Front camera found!');
                    }
                }else if($(this).val()==2){
                    if(cameras[1]!=""){
                        scanner.start(cameras[1]);
                    }else{
                        alert('No Back camera found!');
                    }
                }
            });
        }else{
            console.error('No cameras found.');
            alert('No cameras found.');
        }
    }).catch(function(e){
        console.error(e);
        alert(e);
    });
</script>