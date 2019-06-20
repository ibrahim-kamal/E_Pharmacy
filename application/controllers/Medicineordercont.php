<?php

class medicineordercont extends CI_Controller {


	public function setPatientOrder(){
		if(isset($_POST['OrderId']) && isset($_POST['Quanitity'])){
			$this->load->model('medicinemod','MedMod');
			$this->load->model('security','sec');
			$Quanitity = json_decode($_POST['Quanitity'], true);
			$i = 0;
			$orderID = $this->sec->decode($_POST['OrderId']);
			foreach ($Quanitity as $ID => $Med_Que) {
				$i ++;
			}		
			if($this->MedMod->get_count_medicine_order($orderID,$i))
			{
				echo "REERROR";
			}
			else
			{
				$stop = true;
				foreach ($Quanitity as $ID => $Med_Que) {
					if($Med_Que != 0){
						$stop = false;	
					}
				}
				if($stop){
					echo "ERROR";
				}
				else{						
					$this->MedMod->Patientorder($orderID,$Quanitity);
					echo "";	
				}	
			}

		}
		else{
			redirect(base_url().'Errorcont');
		}
	}



}
?>