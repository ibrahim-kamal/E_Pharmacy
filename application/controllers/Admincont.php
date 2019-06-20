<?php

class admincont extends CI_Controller {
	public function __construct(){
		parent::__construct();
		if($this->session->userdata('name')){
			$data['username'] = $this->session->userdata('name');
		}
		$data['createtitle'] = true;
		$this->load->view("HeaderHome",$data);
	}
	public function index()
	{
		$this->load->model('userMod', 'usrMod');
		$data['new'] = $this->usrMod->get_new_user();
		$data['all'] = $this->usrMod->get_All_user();
		$data['isadmin'] = "";
		$this->load->view('setting',$data);
		$this->load->view('Adminbody',$data);
	}

	public function general()
	{
		if($this->session->userdata('Account_ID'))
		{
			$this->load->model('userMod', 'usrMod');
			$data = $this->usrMod->get_user_info($this->session->userdata('Account_ID'));
			$data['isadmin'] = "";
			$data['myurl']	= base_url()."admincont/Edit";	
			$this->load->view('setting',$data);
			$this->load->view('myprofile',$data);
		}
	}

	public function profile()
	{
		$userid = $this->uri->segment(3);
		if (isset($userid)) {
			$this->load->model('security', 'sec');	
			$this->load->model('userMod', 'usrMod');
			$this->load->model('accontMod', 'AccMod');
			$AccountID = $this->sec->decode($userid);
			if($AccountID != false)
			{
				$data = $this->usrMod->get_user_info($AccountID);
			   	$this->AccMod->seenAccount($AccountID);
				$this->load->view('userprofile',$data);
			}
			else{
				redirect(base_url());
			}
			
		}
		else
		{
			redirect(base_url());
		}
	}

	public function Home()
	{
		$this->load->model('userMod', 'usrMod');
		$data['new'] = $this->usrMod->get_new_user();
		$data['all'] = $this->usrMod->get_All_user();
		$this->load->view('Adminbody',$data);
	}


	public function AcceptUser()
	{
		if(isset($_POST['Aid']))
		{
			$Aid = $_POST['Aid']; 
			$this->load->model('security', 'sec');	
			$AccountID = $this->sec->decode($Aid);
			$this->load->model('accontMod', 'AccMod');
			$this->AccMod->AcceptAccount($AccountID);
		}
	}

	public function removeUser()
	{
		if(isset($_POST['Aid']))
		{
			$Aid = $_POST['Aid']; 
			$this->load->model('security', 'sec');	
			$AccountID = $this->sec->decode($Aid);
			$this->load->model('accontMod', 'AccMod');
			$this->AccMod->RemoveAccount($AccountID);
		}
	}



	public function article(){
		if($this->session->userdata('typesid')){
			if ($this->session->userdata('role') == 1 ) {
				$this->load->model('ArticleMod','artMod');
				$data['data'] = $this->artMod->getallArticle();
				$data['isadmin'] = true ;
				$this->load->view('setting',$data);
				$this->load->view('myarticle',$data);
			}
		}
		
	}

	public function question(){
		if($this->session->userdata('typesid')){
			$this->load->model('QuestionMod','QueMod');
			$data['data'] = $this->QueMod->getallQuestion();
			$data['isuser'] = true ;
			$this->load->view('setting',$data);
			$this->load->view('myquestion',$data);
		}
		
	}


	public function medicine()
	{
		$this->load->model('medicinemod','MedMod');
		$type = 'admin';
		$data['data'] = $this->MedMod->Medicine($type);
		$data['isadmin'] = "";
		$this->load->view('setting',$data);
		$this->load->view('medicine',$data);
	}

	public function AcceptMedicine(){
		if (isset($_POST['MedID'])) {
			$this->load->model('medicinemod','MedMod');
			$this->load->model('security','Sec');
			$medID = $this->Sec->decode($_POST['MedID']);
			$this->MedMod->Accept($medID);
			echo 'Accept';
		}
	}	


	public function RemoveMedicine(){
		if (isset($_POST['MedID'])) {
			$this->load->model('medicinemod','MedMod');
			$this->load->model('security','Sec');
			$medID = $this->Sec->decode($_POST['MedID']);
			$type = 'admin';
			$typeId = -1;
			$this->MedMod->Remove($medID,$type,$typeId);
			echo 'Accept';
		}
	}	
	
	public function pharmacyreport()
	{

	}

	public function companyreport()
	{
		
	}

	

}



?>