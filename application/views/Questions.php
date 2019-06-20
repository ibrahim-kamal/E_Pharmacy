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
<style>
.container-fluid{
   width: 800px;
   	margin: 0px;
}
.info{
	display:flex;
}

.body{padding:  0px 15px;}
</style>
<?php 
if(isset($data['url']))
{
	for($i=0,$l=0;$i<count($data['url']);$i++)
		{
?>
			<div class="container-fluid">
				<div>
					<div class="title">
						<a href="<?php echo $data['url'][$i]?>"><h3><?php echo $data['title'][$i]?></h3></a>
					</div>
					<div class="info">
						<div class="img">
							<img src="<?php echo base_url()."style/images/".$data['img'][$i]?>" width="120" height="120">
						</div>
						<div class="body">	
							<div class="detials">
								<div class="time">
									<?php echo $data['time'][$i]?>
								</div>
								<div class="writer">
									<h5>write by <?php echo $data['writer'][$i]?></h5>
								</div>
							</div>
							<div class="desc">
								<h4><?php echo $data['subject'][$i]?></h4>
							</div>
						</div>
					</div>
				</div>
			</div>
<?php 
		}
}
?>