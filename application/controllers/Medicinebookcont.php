<?php

class medicinebookcont extends CI_Controller {
	public function PatientBook()
	{
		
		if(isset($_POST['dataID']))
		{
			$this->load->model('security','sec');
			$this->load->model('medicinemod','medMod');
			$data = explode('&', $_POST['dataID']);
			$phrid = $this->sec->decode($data[0]);
			$medid = $this->sec->decode($data[1]);
			$comid = $this->sec->decode($data[2]);
			$order = array
			(
				'orderAccountId' =>$this->session->userdata('Account_ID'),
				'order_pharmacy_ID'=>$phrid,
				'OrderOrBook'=>0,
			);
			$Patientorder = array
			(
				'MedicineID' =>$medid, 
				'CompanyID' =>$comid
			);
			$this->medMod->order('patient',array($order,$Patientorder));

		}
	}

	public function pharmacyBook()
	{

		// SELECT `orderID`, `orderpharmacy_ID`, `ordercompany_ID`, `orderQuantity`, `OrderOrBook` FROM `pharmacymedicinequantity_order` WHERE 1
		// SELECT `pharmacy_order_ID`, `orderID`, `MedicineID` FROM `pharmacy_order` WHERE 1
		if(isset($_POST['dataID']))
		{
			$this->load->model('security','sec');
			$this->load->model('medicinemod','medMod');
			$data = explode('&', $_POST['dataID']);
			$medid = $this->sec->decode($data[0]);
			$comid = $this->sec->decode($data[1]);
			$order = array
			(
				'orderpharmacy_ID' =>intval($this->session->userdata('typesid')['PID']),
				'ordercompany_ID'  =>intval($comid),
				'OrderOrBook'=>0,
			);
			$Patientorder = array
			(
				'MedicineID' =>intval($medid), 
			);
			$this->medMod->order('pharmacy',array($order,$Patientorder));

		}
		// else{
		// 	redirect(base_url().'Errorcont');
		// }
	}

}
?>