<!DOCTYPE html>
<html lang="en">
<head>
	<title>Login V2</title>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
<!--===============================================================================================-->	
	<link rel="icon" type="image/png" href="<?php echo base_url()?>style/images/icons/favicon.ico"/>
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="<?php echo base_url()?>style/vendor/bootstrap/css/bootstrap.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="<?php echo base_url()?>style/fonts/font-awesome-4.7.0/css/font-awesome.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="<?php echo base_url()?>style/fonts/iconic/css/material-design-iconic-font.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="<?php echo base_url()?>style/vendor/animate/animate.css">
<!--===============================================================================================-->	
	<link rel="stylesheet" type="text/css" href="<?php echo base_url()?>style/vendor/css-hamburgers/hamburgers.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="<?php echo base_url()?>style/vendor/animsition/css/animsition.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="<?php echo base_url()?>style/vendor/select2/select2.min.css">
<!--===============================================================================================-->	
	<link rel="stylesheet" type="text/css" href="<?php echo base_url()?>style/vendor/daterangepicker/daterangepicker.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="<?php echo base_url()?>style/css/util.css">
	<link rel="stylesheet" type="text/css" href="<?php echo base_url()?>style/css/main.css">
	<link rel="stylesheet" href="<?php echo base_url()?>style/css/login.css">
<!--===============================================================================================-->
</head>
<body>
	
	<div class="limiter">
		<div class="container-login100">
			<div class="wrap-login100">
				<form action="<?php echo base_url()?>/AccountCont/login" method="POST" class="login100-form validate-form">
					<span class="login100-form-title p-b-26">
						Welcome
					</span>
					<span class="login100-form-title p-b-48">
						<i class="zmdi zmdi-font"></i>
					</span>
					

					<?php if(isset($ErrorEmail)){?>		
						<div class="EmailError">
							<span>
								<?php echo $ErrorEmail;?>
							</span>
						</div>
					<?php }?>
					<div class="EmailError"></div>	
					<div class="wrap-input100 validate-input" data-validate = "Valid email is: a@b.c">
						<input class="input100" type="text" name="Email" value="<?php if(isset($Email)) echo $Email;?>">
						<span class="focus-input100" data-placeholder="Email"></span>
					</div>

					<div class="PassError"></div>	
					<?php if(isset($Errorpass)){?>
						<div class="PassError">
							<span>
								<?php echo $Errorpass;?>
							</span>
						</div>
					<?php }?>

					<div class="wrap-input100 validate-input" data-validate="Enter password">
						<span class="btn-show-pass">
							<i class="zmdi zmdi-eye"></i>
						</span>
						<input class="input100" type="password" name="pass">
						<span class="focus-input100" data-placeholder="Password"></span>
					</div>

					<div class="container-login100-form-btn">
						<div class="wrap-login100-form-btn">
							<div class="login100-form-bgbtn"></div>
							<button class="login100-form-btn">
								Login
							</button>
						</div>
					</div>

					<div class="text-center p-t-70">
						<span class="txt1">
							forget password? 
						</span>

						<a class="txt2" href="#">
							Click Here
						</a>
					</div>

					<div class="text-center ">
						<span class="txt1">
							Don’t have an account?
						</span>

						<a class="txt2" href="#">
							Sign Up
						</a>
					</div>
				</form>
			</div>
		</div>
	</div>
	

	<div id="dropDownSelect1"></div>
	
<!--===============================================================================================-->
	<script src="<?php echo base_url()?>style/vendor/jquery/jquery-3.2.1.min.js"></script>
<!--===============================================================================================-->
	<script src="<?php echo base_url()?>style/vendor/animsition/js/animsition.min.js"></script>
<!--===============================================================================================-->
	<script src="<?php echo base_url()?>style/vendor/bootstrap/js/popper.js"></script>
	<script src="<?php echo base_url()?>style/vendor/bootstrap/js/bootstrap.min.js"></script>
<!--===============================================================================================-->
	<script src="<?php echo base_url()?>style/vendor/select2/select2.min.js"></script>
<!--===============================================================================================-->
	<script src="<?php echo base_url()?>style/vendor/daterangepicker/moment.min.js"></script>
	<script src="<?php echo base_url()?>style/vendor/daterangepicker/daterangepicker.js"></script>
<!--===============================================================================================-->
	<script src="<?php echo base_url()?>style/vendor/countdowntime/countdowntime.js"></script>
<!--===============================================================================================-->
	<script src="<?php echo base_url()?>style/js/main.js"></script>
	<?php if(isset($Email)){?>
		<script>
			$(document).ready(function(){
				console.log($('.input100[name="Email"]').val());
				$('.input100[name="Email"]').val();
			});
		</script>				
	<?php }?>
	<script>

		$(document).ready(function(){

			$('.login100-form-btn').click(function (e){
				e.preventDefault();
				 var email = $('.input100[name="Email"]').val();
				 var pass = $('.input100[name="pass"]').val();
				 var form = $('.validate-form');
				 $.ajax({

                    url: "<?php echo base_url().'Accountcont/AjaxLoginValidation'?>",

                    type: "POST",

                    data: {Email:email,pass:pass},

                    success: function (vailitation)
                    {
                    	console.log(vailitation);
                    	if(vailitation == "true")
                    	{
                    		console.log(form);
                    		form.submit();
                    	}
                    	else
                    	{
                    		errormessage = vailitation.split("|");
                    		$('.EmailError').html(errormessage[0]);
                    		$('.PassError').html(errormessage[1]);
                    	}

                    }

                });
				
			});
		});
		
		/*
			
			

		*/
	</script>

</body>
</html>