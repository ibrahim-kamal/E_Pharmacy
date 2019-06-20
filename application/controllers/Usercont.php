<?php

class usercont extends CI_Controller {
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
			$data['isuser'] = "";
			$data['myurl']	= base_url()."usercont/Edit";	
			$this->load->view('setting',$data);
			$this->load->view('myprofile',$data);
		}
	}

	// public function removeUser()
	// {
	// 	if(isset($_POST['Aid']))
	// 	{
			
	// 		$Aid = $_POST['Aid']; 
	// 		$this->load->model('security', 'sec');	
	// 		$AccountID = $this->sec->decode($Aid);
	// 		if($AccountID == $this->session->userdata('Account_ID'))
	// 		{
	// 			$this->load->model('accontMod', 'AccMod');
	// 			$this->AccMod->RemoveAccount($AccountID);
	// 			session_destroy();				
	// 		}
	// 	}
	// }


	public function Edit(){
		if($this->session->userdata('Account_ID')){
			$this->load->model('userMod', 'usrMod');
			$data = $this->usrMod->get_user_info($this->session->userdata('Account_ID'));
			$data['isuser'] = "";
			$this->load->view('setting',$data);
			$this->load->view('Edit',$data);
		}
		
	}

	// ajax view 

	public function question(){
		if($this->session->userdata('typesid')){
			$this->load->model('QuestionMod','QueMod');
			$data['data'] = $this->QueMod->getmyQuestion();
			$data['isuser'] = true ;
			$data['edit'] = true ;
			$this->load->view('setting',$data);
			$this->load->view('myquestion',$data);
		}
		
	}

	public function writeQuestion(){
			$data['isuser'] = true ;
			$data['img'] = base_url().'style/images/questions.jpg';
			$this->load->view('setting',$data);
			$this->load->view('writequestion',$data);
	}


	public function editQuestion(){
		$id = $this->uri->segment(3);
		if (isset($id)) {
			$this->load->model('security','sec');
			$this->load->model('QuestionMod','quesMod');
			$id = $this->sec->decode($id);
			$data['isuser'] = true ;
			$res = $this->quesMod->HasPermissiontoDeleteQusetion($id);
				if ($res) {
					$question = $this->quesMod->getQuestion($id);
					$data['ID'] = $question['Question_ID'];
					$data['title'] = $question['Question_title'];
					$data['description'] = $question['Question_subject'];
					$data['img'] = base_url()."style/images/".$question['img'];
					$this->load->view('setting',$data);
					$this->load->view('editquestion',$data);
				}
				else{
					redirect(base_url()."Errorcont");
				}			
		}
	}

	public function Order(){
		if($this->session->userdata('Account_ID')){
			$role = $this->session->userdata('role');
			$this->load->model('medicinemod','medMod');
			if($role == 5 )
			{
				$data['data'] = $this->medMod->getPatientBooks($this->session->userdata('Account_ID'));
				$data['isuser'] = true ;
				$this->load->view('setting',$data);
				$this->load->view('order',$data);

			}
		}
	}

	public function myorder(){
		if($this->session->userdata('Account_ID')){
			$role = $this->session->userdata('role');
			$this->load->model('medicinemod','medMod');
			if($role == 5 )
			{
				$data['data'] = $this->medMod->getPatientorder($this->session->userdata('Account_ID'));
				$data['isuser'] = true ;
				$this->load->view('setting',$data);
				$this->load->view('myorder',$data);

			}
		}
	}

}
?>