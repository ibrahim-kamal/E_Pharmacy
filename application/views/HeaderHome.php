<!DOCTYPE html>
<html>
<head>
	<title></title>
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

    <!-- Header Home css -->
	<link rel="stylesheet" type="text/css" href="<?php echo base_url().'style/css/headerhome.css';?>">
	<link rel="stylesheet" type="text/css" href="<?php echo base_url().'style/css/header.css';?>">

</head>
<body>
	<?php if(isset($username)){?>
		<header>
			<?php if(isset($createtitle)){?>
			<div class="title">
				<a href="<?php echo base_url();?>"><span>E_P</span><span>harmacy</span></a>
			</div>
			<?php }?>
			<div class="header">
				<div class="linkes">
					<a href="<?php echo base_url()."Settingcont"?>">
						<h4>
							<span class="glyphicon glyphicon-cog"></span> Settings
						<h4/>
					</a>
				</div>
				<div class="linkes">
					<a href="<?php echo base_url()."articlecont";?>">
						<h4>
							<span class="fa fa-newspaper-o" style="font-size: 22px;"></span> Article
						<h4/>
					</a>
				</div>
				<div class="linkes">
					<a href="<?php echo base_url()."questioncont";?>">
						<h4>
							<span class="glyphicon glyphicon-question-sign"></span> Question
						<h4/>
					</a>
				</div>
				<div class="linkes">
					<a href="<?php echo base_url()."Accountcont/logout";?>">
						<h4>
							<span class="glyphicon glyphicon-log-out"></span> LogOut
						<h4/>
					</a>
				</div>
				<div class="clear"></div>
			</div>
			<div class="clear"></div>
		</header>		
	<?php }?>
	<?php if(!isset($username)){ ?>
		<header>
			<?php if(isset($createtitle)){?>
			<div class="title">
				<a href="<?php echo base_url();?>"><span>E_P</span><span>harmacy</span></a>
			</div>
			<?php }?>
			<div class="header">
				<div class="linkes">
					<a href="<?php echo base_url()."articlecont";?>">
						<h4>
							<span class="fa fa-newspaper-o" style="font-size: 22px;"></span> Article
						<h4/>
					</a>
				</div>
				<div class="linkes">
					<a href="<?php echo base_url()."questioncont";?>">
						<h4>
							<span class="glyphicon glyphicon-question-sign"></span> Question
						<h4/>
					</a>
				</div>
				<div class="linkes">
					<a href="<?php echo base_url()."Accountcont";?>">
						<h4>
							<span class="glyphicon glyphicon-log-in"></span>  LogIn
						<h4/>
					</a>
				</div>
				<div class="clear"></div>
			</div>
			<div class="clear"></div>
		</header>
	<?php }?>
</body>
</html>