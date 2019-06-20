<meta http-equiv="content-type" content="text/html; charset=utf-8" />
<link rel="stylesheet" type="text/css" href="<?php echo base_url().'style/css/home.css';?>">
<link rel="stylesheet" type="text/css" href="<?php echo base_url().'style/css/search.css';?>">
<div class="HomeBody">
	<div class="form">
		<div class="title">
			<a href="<?php echo base_url();?>"><span>E_P</span><span>harmacy</span></a>
		</div>
		<div class="input">
			<form class="startsearch" action="<?php echo base_url()."home/search/"?>" method="get">
				<input type="text" class="search" name="word" value="<?php echo $word;?>">
			</form>
		</div>
		<div class="ShowResult">
			<button type="button" class="btnsearch btn btn-light">search</button>
		</div>
	</div>
</div>


<div class="clear"></div>
<div class="resultsearch">
	<div class="panel panel-default">
	    <div class="panel-heading">
	        Results
	    </div>
	    <!-- /.panel-heading -->
	    <div class="panel-body">
	        <table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example">
	            <thead>
	                <tr>
	                    <th>اسم الدواء</th>
	                    <th>medicine name</th>
	                    <th>الاستخدام</th>
	                    <th>uses</th>
	                    <th>price</th>
	                    <th>Pharmacy Name</th>
	                    <th>company Name</th>
	                    <?php if(($medicine_search_result['loged'])){?>
	                    <th>Book</th>
	                	<?php }?>
	                </tr>
	            </thead>
	            <tbody>
	            	<?php if(isset($medicine_search_result['Pharmacy_Name'])){?>
	            		<?php for ($i=0; $i <count($medicine_search_result['Pharmacy_Name']) ; $i++) { ?>	
		            		<tr>
			                    <th class='medlink' data-mid="<?php echo $medicine_search_result['medicine_ID'][$i]?>">
			                    	<?php echo $medicine_search_result['medicine_name_AR'][$i];?>
			                    </th>
			                    <th class='medlink' data-mid="<?php echo $medicine_search_result['medicine_ID'][$i]?>">
			                    	<?php echo $medicine_search_result['medicine_name_En'][$i];?>
			                    </th>
			                    <th><?php echo $medicine_search_result['uses_AR'][$i];?></th>
			                    <th><?php echo $medicine_search_result['uses_EN'][$i];?></th>
			                    <th><?php echo $medicine_search_result['Pmedicine_price'][$i];?></th>
			                    <th><?php echo $medicine_search_result['Pharmacy_Name'][$i];?></th>
			                    <th><?php echo $medicine_search_result['company_Name'][$i];?></th>
		                    	<?php if(($medicine_search_result['loged'])){?>
			                    <?php if($medicine_search_result['Pharmacy_state'][$i] == "online" && $medicine_search_result['Pharmacy_delevery'][$i] == 1 && !$medicine_search_result['medicinebooked'][$i]){?>
				                    <th data-book="<?php echo $medicine_search_result['Pharmacy_ID'][$i].'&'.$medicine_search_result['medicine_ID'][$i].'&'.$medicine_search_result['Quantitycompany_ID'][$i];?>">
				                    	<button  type="button" class="book btn btn-primary">book</button>
				                    </th>
			                	<?php }
			                	elseif($medicine_search_result['medicinebooked'][$i]){?>
			                		<th>Is Booked</th>
								<?php }else{?>
			                    <th>no book now</th>
			                	<?php }?>
		                		<?php }?>
		                	</tr>
						<?php }?>
	            	<?php }?>
	            </tbody>
	        </table>
	    </div>
	</div>	
</div>


<!-- jQuery -->
<script src="<?php echo base_url()."style/"?>admin/vendor/jquery/jquery.min.js"></script>

<!-- Bootstrap Core JavaScript -->
<script src="<?php echo base_url()."style/"?>admin/vendor/bootstrap/js/bootstrap.min.js"></script>

<!-- Metis Menu Plugin JavaScript -->
<script src="<?php echo base_url()."style/"?>admin/vendor/metisMenu/metisMenu.min.js"></script>

<!-- Morris Charts JavaScript -->
<script src="<?php echo base_url()."style/"?>admin/vendor/raphael/raphael.min.js"></script>
<script src="<?php echo base_url()."style/"?>admin/vendor/morrisjs/morris.min.js"></script>
<script src="<?php echo base_url()."style/"?>admin/data/morris-data.js"></script>

<!-- Custom Theme JavaScript -->
<script src="<?php echo base_url()."style/"?>admin/dist/js/sb-admin-2.js"></script>

<!-- Metis Menu Plugin JavaScript -->
<script src="<?php echo base_url()."style/"?>admin/vendor/metisMenu/metisMenu.min.js"></script>

<!-- DataTables JavaScript -->
<script src="<?php echo base_url()."style/"?>admin/vendor/datatables/js/jquery.dataTables.min.js"></script>
<script src="<?php echo base_url()."style/"?>admin/vendor/datatables-plugins/dataTables.bootstrap.min.js"></script>
<script src="<?php echo base_url()."style/"?>admin/vendor/datatables-responsive/dataTables.responsive.js"></script>
<script src="<?php echo base_url().'style/js/home.js';?>"></script>
<script>
$(document).ready(function() {
    sortdata();
});
</script>
<script>
    function sortdata()
    {
        $('#dataTables-example').DataTable();

        $('#all_user').DataTable({
            responsive: true
        });
    }
</script>
<script>
	$('body').on('click',".book",function()
	{
		var element = $(this).parent();
		var id = $(this).parent().attr('data-book');
        var link = "<?php echo base_url().'medicinebookcont/PatientBook'?>";
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
<script>
    $('body').on('click','.medlink',function(){
        var id = $(this).attr('data-mid');
        location.href = "<?php echo base_url()."medicinecont/medicine/"?>"+id; 
    })
</script>