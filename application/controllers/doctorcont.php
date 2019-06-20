<?php

class Doctorcont extends CI_Controller {
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
			$data['isdoctor'] = "";
			$data['myurl']	= base_url()."Doctorcont/Edit";	
			$this->load->view('setting',$data);
			$this->load->view('myprofile',$data);
		}
	}

	public function article(){
		if($this->session->userdata('typesid')){
			$docId = intval($this->session->userdata('typesid')['DID']);
			if ($this->session->userdata('typesid')['DID'] != -1 ) {
				$this->load->model('ArticleMod','artMod');
				$data['data'] = $this->artMod->getmyArticles($docId);
				$data['isdoctor'] = true ;
				$data['edit'] = true ;

				$this->load->view('setting',$data);
				$this->load->view('myarticle',$data);
			}
		}
		
	}

	public function writeArticle(){
		if ($this->session->userdata('typesid')['DID'] != -1 ) 
		{
			$data['isdoctor'] = true ;
			$data['img'] = base_url().'style/images/article.jpg';
			$this->load->view('setting',$data);
			$this->load->view('writearticle',$data);
		}

	}

	public function editArticle(){
		$id = $this->uri->segment(3);
		if (isset($id)) {
			if ($this->session->userdata('typesid')['DID'] != -1 ) 
			{
				$this->load->model('security','sec');
				$this->load->model('ArticleMod','artMod');
				$id = $this->sec->decode($id);
				$data['isdoctor'] = true ;
				$res = $this->artMod->HasPermissiontoDeleteArticle($id,$this->session->userdata('typesid')['DID']);
					if ($res) {
						$article = $this->artMod->getArticle($id);
						$data['ID'] = $article['article_ID'];
						$data['title'] = $article['article_title'];
						$data['description'] = $article['article_subject'];
						$data['img'] = base_url()."style/images/".$article['img'];
						$this->load->view('setting',$data);
						$this->load->view('editarticle',$data);
					}
					else{
						redirect(base_url()."Errorcont");
					}
			}
		}
		

	}

}


?>