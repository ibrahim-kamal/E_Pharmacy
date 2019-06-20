<?php

class Settingcont extends CI_Controller {
	function index()
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
			redirect(base_url()."PharmacyCont");
		}
		else if($role == 4)
		{
			redirect(base_url()."companycont");
		}
		else if($role == 5)
		{
			redirect(base_url()."Usercont");
		}
	}

		public function changePassword()
	{
		if(isset($_POST['newpassword'])){
			$this->load->library('form_validation');
			$this->form_validation->set_rules(
				'newpassword' , 
				'new password' , 
				'required|alpha_numeric|matches[renewpassword]'
			);

			$this->form_validation->set_rules(
				'renewpassword' ,
				 're new password',
				'required|alpha_numeric|matches[newpassword]'
			);

			$this->form_validation->set_rules(
				'oldpassword',
				'old password',
				'required|alpha_numeric'
			);

			if(!$this->form_validation->run())
			{
				echo form_error('newpassword')."|".form_error('renewpassword')."|".form_error('oldpassword');
				return;
			}
			$this->load->model('accontMod','accMod');
			$res = $this->accMod->changepassword($_POST['newpassword'],$_POST['oldpassword']);
			echo $res;
		}
			
	}
	public function changeEmail()
	{
		if(isset($_POST['Email'])){			
			$this->load->library('form_validation');
			$this->form_validation->set_rules('Email','email','required|valid_email');
			$this->form_validation->set_rules(
				'password' , 
				'password' , 
				'required|alpha_numeric'
			);
			if(!$this->form_validation->run())
			{
				echo form_error('Email')."|".form_error('password');
				return;
			}
			$this->load->model('accontMod','accMod');
			echo $this->accMod->changeEmail($_POST['Email'],$_POST['password']);	
		}
	}
	public function changePhone()
	{
		if(isset($_POST['Phone'])){
			$this->load->library('form_validation');
			$this->form_validation->set_rules('Phone','phone','required|numeric|min_length[11]|max_length[11]');
			if(!$this->form_validation->run())
			{
				echo form_error('Phone');
				return;
			}
			$this->load->model('userMod','usrMod');
			echo $this->usrMod->changephone($_POST['Phone']);
				
		}
	}

	public function changeAddress()
	{
		if(isset($_POST['address'])){
			$this->load->library('form_validation');
			$this->form_validation->set_rules('address','address','required|alpha|min_length[3]');
			$this->form_validation->set_rules('country','country','required|alpha|min_length[3]');
			$this->form_validation->set_rules('city','city','required|alpha|min_length[3]');
			$this->form_validation->set_rules('nightborhood','nightborhood','required|alpha|min_length[3]');
			if(!$this->form_validation->run())
			{
				echo form_error('address').form_error('country').form_error('city').form_error('nightborhood');
				return;
			}
			$this->load->model('userMod','usrMod');
			$this->usrMod->changeaddress($_POST['address']);
			echo "done";	
		}
	}



	public function removeUser()
	{
		if(isset($_POST['Aid']))
		{
			
			$Aid = $_POST['Aid']; 
			$this->load->model('security', 'sec');	
			$AccountID = $this->sec->decode($Aid);
			if($AccountID == $this->session->userdata('Account_ID'))
			{
				$this->load->model('accontMod', 'AccMod');
				$this->AccMod->RemoveAccount($AccountID);
				session_destroy();				
			}
		}
	}


}
	

?>