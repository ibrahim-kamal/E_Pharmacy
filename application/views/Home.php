<link rel="stylesheet" type="text/css" href="<?php echo base_url().'style/css/home.css';?>">
<div class="HomeBody">
	<div class="form">
		<div class="title">
			<a href="<?php echo base_url();?>"><span>E_P</span><span>harmacy</span></a>
		</div>
		<div class="input">
			<form class="startsearch" action="<?php echo base_url()."home/search/"?>" method="get">
				<input type="text" class="search" name="word">
			</form>
		</div>
		<div class="ShowResult">
			<button type="button" class="btnsearch btn btn-light">search</button>
		</div>
	</div>
</div>

<!-- jQuery -->
<script src="<?php echo base_url()."style/"?>admin/vendor/jquery/jquery.min.js"></script>
<script src="<?php echo base_url().'style/js/home.js';?>"></script>