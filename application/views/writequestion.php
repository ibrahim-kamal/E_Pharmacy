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
	.title{
	    width: 100%;
	    height: 50px;
	    font-size: 22px;
	    padding: 0 10px;
	    margin-bottom: 10px;
	}
	.comment{
		font-size: 22px;
		resize: none;
		height: 350px;
	}
</style>
<div id="page-wrapper">
	<div class="com-form card my-4">
		<h5 class="card-header">write new question:</h5>
		<div class="card-body">
		  <div class="error">
		  	<?php if(isset($err)){
		  		echo $err;
		  	}?>	
		  </div>
		  <form enctype="multipart/form-data" id="com-form"class="addComment" method="POST" action="<?php echo base_url()."Questioncont/addQuestion";?>">
		    <div class="form-group">
		      <input value="<?php if (isset($title)): echo $title; ?><?php endif ?>" placeholder="write title" class="title" type="text" name="title">
		      <input name='img' class="inputimg" type="file" style="display:none;">
		      <img class="imgimg" title="click to change question img" src="<?php echo $img;?>" width="500" height="300">
		      <textarea placeholder="Write description" name="description" class="comment form-control" rows="5"><?php if (isset($description)): echo $description; ?><?php endif ?></textarea>

		    </div>
		    <button type="submit" class="add btn btn-primary">Add question</button>
		  </form>
		</div>
	</div>
</div>
<script>
	var imgsrc = "";
	var filesrc= "";
	$('body').on('click','.imgimg',function(){
		$('.inputimg').click();
	});
	$('body').on('change','.inputimg',function()
	{

		var input = this;
	    var url = $(this).val();
	    var ext = url.substring(url.lastIndexOf('.') + 1).toLowerCase();
	    if (input.files && input.files[0]&& (ext == "gif" || ext == "png" || ext == "jpeg" || ext == "jpg")) 
	     {

	    	var filesrc = $(this).val();
	        var reader = new FileReader();

	        reader.onload = function (e) {
	           $('.imgimg').attr('src', e.target.result);
	        }
	       reader.readAsDataURL(input.files[0]);
	    }
	    else
	    {
	      $('.imgimg').attr('src', '<?php echo $img;?>');
	    }

	});

</script>