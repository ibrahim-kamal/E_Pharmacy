<?php

class Questioncont extends CI_Controller {

	public function index(){
		$this->load->model('QuestionMod',"quesMod");
		$data['data'] = $this->quesMod->getallQuestion();
		if($this->session->userdata('name')){
			$data['username'] = $this->session->userdata('name');
		}
		$data['createtitle'] = true;
		$this->load->view("HeaderHome",$data);
		$this->load->view("Questions",$data);
	}

	public function Question(){
		if($this->session->userdata('name')){
			$data['username'] = $this->session->userdata('name');
		}
		$data['createtitle'] = true;
		$this->load->model("security","sec");
		$this->load->model("QuestionMod","quesMod");
		$this->load->model("CommentMod","comMod");
		$id = $this->uri->segment(3);
		$decodeId = intval($this->sec->decode($id));
		$data['data'] = $this->quesMod->getQuestion($decodeId);
		if($this->session->userdata('typesid')){
			if($this->session->userdata('typesid')['DID'] != -1){
				$data['Allowcomment'] = true; 
			}
			else{
				$data['Allowcomment'] = false;
			}
		}
		else{
			$data['Allowcomment'] = false;
		}
		$typeID = $decodeId;
		$type 	= "question";
		$data['comment'] = $this->comMod->getallcomments($typeID,$type);
		$this->load->view("HeaderHome",$data);
		$this->load->view("Question",$data);

	}


	public function addComment()
	{
		if(isset($_POST['title']) && isset($_POST['comment']))
		{
			$this->load->library('form_validation');
			$this->form_validation->set_rules('title','title','required|min_length[6] |max_length[100]');
			$this->form_validation->set_rules('comment','comment','required|min_length[6] |max_length[1000]');
			if(!$this->form_validation->run())
			{
				echo form_error('title')." | ".form_error('comment');
			}
			else
			{
				if($this->session->userdata('typesid')['DID']!=-1)
				{
					// SELECT `com_ID`, `com_title`, `com_subject`, `Comment`, `new` FROM `commentandanswer` WHERE 1
					// SELECT `Question_Answercom_ID`, `Question_Question_ID`, `Question_Doctor_ID` FROM `questioncomment` WHERE 1
					$this->load->model("CommentMod","comMod");
					$this->load->model("security","sec");
					$Comment =  array('com_title' => $_POST['title'] , 'com_subject'=> $_POST['comment']);
					$type = "question";
					$tableinfo =  array('Question_Question_ID' => $this->sec->decode($_POST['id']),
						'Question_Doctor_ID' => $this->session->userdata('typesid')['DID']
						);
					$commentid = $this->comMod->writeComment($Comment,$type,$tableinfo);
					echo $this->session->userdata('img')." && ".$this->session->userdata('name')." && ".$this->sec->encode($commentid);	
				}
			}
		}
		else{
			redirect(base_url());
		}
		
	}

	public function removecomment()
	{
		if($_POST['id']){
			$this->load->model("security","sec");
			$this->load->model("CommentMod","comMod");
			try{
				$id = $this->sec->decode($_POST['id']);
				if($this->session->userdata('typesid')['DID'] != -1){
					$res = $this->comMod->HasPermissiontoDeleteQuestionComment($id,$this->session->userdata('typesid')['DID']);
					if ($res) {
						$this->comMod->deleteComment($id);
					}
					else{
						echo "error";
					}
				}
				elseif ($this->session->userdata('role') == 1) {
					$this->comMod->deleteComment($id);
				}else{
					echo "error";
				}
				echo "deleted";
			}
			catch(Exception $e){
				echo "error";
			}
		}
		else{
			redirect(base_url()."Errorcont");
		}
	}


	public function editComment(){
		$this->load->library('form_validation');
		$this->form_validation->set_rules('title','title','required|min_length[6] |max_length[100]');
		$this->form_validation->set_rules('comment','comment','required|min_length[6] |max_length[1000]');
		if(!$this->form_validation->run())
		{
			echo form_error('title')." | ".form_error('comment');
		}
		else
		{
			if($this->session->userdata('typesid')['DID']!=-1){
				// SELECT `com_ID`, `com_title`, `com_subject`, `Comment`, `new` FROM `commentandanswer` WHERE 1
				// SELECT `QuestionandAnswer_ID`, `articlearticle_ID`, `article_Doctor_ID` FROM `articlecomment` WHERE 1

				$this->load->model("CommentMod","comMod");
				$this->load->model("security","sec");
				$comid = $this->sec->decode($_POST['id']);
				$res = $this->comMod->HasPermissiontoDeleteQuestionComment($comid,$this->session->userdata('typesid')['DID']);
					if ($res) {
						$Comment =  array('com_title' => $_POST['title'] , 'com_subject'=> $_POST['comment']);
						try{
							$commentid = $this->comMod->updateComment($comid , $Comment);
							echo $this->session->userdata('img')." && ".$this->session->userdata('name')." && ".$_POST['id'];
						}
						catch(Exception $e){
							// echo error
						}
						
					}
					else{
						// echo "error";
					}
					
			}
		}
	}


	public function removeQuestion()
	{
		if(isset($_POST['id'])){
			$this->load->model("security","sec");
			$this->load->model("QuestionMod","QueMod");
			try{
				$id = $this->sec->decode($_POST['id']);
				$res = $this->QueMod->HasPermissiontoDeleteQusetion($id);
				if ($res) {
					$this->QueMod->deleteQuestion($id);
					echo "deleted";
				}
				elseif ($this->session->userdata('role') == 1) {
					$this->QueMod->deleteQuestion($id);
					echo "deleted";
				}
				else{
					echo "error";
				}
			}
			catch(Exception $e){
				echo "error";
			}
		}
		else{
			// redirect(base_url()."Errorcont");
		}
	}


	public function addQuestion(){
		
		if(isset($_POST['title'])){
			$this->load->model("system","sys");
			$this->load->model("QuestionMod","quesMod");
			$this->load->model("security","sec");
			$this->load->library('form_validation');
			$this->form_validation->set_rules('title','title','required|min_length[20] |max_length[100]');
			$this->form_validation->set_rules('description','description','required|min_length[100] |max_length[1011]');
			if(!$this->form_validation->run())
			{

				$data['err'] = "<p>".form_error('title')."</p>"."<p>".form_error('description')."</p>";
				$data['isuser'] = true ;
				$data['title'] = $_POST['title'] ;
				$data['description'] = $_POST['description'] ;
				$data['img'] = base_url().'style/images/questions.jpg';
				$this->load->view('setting',$data);
				$this->load->view('writeQuestion',$data);
			}
			else
			{
				$name = $this->sys->saveimg('questions',$_FILES);
				
				//SELECT `Question_ID`, `Question_title`, `Question_subject`, `Q_Account_ID`, `QuestionDate`, `img`, `new` FROM `question` WHERE 1
				$question = array(
					'Question_title' 	=> $_POST['title'] , 
					'Question_subject' 	=> $_POST['description'] ,
					'img' 				=> $name , 
					'Q_Account_ID' 	=>  $this->session->userdata('Account_ID')
					);
				$id = $this->quesMod->writeQuestion($question);
				redirect(base_url()."Questioncont/Question/".$this->sec->encode($id)); 
			}
		}
	}



	public function editquestion(){
		
		if(isset($_POST['title'])){
			$this->load->model("system","sys");
			$this->load->model("QuestionMod","quesMod");
			$this->load->model("security","sec");
			$this->load->library('form_validation');
			$this->form_validation->set_rules('title','title','required|min_length[20] |max_length[100]');
			$this->form_validation->set_rules('description','description','required|min_length[100] |max_length[1011]');
			if(!$this->form_validation->run())
			{

				$data['err'] = "<p>".form_error('title')."</p>"."<p>".form_error('description')."</p>";
				$data['isuser'] = true ;
				$data['title'] = $_POST['title'] ;
				$data['description'] = $_POST['description'] ;
				$data['img'] = base_url().'style/images/questions.jpg';
				$this->load->view('setting',$data);
				$this->load->view('writearticle',$data);
			}
			else
			{

				$name = $this->sys->saveimg('questions',$_FILES);
				
				//SELECT `Question_ID`, `Question_title`, `Question_subject`, `Q_Account_ID`, `QuestionDate`, `img`, `new` FROM `question` WHERE 1
				if($name != 'article.jpg'){
				$article = array(
					'Question_title' 	=> $_POST['title'] , 
					'Question_subject' 	=> $_POST['description'] ,
					'img' 				=> $name 
					);
				}
				else{
					$article = array(
					'Question_title' 	=> $_POST['title'] , 
					'Question_subject' 	=> $_POST['description'] 
					);
				}
				$id = $_POST['data-id'];
				$this->quesMod->updateQuestion($this->sec->decode($id) , $article);
				redirect(base_url()."Questioncont/Question/".$id); 

			
			}
		}
	}


}