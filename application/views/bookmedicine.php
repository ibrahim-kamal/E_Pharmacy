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
                        <th>Book</th>
                    </tr>
                </thead>
                <tbody>
                    
                    <?php if(isset($data['nameAr'])) for ($i=0; $i <count($data['nameAr']) ; $i++) { ?>
                        <tr class="gradeA">
                            <th class="medlink" data-id="<?php echo $data['medID'][$i];?>"><?php echo $data['nameAr'][$i];?></th>
                            <th class="medlink" data-id="<?php echo $data['medID'][$i];?>"><?php echo $data['nameEng'][$i];?></th>
                            <th class="comlink" data-id="<?php echo $data['AcomId'][$i];?>"><?php echo $data['MedCompanyname'][$i];?></th>
                            <?php if(!isset($data['booked'][$i])){?>
                            <th><button class="book btn btn-primary" data-id="<?php echo $data['medID'][$i].'&'.$data['comId'][$i];?>">Book</button></th>
                            <?php }?>
                            <?php if(isset($data['booked'][$i])){?>
                            <th>Is Booked</th>
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
    });
    $('body').on('click','.comlink',function(){
        var id = $(this).attr('data-id');
        location.href = "<?php echo base_url()."Accountcont/profile/"?>"+id; 
    });
    $('body').on('click',".book",function()
    {
        var element = $(this).parent();
        var id = $(this).attr('data-id');
        var link = "<?php echo base_url().'medicinebookcont/pharmacyBook'?>";

        $.ajax({

            url: link,

            type: "POST",

            data: {dataID:id},

            success: function (page)
            {
                console.log(page);
                element.removeAttr('data-book');
                element.text("Is Booked");
            }

        });
    });
</script>