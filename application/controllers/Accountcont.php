<?php

class Accountcont extends CI_Controller {

	public function index()
	{
		$this->load->view('login');
	}

	public function login()
	{
		if (isset($_POST['Email'])) {
			if($this->loginValidation() == false)
			{
				$data['ErrorEmail']=form_error('Email');
				$data['Errorpass']=form_error('pass');
				$this->load->view('login',$data);
			}
			else
			{

				$this->load->model('accontMod', 'AccMod');
				$login = $this->AccMod->login($_POST['Email'] , $_POST['pass']);
				if(!$login)
				{
					$data['Email'] = $_POST['Email'];
					$data['ErrorEmail'] = "The password or the email that you've entered are incorrect";
					$this->load->view('login',$data);
				}
				else
				{
					$role = $this->session->userdata('role');
					if($role == 1){
						redirect(base_url()."admincont");
					}
					else if ($role == 2) 
					{
						redirect(base_url()."doctorcont");
					}
					else if($role == 3)
					{
						redirect(base_url()."pharmacycont");
					}
					else if($role == 4)
					{
						redirect(base_url()."companycont");
					}
					else if($role == 5)
					{
						redirect(base_url()."usercont");
					}
				}
			}
		}
	}


	public function AjaxLoginValidation()
	{
		if($this->loginValidation())
		{
			echo "true";
		}
		else
		{
			echo form_error('Email')."|".form_error('pass');
		}
	}

	public function loginValidation()
	{
		$this->load->library('form_validation');
		$this->form_validation->set_rules('Email','email','required|valid_email');
		$this->form_validation->set_rules('pass','password','required|alpha_numeric');
		if(!$this->form_validation->run())
		{
			return false;
		}
		else
		{
			return true;
		}
	}

	public function logout()
	{
		session_destroy();
		redirect(base_url());
	}



	public function profile(){
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
				if($profilerole !=-1)
				{
					if ($profilerole == 5) 
					{
							$data = $this->usrMod->get_account_user_info($profileId);
							if ($role == 3) {
								$data['report'] = '';
								$controller = 'reportcont';
							}
					}
					else if ($profilerole == 3) 
					{
							$data = $this->phrMod->get_pharmacy_info($profileId);
							if ($role == 5) {
								$data['report'] = '';
								$controller = 'reportcont';
							}
							else if ($role == 4) {
								$data['report'] = '';
								$controller = 'reportcont';
							}
					}

					else if ($profilerole == 4) 
					{
							$data = $this->comMod->get_company_info($profileId);
							if ($role == 3) {
								$data['report'] = '';
								$controller = 'reportcont';
							}
					}
					else{
						redirect(base_url().'Errorcont');
						return;
					}	
				}
				if(isset($controller)){
					$data['report_url'] = base_url().$controller."/report/".$Id;
				}
				if($this->session->userdata('name')){
					$data['username'] = $this->session->userdata('name');
				}
				$data['createtitle'] = true;
				$this->load->view("HeaderHome",$data);
				$this->load->view("profile",$data);
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


	public function test(){
		$this->load->model('pharmacyMod', 'phrMod');
		$Accountid = $this->session->userdata('Account_ID');
		$data['state'] = $this->phrMod->get_pharmacy_state($Accountid); 

		$this->load->view('footer',$data);
	}
}