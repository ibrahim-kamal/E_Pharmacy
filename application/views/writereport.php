<!-- Bootstrap Core CSS -->
<link href="<?php echo base_url()."style/"?>admin/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

<!-- MetisMenu CSS -->
<link href="<?php echo base_url()."style/"?>admin/vendor/metisMenu/metisMenu.min.css" rel="stylesheet">

<!-- Custom CSS -->
<link href="<?php echo base_url()."style/"?>admin/dist/css/sb-admin-2.css" rel="stylesheet">

<!-- Morris Charts CSS -->
<link href="<?php echo base_url()."style/"?>admin/vendor/morrisjs/morris.css" rel="stylesheet">

<!-- Custom Fonts -->
<link href="<?php echo base_url()."style/"?>admin/vendor/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
<!-- jQuery -->
<script src="<?php echo base_url()."style/"?>admin/vendor/jquery/jquery.min.js"></script>

<!-- Bootstrap Core JavaScript -->
<script src="<?php echo base_url()."style/"?>admin/vendor/bootstrap/js/bootstrap.min.js"></script>

<!-- Metis Menu Plugin JavaScript -->
<script src="<?php echo base_url()."style/"?>admin/vendor/metisMenu/metisMenu.min.js"></script>

<!-- Morris Charts JavaScript -->
<script src="<?php echo base_url()."style/"?>admin/vendor/raphael/raphael.min.js"></script>
<!-- <script src="<?php echo base_url()."style/"?>admin/vendor/morrisjs/morris.min.js"></script> -->
<!-- <script src="<?php echo base_url()."style/"?>admin/data/morris-data.js"></script> -->

<!-- Custom Theme JavaScript -->
<script src="<?php echo base_url()."style/"?>admin/dist/js/sb-admin-2.js"></script>

<!-- Metis Menu Plugin JavaScript -->
<script src="<?php echo base_url()."style/"?>admin/vendor/metisMenu/metisMenu.min.js"></script>

<!-- DataTables JavaScript -->
<script src="<?php echo base_url()."style/"?>admin/vendor/datatables/js/jquery.dataTables.min.js"></script>
<script src="<?php echo base_url()."style/"?>admin/vendor/datatables-plugins/dataTables.bootstrap.min.js"></script>
<script src="<?php echo base_url()."style/"?>admin/vendor/datatables-responsive/dataTables.responsive.js"></script>
<style>
	input.title{
	    width: 100%;
	    height: 50px;
	    font-size: 22px;
	    padding: 0 10px;
	    margin-bottom: 10px;
	}
	.subject{
		font-size: 22px;
		resize: none;
		height: 350px;
	}
	#page{
		width: 80%;
		margin: auto;
	}
</style>
<div id="page">
	<div class="com-form card my-4">
		<h5 class="card-header">create report:</h5>
		<div class="card-body">
		  <div class="error">
		  	<?php if(isset($err)){
		  		echo $err;
		  	}?>	
		  </div>
		  <form enctype="multipart/form-data" id="com-form" class="addReport">
		    <div class="form-group">
		      <input value="<?php if (isset($title)): echo $title; ?><?php endif ?>" placeholder="write title" class="title" type="text" name="title">
		      <textarea placeholder="Write description" name="description" class="subject form-control" rows="5"><?php if (isset($description)): echo $description; ?><?php endif ?></textarea>

		    </div>
		    <button type="submit" class="AddReport btn btn-primary">Report</button>
		  </form>
		</div>
	</div>
</div>
<script>
	$('body').on('submit','#com-form',function(e)
	{
		e.preventDefault();
	});
	$('body').on('click','.AddReport',function(e)
		{
			e.preventDefault();
            $ele = $(this);
            var link = "<?php echo $report_url?>" ;
			var eletitle 	= $('input.title').val();
			var elesubject 	= $('.subject').val();
			var eleError    = $('.error');
            $.ajax({
              url: link,
              type: "POST",
              data: {title:eletitle,subject:elesubject,id:"<?php echo $reportId?>"},
              success: function (result)
              {
                 console.log(result);
                 var res = result.split('|');
                 if(result.trim() == 'Error');
                 {
                 	// location.reload();
                 	eleError.html('Error is happend'); 
                 }
             	 if(res.length > 1)
                 {
                 	eleError.html(res[0]+res[1]); 
                 }
                 if(result.trim() != 'Error' && !(res.length > 1))
                 {
                 	eleError.html('report is write success');
                 	setTimeout(function()
                 	{
                 		location.href = '<?php echo base_url()?>'; 
                 	}, 3000);  
                 }
	           

              }
            });
        });
</script>