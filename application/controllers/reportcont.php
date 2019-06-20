<?php

class reportcont extends CI_Controller {
	public function report(){
		if($this->session->userdata('name')){
			$data['username'] = $this->session->userdata('name');
		}
		$data['createtitle'] = true;
		$this->load->view("HeaderHome",$data);
		if($this->session->userdata('role')){
			$this->load->model('pharmacyMod', 'phrMod');
			$this->load->model('companyMod', 'comMod');
			$this->load->model('userMod', 'usrMod');
			$this->load->model('accontMod', 'AccMod');
			$this->load->model('security', 'sec');
			$role = $this->session->userdata('role');
			$Aid = $this->session->userdata('Account_ID');
			$Id = $this->uri->segment(3);
			if (isset($Id)) {
				$profileId = $this->sec->decode($Id);
				$profilerole = $this->AccMod->get_role($profileId);
				$data['reportId'] = $Id;
				if($profilerole !=-1)
				{
					if ($profilerole == 5) 
					{

							if ($role == 3) {
								$data['report_url'] = base_url()."reportcont/reportpahrmacyuser";
							}
					}
					else if ($profilerole == 3) 
					{
						$data['reportId']  = $this->sec->encode($this->AccMod->getPharmacyID($profileId));
							if ($role == 5) {
								$data['report_url'] = base_url()."reportcont/reportuserpahrmacy";
							}
							else if ($role == 4) {
								$data['report_url'] = base_url()."reportcont/reportcompanypahrmacy";
							}
					}

					else if ($profilerole == 4) 
					{
						$data['reportId']  = $this->sec->encode($this->AccMod->getCompanyID($profileId));
							if ($role == 3) {
								$data['report_url'] = base_url()."reportcont/reportpahrmacycompany";
							}
					}
					else{
						redirect(base_url().'Errorcont');
						return;
					}	
				}
				$this->load->view("writereport",$data);
				if($role == 3){
					$Accountid = $this->session->userdata('Account_ID');
					$data['state'] = $this->phrMod->get_pharmacy_state($Accountid); 
					$this->load->view('footer',$data);
				}
			}
			else{
				redirect(base_url().'Errorcont');
			}
			
		}
		else{
				redirect(base_url().'Errorcont');
		}
	}



	public function reportVaild()
	{
		$this->load->library('form_validation');
		$this->form_validation->set_rules('title','title','required|min_length[10]');
		$this->form_validation->set_rules('subject','subject','required|min_length[10]');
		if(!$this->form_validation->run())
		{
			echo form_error('title').'|'.form_error('subject');
		}
		else
		{
			return true;
		}
	
	}

	// $this->ReMod->patientReport($report,$reportinfo);
	// $this->ReMod->companyReport($report,$reportinfo);
	// $this->ReMod->pharmacyReport($report,$reportinfo);
	// SELECT `role`, `reportreport_ID`, `pharmacypharmacy_ID`, `useruserId` FROM `reportpersonorpharmacy` WHERE 1
	// SELECT `role`, `reportreport_ID`, `pharmacypharmacy_ID`, `companycompany_ID` FROM `reportcompanyorpharmacy` WHERE 1
	public function reportpahrmacyuser(){
		$this->load->library('form_validation');
		$this->form_validation->set_rules('title','title','required|min_length[10]');
		$this->form_validation->set_rules('subject','subject','required|min_length[10]');
		if(!$this->form_validation->run())
		{
			echo form_error('title').'|'.form_error('subject');
		}
		else
		{
			$this->load->model('ReportMod','ReMod');
			$this->load->model('security','sec');
			if(isset($_POST['id'])){
				// change var names 
				$userID = $this->sec->decode($_POST['id']);
				if($userID != -1){
					$writerReport = $this->session->userdata('typesid')['PID'];   
					$report = array(
						'report_title' => $_POST['title'],
						'report_subject' =>$_POST['subject'] 
					);
					$reportinfo = array
					(
						'useruserId' => $userID,
						'pharmacypharmacy_ID' => $writerReport
					);
					$this->ReMod->patientReport($report,$reportinfo);
				}
				else{
					echo 'Error1';
				} 
				
			}
			else{
				echo 'Error1';
			}
		}
	}

	// $this->ReMod->patientReport($report,$reportinfo);
	// $this->ReMod->companyReport($report,$reportinfo);
	// $this->ReMod->pharmacyReport($report,$reportinfo);
	// SELECT `role`, `reportreport_ID`, `pharmacypharmacy_ID`, `useruserId` FROM `reportpersonorpharmacy` WHERE 1
	// SELECT `role`, `reportreport_ID`, `pharmacypharmacy_ID`, `companycompany_ID` FROM `reportcompanyorpharmacy` WHERE 1
	public function reportuserpahrmacy(){
		$this->load->library('form_validation');
		$this->form_validation->set_rules('title','title','required|min_length[10]');
		$this->form_validation->set_rules('subject','subject','required|min_length[10]');
		if(!$this->form_validation->run())
		{
			echo form_error('title').'|'.form_error('subject');
		}
		else
		{
			$this->load->model('ReportMod','ReMod');
			$this->load->model('security','sec');
			if(isset($_POST['id'])){
				// change var names 
				$pharmacyID = $this->sec->decode($_POST['id']);
				if($pharmacyID != -1){
					$writerReport = $this->session->userdata('Account_ID');
					echo $writerReport;   
					$report = array(
						'report_title' => $_POST['title'],
						'report_subject' =>$_POST['subject'] 
					);
					$reportinfo = array
					(
						'pharmacypharmacy_ID' => $pharmacyID ,
						'useruserId'		  => $writerReport
					);
					$this->ReMod->pharmacyReport($report,$reportinfo);
				}
				else{
					echo 'Error1';
				} 
				
				
			}
			else{
				echo 'Error2';
			}
			
		}
	}


	public function reportcompanypahrmacy(){
		$this->load->library('form_validation');
		$this->form_validation->set_rules('title','title','required|min_length[10]');
		$this->form_validation->set_rules('subject','subject','required|min_length[10]');
		if(!$this->form_validation->run())
		{
			echo form_error('title').'|'.form_error('subject');
		}
		else
		{
			$this->load->model('ReportMod','ReMod');
			$this->load->model('security','sec');
			if(isset($_POST['id'])){
				// change var names 
				$pharmacyID = $this->sec->decode($_POST['id']);
				if($pharmacyID != -1){
					$writerReport = $this->session->userdata('typesid')['CID'];   
					$report = array(
						'report_title' => $_POST['title'],
						'report_subject' =>$_POST['subject'] 
					);
					$reportinfo = array
					(
						'pharmacypharmacy_ID'	=> $pharmacyID,
						'companycompany_ID'		=> $writerReport
					);
					$this->ReMod->pharmacyReport($report,$reportinfo);
				}
				else{
					echo 'Error1';
				} 
				
				
			}
			else{
				echo 'Error1';
			}
			
		}
	}


	public function reportpahrmacycompany(){
		$this->load->library('form_validation');
		$this->form_validation->set_rules('title','title','required|min_length[10]');
		$this->form_validation->set_rules('subject','subject','required|min_length[10]');
		if(!$this->form_validation->run())
		{
			echo form_error('title').'|'.form_error('subject');
		}
		else
		{
			$this->load->model('ReportMod','ReMod');
			$this->load->model('security','sec');
			if(isset($_POST['id'])){
				// change var names 
				$companyID = $this->sec->decode($_POST['id']);
				if($companyID != -1){
					$writerReport = $this->session->userdata('typesid')['PID'];   
					$report = array(
						'report_title' => $_POST['title'],
						'report_subject' =>$_POST['subject'] 
					);
					$reportinfo = array
					(
						'companycompany_ID' 	=> $companyID,
						'pharmacypharmacy_ID' 	=> $writerReport
					);
					$this->ReMod->companyReport($report,$reportinfo);
				}
				else{
					echo 'Error1';
				} 
				
				
			}
			else{
				echo 'Error1';
			}
			
		}
	}




	public function index(){
		$this->load->model('security','sec');
		echo $this->sec->encode(181);   

	}
}
?>