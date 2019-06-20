<link rel="stylesheet" type="text/css" href="<?php echo base_url()."style/css/body.css"?>">
<div id="page-wrapper">  
    <div class="panel panel-default">
        <div class="panel-heading">
            Medicine
        </div>
        <!-- /.panel-heading -->
        <div class="panel-body">
            <table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example">
                <thead>
                    <tr>
                        <th>الاسم</th>
                        <th>name</th>
                        <th>Company Name</th>
                        <th>Request</th>
                        <?php if(isset($ispharmacy)){ ?>
                            <th>quantity</th>
                            <th>price</th>
                        <?php }?>
                        <?php if(isset($iscompany)){ ?>
                            <th>quantity</th>
                            <th>price</th>
                        <?php }?>
                    </tr>
                </thead>
                <tbody>
                    
                    <?php if(isset($data['nameAr'])) for ($i=0; $i <count($data['nameAr']) ; $i++) { ?>
                        <tr class="gradeA">
                            <th class="medlink" data-id="<?php echo $data['medID'][$i];?>"><?php echo $data['nameAr'][$i];?></th>
                            <th class="medlink" data-id="<?php echo $data['medID'][$i];?>"><?php echo $data['nameEng'][$i];?></th>
                            <th class="comlink"><?php echo $data['MedCompanyname'][$i];?></th>
                            <th><?php echo $data['req'][$i];?></th>
                            <?php if(isset($ispharmacy)){ ?>
                                <th><?php echo $data['quantity'][$i];?></th>
                                <th><?php echo $data['price'][$i];?></th>
                            <?php }?>
                            <?php if(isset($iscompany)){ ?>
                                <th><?php echo $data['quantity'][$i];?></th>
                                <th><?php echo $data['price'][$i];?></th>
                            <?php }?>
                        </tr> 
                    <?php }?>
                    
                </tbody>
            </table>
            <!-- /.table-responsive -->  
        </div>

        <!-- /.panel-body -->
    </div>

    <!-- /.row -->
</div>
<script>
    $('body').on('click','.medlink',function(){
        var id = $(this).attr('data-id');
        location.href = "<?php echo base_url()."medicinecont/medicine/"?>"+id; 
    })
</script>