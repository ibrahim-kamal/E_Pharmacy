<?php

class Articlecont extends CI_Controller {

	public function index(){
		$this->load->model('ArticleMod',"artMod");
		$data['data'] = $this->artMod->getallArticle();
		if($this->session->userdata('name')){
			$data['username'] = $this->session->userdata('name');
		}
		$data['createtitle'] = true;
		$this->load->view("HeaderHome",$data);
		$this->load->view("articles",$data);
	}

	public function Article(){
		$data['createtitle'] = true;
		if($this->session->userdata('name')){
			$data['username'] = $this->session->userdata('name');
		}
		$this->load->model("security","sec");
		$this->load->model("ArticleMod","artMod");
		$this->load->model("CommentMod","comMod");
		$id = $this->uri->segment(3);
		$decodeId = intval($this->sec->decode($id));
		$data['data'] = $this->artMod->getArticle($decodeId);
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
		$type 	= "article";
		$data['comment'] = $this->comMod->getallcomments($typeID,$type);
		$this->load->view("HeaderHome",$data);
		$this->load->view("article",$data);

	}


	public function addComment(){
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
				$Comment =  array('com_title' => $_POST['title'] , 'com_subject'=> $_POST['comment']);
				$type = "article";
				$tableinfo =  array('articlearticle_ID' => $this->sec->decode($_POST['id']),
					'article_Doctor_ID' => $this->session->userdata('typesid')['DID']
					);
				$commentid = $this->comMod->writeComment($Comment,$type,$tableinfo);
				echo $this->session->userdata('img')." && ".$this->session->userdata('name')." && ".$this->sec->encode($commentid);	
			}
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
					$res = $this->comMod->HasPermissiontoDeleteArticleComment($id,$this->session->userdata('typesid')['DID']);
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
				$res = $this->comMod->HasPermissiontoDeleteArticleComment($comid,$this->session->userdata('typesid')['DID']);
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


	public function removeArticle()
	{
		if(isset($_POST['id'])){
			$this->load->model("security","sec");
			$this->load->model("ArticleMod","artMod");
			try{
				$id = $this->sec->decode($_POST['id']);
				if($this->session->userdata('typesid')['DID'] != -1){
					$res = $this->artMod->HasPermissiontoDeleteArticle($id,$this->session->userdata('typesid')['DID']);
					if ($res) {
						$this->artMod->deleteArticle($id);
					}
					else{
						echo "error";
					}
				}
				elseif ($this->session->userdata('role') == 1) {
					$this->artMod->deleteArticle($id);
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


	public function addArticle(){
		
		if(isset($_POST['title'])){
			$this->load->model("system","sys");
			$this->load->model("ArticleMod","artMod");
			$this->load->model("security","sec");
			$this->load->library('form_validation');
			$this->form_validation->set_rules('title','title','required|min_length[20] |max_length[100]');
			$this->form_validation->set_rules('description','description','required|min_length[100] |max_length[1011]');
			if(!$this->form_validation->run())
			{

				$data['err'] = "<p>".form_error('title')."</p>"."<p>".form_error('description')."</p>";
				$data['isdoctor'] = true ;
				$data['title'] = $_POST['title'] ;
				$data['description'] = $_POST['description'] ;
				$data['img'] = base_url().'style/images/article.jpg';
				$this->load->view('setting',$data);
				$this->load->view('writearticle',$data);
			}
			else
			{

				if($this->session->userdata('typesid')['DID']!=-1){
					$name = $this->sys->saveimg('article',$_FILES);
					
					// SELECT `article_ID`, `article_title`, `article_subject`, `article_Doc_ID`, `new` FROM `article` WHERE 1
					$article = array(
						'article_title' 	=> $_POST['title'] , 
						'article_subject' 	=> $_POST['description'] ,
						'img' 				=> $name , 
						'article_Doc_ID' 	=>  $this->session->userdata('typesid')['DID']
						);
					$id = $this->artMod->writeArticle($article);
					redirect(base_url()."Articlecont/Article/".$this->sec->encode($id)); 

				}	
			}
		}
	}

	public function EditArticle(){
		
		if(isset($_POST['title'])){
			$this->load->model("system","sys");
			$this->load->model("ArticleMod","artMod");
			$this->load->model("security","sec");
			$this->load->library('form_validation');
			$this->form_validation->set_rules('title','title','required|min_length[20] |max_length[100]');
			$this->form_validation->set_rules('description','description','required|min_length[100] |max_length[1011]');
			if(!$this->form_validation->run())
			{

				$data['err'] = "<p>".form_error('title')."</p>"."<p>".form_error('description')."</p>";
				$data['isdoctor'] = true ;
				$data['title'] = $_POST['title'] ;
				$data['description'] = $_POST['description'] ;
				$data['img'] = base_url().'style/images/article.jpg';
				$this->load->view('setting',$data);
				$this->load->view('writearticle',$data);
			}
			else
			{

				if($this->session->userdata('typesid')['DID']!=-1){
					$name = $this->sys->saveimg('article',$_FILES);
					
					// SELECT `article_ID`, `article_title`, `article_subject`, `article_Doc_ID`, `new` FROM `article` WHERE 1
					if($name != 'article.jpg'){
					$article = array(
						'article_title' 	=> $_POST['title'] , 
						'article_subject' 	=> $_POST['description'] ,
						'img' 				=> $name 
						);
					}
					else{
						$article = array(
						'article_title' 	=> $_POST['title'] , 
						'article_subject' 	=> $_POST['description'] 
						);
					}
					$id = $_POST['data-id'];
					$this->artMod->updateArticle($this->sec->decode($id) , $article);
					redirect(base_url()."Articlecont/Article/".$id); 

				}	
			}
		}
	}

	



}