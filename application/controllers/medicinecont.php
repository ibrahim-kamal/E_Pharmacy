<?php

class medicinecont extends CI_Controller {

	public function medicine(){
		$id = $this->uri->segment(3);
		if (isset($id)) {
			if($this->session->userdata('name')){
				$data['username'] = $this->session->userdata('name');
			}
			$this->load->model("medicinemod","MedMod");
			$this->load->model("security","SecMod");
			$this->load->model("CommentMod","comMod");

			$typeId = -1;
			$medicineId = $this->SecMod->decode($id);
			$data['Allowcomment'] = false;
			if($this->session->userdata('role') == 1 ){
				$type = 'other';
				$data['isadmin'] = '';
				$data['controller'] = "admincont";	
			}
			else if($this->session->userdata('role') == 4 || $this->session->userdata('role') == 7 ){
				$type = 'company';
				$data['iscompany'] = '';	
				$typeId=$this->session->userdata('typesid')['CID'];
				$data['controller'] = "companycont";
			}
			else if($this->session->userdata('role') == 3 || $this->session->userdata('role') == 6  ){
				$type = 'pharamcy';
				$data['ispharamcy'] = '';
				$typeId=$this->session->userdata('typesid')['PID'];
				$data['controller'] = "pharmacycont";	
			}
			else if($this->session->userdata('role') == 2 ){
				$type = 'other';
				$data['isdoctor'] = '';		
				$data['Allowcomment'] = true;
			}
			else{
				$type = 'other';
			}
			$data['data'] = $this->MedMod->medicine_details($medicineId,$type,false,$typeId);
			if(!$data['data'] == []){

				$data['medicine'] = $this->MedMod->medicine_Uses_sideEffect_contraceptive($medicineId);
				$type = 'medicine';
				$data['comment'] = $this->comMod->getallcomments($medicineId,$type);
				$data['createtitle'] = true;
				$this->load->view('HeaderHome',$data);
				$this->load->view('medicineDetails',$data);
			}
			else{
				redirect(base_url().'Errorcont');
			}
		}
			
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
				// SELECT `medicine_comment_ID`, `medicine_medicine_ID`, `medicine_comment_Doctor_ID` FROM `medicinecomment` WHERE 1
				$this->load->model("CommentMod","comMod");
				$this->load->model("security","sec");
				$Comment =  array('com_title' => $_POST['title'] , 'com_subject'=> $_POST['comment']);
				$type = "medicine";
				// 
				$tableinfo =  array('medicine_medicine_ID' => $this->sec->decode($_POST['id']),
					'medicine_comment_Doctor_ID' => $this->session->userdata('typesid')['DID']
					);
				$commentid = $this->comMod->writeComment($Comment,$type,$tableinfo);
				echo $this->session->userdata('img')." && ".$this->session->userdata('name')." && ".$this->sec->encode($commentid);	
			}
		}
	}

	public function removecomment(){
		if($_POST['id']){
			$this->load->model("security","sec");
			$this->load->model("CommentMod","comMod");
			try{
				$id = $this->sec->decode($_POST['id']);
				if($this->session->userdata('typesid')['DID'] != -1){
					$res = $this->comMod->HasPermissiontoDeleteMedicneComment($id,$this->session->userdata('typesid')['DID']);
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
				// SELECT `medicine_comment_ID`, `medicine_medicine_ID`, `medicine_comment_Doctor_ID` FROM `medicinecomment` WHERE 1

				$this->load->model("CommentMod","comMod");
				$this->load->model("security","sec");
				$comid = $this->sec->decode($_POST['id']);
				$res = $this->comMod->HasPermissiontoDeleteMedicneComment($comid,$this->session->userdata('typesid')['DID']);
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

}
?>