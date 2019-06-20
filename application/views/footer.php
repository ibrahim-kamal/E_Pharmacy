<style>
	.change > div,.state{
		font-size: 22px;
    	font-weight: 500;
    	cursor: pointer;
	}
	.change > div{
	    padding: 1px 20px 1px 20px;
	    border: 1px solid #000;
	}
	.change{
        position: absolute;
	    top: -50px;
	    right: -1px;
	    /*background-color: #CCC;*/
	    padding: 4px;
	    margin-right: -20px;
	    margin-top: -10px;
	    
	}
	footer > div {
	    width: 80%;
	    margin: auto;
	    margin-top: 60px;
        position: relative;	
	}
	.state{
		float: right;
		margin-right: 2px
	}
	.hidden{
		display: none;
	}
</style>
<footer>
	<div>
		<div>
			<div class="state"><?php echo $state ;?></div>
		</div>
		<div class="change hidden">
			<div class="offline" value="0">
				Offline
			</div>
			<div class="online" value="1">
				Online
			</div>
		</div>
	</div>
</footer>
<script src="<?php echo base_url()."style/"?>admin/vendor/jquery/jquery.min.js"></script>
<script>

	$('.offline').click(function(){
		$('.change').addClass('hidden');
		var link = "<?php echo base_url().'pharmacycont/changeState'?>" ;
        var ele  = $('.state'); 
        $.ajax({

            url: link,

            type: "POST",

            data: {State:0},

            success: function (result)
            {
            console.log(result);      
            	if(result){
            		ele.text('Offline');	
            	}
            	else{
            		location.reload();
            	}
                
            }

        });
		
	});
	$('.online').click(function(){
		$('.change').addClass('hidden');
		var link = "<?php echo base_url().'pharmacycont/changeState'?>";
        var ele  = $('.state'); 
        $.ajax({

            url: link,

            type: "POST",

            data: {State:1},

            success: function (result)
            {
            	console.log(result);
            	if(result){
            		ele.text('Online');	
            	}
            	else{
            		location.reload();
            	}
                
            }

        });
		
	});
	$('.state').click(function(){
		if(!$('.change').hasClass('hidden'))
		{
			$('.change').addClass('hidden');
		}
		else{
			$('.change').removeClass('hidden');
		}
	});
</script>