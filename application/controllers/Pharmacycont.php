<?php

class pharmacycont extends CI_Controller {
	public function __construct(){
		parent::__construct();
		if($this->session->userdata('name')){
			$data['username'] = $this->session->userdata('name');
		}
		$data['createtitle'] = true;
		$this->load->view("HeaderHome",$data);
	}
	public function index(){
		$this->general();
	}


	public function general()
	{
		if($this->session->userdata('Account_ID'))
		{
			$this->load->model('userMod', 'usrMod');
			$data = $this->usrMod->get_user_info($this->session->userdata('Account_ID'));
			$data['ispharmacy'] = "";
			$data['myurl']	= base_url()."pharmacycont/Edit";	
			$this->load->view('setting',$data);
			$this->load->view('myprofile',$data);
		}
	}

	public function Edit(){
		if($this->session->userdata('Account_ID')){
			$this->load->model('userMod', 'usrMod');
			$data = $this->usrMod->get_user_info($this->session->userdata('Account_ID'));
			$data['ispharmacy'] = "";
			$this->load->view('setting',$data);
			$this->load->view('Edit',$data);
		}
		
	}




	public function medicine()
	{
		$this->load->model('medicinemod','MedMod');
		$type = 'pharamcy';
		$typeId=$this->session->userdata('typesid')['PID'];
		$data['data'] = $this->MedMod->Medicine($type,false,$typeId);
		$data['ispharmacy'] = "";
		$this->load->view('setting',$data);
		$this->load->view('medicine',$data);
	}


	public function RemoveMedicine(){
		if (isset($_POST['MedID'])) {
			$this->load->model('medicinemod','MedMod');
			$this->load->model('security','Sec');
			$medID = $this->Sec->decode($_POST['MedID']);
			$type = 'pharmacy';
			$typeId = $this->session->userdata('typesid')['PID'];;
			$this->MedMod->Remove($medID,$type,$typeId);
			echo 'Accept';
		}
	}

	public function changeprice(){
		if (isset($_POST['MedID'])) {
			$this->load->library('form_validation');
			$this->form_validation->set_rules('MedPrice','Price','required|numeric|greater_than[0]');
			if(!$this->form_validation->run())
			{
				echo 'error|'.form_error('MedPrice');
				return false;
			}
			$this->load->model('medicinemod','MedMod');
			$this->load->model('security','Sec');
			$medID = $this->Sec->decode($_POST['MedID']);
			$type = 'pharmacy';
			$price = $_POST['MedPrice'];
			$typeId = $this->session->userdata('typesid')['PID'];;
			$this->MedMod->changeprice($price,$medID,$type,$typeId);
			echo 'Accept';
		}
	}

	public function changequantity(){
		if (isset($_POST['MedID'])) {
			$this->load->library('form_validation');
			$this->form_validation->set_rules('MedQua','quantity','required|numeric|greater_than[0]');
			if(!$this->form_validation->run())
			{
				echo 'error|'.form_error('MedQua');
				return false;
			}
			$this->load->model('medicinemod','MedMod');
			$this->load->model('security','Sec');
			$medID = $this->Sec->decode($_POST['MedID']);
			$type = 'pharmacy';
			$Quantity = $_POST['MedQua'];
			$typeId = $this->session->userdata('typesid')['PID'];;
			$this->MedMod->changeQuantity($Quantity,$medID,$type,$typeId);
			echo 'Accept';
		}
	}


	public function changeState(){
		if(isset($_POST['State']))
		{
			$phrId = $this->session->userdata('typesid')['PID'];
			$this->load->model('pharmacyMod', 'phrMod');
			if($phrId > -1)
			{
				if($_POST['State'] == 0){
					$state = 'offline';
					$this->phrMod->state($state,$phrId);
					echo true;
				}
				else if($_POST['State'] == 1){
					$state = 'online';
					$this->phrMod->state($state,$phrId);
					echo true;
				}
				else{
					echo false;
				}
			} 
			else
			{
				echo false;
			}
			
		}
		else
		{
			echo false;
		}
	}


	public function bookmedicine()
	{
		$this->load->model('medicinemod','MedMod');
		$type = 'admin';
		$data['data'] = $this->MedMod->getallmedicine();
		$data['ispharmacy'] = "";
		$this->load->view('setting',$data);
		$this->load->view('bookmedicine',$data);
	}


	// public function Order(){
	// 	if($this->session->userdata('Account_ID')){
	// 		$role = $this->session->userdata('role');
	// 		$this->load->model('medicinemod','medMod');
	// 		if($role == 5 )
	// 		{
	// 			$data['data'] = $this->medMod->getPatientBooks($this->session->userdata('Account_ID'));
	// 			$data['ispharmacy'] = true ;
	// 			$this->load->view('setting',$data);
	// 			$this->load->view('order',$data);

	// 		}
	// 	}
	// }

	// public function myorder(){
	// 	if($this->session->userdata('Account_ID')){
	// 		$role = $this->session->userdata('role');
	// 		$this->load->model('medicinemod','medMod');
	// 		if($role == 5 )
	// 		{
	// 			$data['data'] = $this->medMod->getPatientorder($this->session->userdata('Account_ID'));
	// 			$data['ispharmacy'] = true ;
	// 			$this->load->view('setting',$data);
	// 			$this->load->view('myorder',$data);

	// 		}
	// 	}
	// }



}
?>