<style>
	.Mycontainer{
		width: 65%
	}
</style>
<div class="container Mycontainer">
	<?php foreach ($data['PID'] as $key => $value) {?> 
	  <h2><a href="<?php echo $data['PAID'][$key]?>"><?php echo $data['Pname'][$key]?></a></h2>           
	  <table class="table table-bordered">
	    <thead>
	      <tr>
	        <th>Medicine Name</th>
	        <th>Company name</th>
	        <th>Quanitity</th>
	      </tr>
	    </thead>
	    <tbody>
	    <?php foreach ($data[$key]['AID'] as $id => $value) { ?>
	      <tr>
	        <td><a href="<?php echo $data[$key]['MID'][$id]?>"><?php echo $data[$key]['MName'][$id]?></a></td>
	        <td><a href="<?php echo $data[$key]['CAID'][$id]?>"><?php echo $data[$key]['Cname'][$id]?></a></td>
	        <td><input Med-id='<?php echo $data[$key]['QMID'][$id]?>' type="number" name="Quanitity" value="0" min="0"></td>
	      </tr>
  		<?php }?>
	    </tbody>
	  </table>
	  <button class="orderMed" data-id="<?php echo $data['OID'][$key]?>">order</button>
  <?php }?>
</div>

<script>
    $('.orderMed').click(function(){
    	data = {};
    	stop = false;
    	var button_order = $(this);
    	var t = $(this).prev('table');
    	var h2 = t.prev('h2');
    	console.log(t);
    	console.log(h2);
    	var ele   = $(this).prev('table').find('tbody')
    	var table = ele.find('tr');
    	for(var i = 1;i<=table.length;i++){
    		var Med_id = ele.find('tr:nth-of-type('+i+')').find('td:last-of-type').find('input').attr('Med-id'); 
    		var Med_Q  = ele.find('tr:nth-of-type('+i+')').find('td:last-of-type').find('input').val();
    		if(Med_Q < 0){
    			alert('Quanitity must be 0 or more');
    			stop = true;
    		}
    		data[Med_id] = Med_Q;
    	}
    	if(!stop)
    	{
	    	data = JSON.stringify(data);
	    	// console.log(data);
	        var OrderId = $(this).attr('data-id');
	        var link = "<?php echo base_url().'medicineordercont/setPatientOrder/'?>";
	        $.ajax({

	            url: link,

	            type: "POST",

	            data: {Quanitity:data,OrderId:OrderId},

	            success: function (page)
	            {
	                if(page.trim() == 'REERROR'){
	                	location.reload();
	                }
	                else if(page.trim() == 'ERROR'){
	                	alert('Quanitity must be number');
	                }
	                else if(page.trim() == ''){
	                	t.remove();
						h2.remove();
						button_order.remove();
	                }
	            }

	        });
	    }
    });
</script>