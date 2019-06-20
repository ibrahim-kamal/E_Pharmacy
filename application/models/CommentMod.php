
<?php
class CommentMod extends CI_Model {


	//SELECT `com_ID`, `com_title`, `com_subject`, `new` FROM `commentandanswer` WHERE 1

	public function getallcomments($typeID,$type)
	{
		// SELECT `com_ID`, `com_title`, `com_subject`, `new` FROM `commentandanswer` WHERE 1
		$role = $this->session->userdata('role');
		$activedoctorid = $this->session->userdata('Account_ID');
		$dir = base_url()."style/images/";
		$this->load->model("doctorMod","docMod");
		$this->load->model("security","sec");
		$data = [];
		if($type == "article")
		{
			// SELECT `QuestionandAnswer_ID`, `articlearticle_ID`, `article_Doctor_ID` FROM `articlecomment` WHERE 1
			$sql = 'SELECT com_ID , com_title , com_subject , article_Doctor_ID
			 from articlecomment 
			INNER JOIN commentandanswer 
			ON com_ID = QuestionandAnswer_ID 
			WHERE articlearticle_ID = '.$typeID.' ORDER BY `com_ID` DESC;';
			$i = 0;
			$query = $this->db->query($sql);
			foreach ($query->result() as $row)
			{
				$id =$row->article_Doctor_ID;
				$Docid = $this->docMod->getAccountid($id);
				if ($role == 1) {
					$data['delete'][$i] = true;
					$data['edit'][$i] = false;
				}
				elseif($Docid == $activedoctorid)
				{
					$data['delete'][$i] = true;
					$data['edit'][$i] = true;
				}
				else{
					$data['delete'][$i] = false;
					$data['edit'][$i] = false;
				}
				$data['com_ID'][$i] = $this->sec->encode($row->com_ID);
				$data['com_title'][$i] = $row->com_title;
				$data['com_subject'][$i] = $row->com_subject;
				$data['writer'][$i] = $this->docMod->getDoctorName($id);
				$data['img'][$i] = $dir.$this->docMod->getDoctorimg($id);
				$i++; 
			} 

		}
		elseif($type == "question")
		{
			// SELECT `Question_Answercom_ID`, `Question_Question_ID`, `Question_Doctor_ID` FROM `questioncomment` WHERE 1

			$sql = 'SELECT com_ID , com_title , com_subject , Question_Doctor_ID
			 from questioncomment 
			INNER JOIN commentandanswer 
			ON com_ID = Question_Answercom_ID 
			WHERE Question_Question_ID = '.$typeID.' ORDER BY `com_ID` DESC;' ;
			$i = 0;
			$query = $this->db->query($sql);
			foreach ($query->result() as $row)
			{
				$id =$row->Question_Doctor_ID;
				$Docid = $this->docMod->getAccountid($id);
				if ($role == 1) {
					$data['delete'][$i] = true;
					$data['edit'][$i] = false;
				}
				elseif($Docid == $activedoctorid)
				{
					$data['delete'][$i] = true;
					$data['edit'][$i] = true;
				}
				else{
					$data['delete'][$i] = false;
					$data['edit'][$i] = false;
				}
				$data['com_ID'][$i] = $this->sec->encode($row->com_ID);
				$data['com_title'][$i] = $row->com_title;
				$data['com_subject'][$i] = $row->com_subject;
				$data['writer'][$i] = $this->docMod->getDoctorName($id);
				$data['img'][$i] = $dir.$this->docMod->getDoctorimg($id);
				$i++; 
			}
		}
		else
		{
			// SELECT `medicine_comment_ID`, `medicine_medicine_ID`, `medicine_comment_Doctor_ID` FROM `medicinecomment` WHERE 1

			$sql = 'SELECT com_ID , com_title , com_subject , medicine_comment_Doctor_ID
			 from medicinecomment 
			INNER JOIN commentandanswer 
			ON com_ID = medicine_comment_ID 
			WHERE medicine_medicine_ID = '.$typeID.' ORDER BY `com_ID` DESC;';
			$i = 0;
			$query = $this->db->query($sql);
			foreach ($query->result() as $row)
			{
				$id =$row->medicine_comment_Doctor_ID;
				$Docid = $this->docMod->getAccountid($id);
				if ($role == 1) {
					$data['delete'][$i] = true;
					$data['edit'][$i] = false;
				}
				elseif($Docid == $activedoctorid)
				{
					$data['delete'][$i] = true;
					$data['edit'][$i] = true;
				}
				else{
					$data['delete'][$i] = false;
					$data['edit'][$i] = false;
				}
				$data['com_ID'][$i] = $this->sec->encode($row->com_ID); 
				$data['com_title'][$i] = $row->com_title;
				$data['com_subject'][$i] = $row->com_subject;
				$data['writer'][$i] =$this->docMod->getDoctorName($id);
				$data['img'][$i] = $dir.$this->docMod->getDoctorimg($id);
				$i++; 
			} 
		}
		return $data;
	}


	public function writeComment($Comment,$type,$tableinfo)
	{
		$this->db->insert('commentandanswer',$Comment);
		$id = $this->db->insert_id();
		if($type == "article")
		{
			$tableinfo['QuestionandAnswer_ID'] = $id;
			$this->articlecomment($tableinfo);
		}
		elseif($type == "question")
		{
			$tableinfo['Question_Answercom_ID'] = $id;
			$this->questioncomment($tableinfo);
		}
		else
		{
			$tableinfo['medicine_comment_ID'] = $id;
			$this->medicinecomment($tableinfo);
		}
		return $id;

	}


	public function updateComment($CommentID , $Comment)
	{
		$this->db->where('com_ID',$CommentID);
        $this->db->update('commentandanswer', $Comment);
	}

	public function HasPermissiontoDeleteArticleComment($CommentID,$DID){
		$this->db->where('QuestionandAnswer_ID',$CommentID);
		$this->db->where('article_Doctor_ID',$DID);
		$this->db->select('*');
		$this->db->from('articlecomment');
		$res = $this->db->get();
		if($res->num_rows() > 0){
			return true;
		}
		return false;
	}
	
	
	public function HasPermissiontoDeleteMedicneComment($CommentID,$DID){
		$this->db->where('medicine_comment_ID',$CommentID);
		$this->db->where('medicine_comment_Doctor_ID',$DID);
		$this->db->select('*');
		$this->db->from('medicinecomment');
		$res = $this->db->get();
		if($res->num_rows() > 0){
			return true;
		}
		return false;
	}

	

	public function HasPermissiontoDeleteQuestionComment($CommentID,$DID){
		$this->db->where('Question_Answercom_ID',$CommentID);
		$this->db->where('Question_Doctor_ID',$DID);
		$this->db->select('*');
		$this->db->from('questioncomment');
		$res = $this->db->get();
		if($res->num_rows() > 0){
			return true;
		}
		return false;
	}

	
	public function deleteComment($CommentID)
	{
		$this->db->where('com_ID',$CommentID);
        $this->db->delete('commentandanswer');
	}

	public function articlecomment($info){
		$this->db->insert('articlecomment',$info);
	}

	public function questioncomment($info){
		$this->db->insert('questioncomment',$info);
	}

	public function medicinecomment($info){
		$this->db->insert('medicinecomment',$info);
	}

}
?>