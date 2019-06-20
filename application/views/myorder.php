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
	        <td><?php echo $data[$key]['Quantity'][$id]?></td>
	      </tr>
  		<?php }?>
	    </tbody>
	  </table>
  <?php }?>
</div>
