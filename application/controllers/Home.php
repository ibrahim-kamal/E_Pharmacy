<?php

class home extends CI_Controller {


	public function index()
	{
		
		$data = [];
		if($this->session->userdata('name')){
			$data['username'] = $this->session->userdata('name');
		}
		$data['createtitle'] = true;
		$this->load->view('HeaderHome',$data);
		$this->load->view('Home');
	}


	public function search()
	{
		
		if(isset($_GET['word']))
		{
			$word = $_GET['word'];
			if($this->session->userdata('name'))
			{
				$data['username'] = $this->session->userdata('name');
			}
			$this->load->model('medicinemod', 'MedMod');
			$data['medicine_search_result'] = $this->MedMod->search($word);
			if(!isset($data['medicine_search_result']['uses_EN'])){
				$data['medicine_search_result'] = $this->MedMod->search(urldecode($word));				
			}		
			$data['word'] = $word;
			$this->load->view('HeaderHome',$data);
			$this->load->view('search');
		}
		else
		{
			redirect(base_url());
		}
	}













}
?>