<?php
class QuestionMod extends CI_Model {

	// SELECT `Question_ID`, `Question_title`, `Question_subject`, `Q_Account_ID`, `QuestionDate`, `img`, `new` FROM `question` WHERE 1

	public function getQuestion($questionID)
	{
		$this->load->model('security',"sec");
		$this->load->model("userMod","usrMod");
		$this->db->where('Question_ID',$questionID);
		$this->db->select('*');
		$this->db->from('question');
		$res = $this->db->get();
		$data = [];
		foreach ($res->result() as $row)
		{
			$data['Question_ID'] = $this->sec->encode($row->Question_ID);
			$data['Question_title'] = $row->Question_title;
			$data['Question_subject'] = $row->Question_subject;
			$data['time'] = $row->QuestionDate;
			$data['img'] = $row->img;
			$data['writer'] = $this->usrMod->getname($row->Q_Account_ID);
		} 
		return $data;
	}

	public function getallQuestion()
	{
		// SELECT `Question_ID`, `Question_title`, `Question_subject`, `Q_Account_ID`, `QuestionDate`, `img`, `new` FROM `question` WHERE 1
		$this->load->model('security',"sec");
		$this->load->model("userMod","usrMod");
		$this->db->select('Question_ID');
		$this->db->select('Question_title');
		$this->db->select('Q_Account_ID');
		$this->db->select('LEFT(Question_subject, 200) as subject');
		$this->db->select('QuestionDate');
		$this->db->select('img');
		$this->db->from('question');
		$res = $this->db->get();
		$data = [];
		$i = 0;
		$url = base_url()."Questioncont/Question/"; 
		foreach ($res->result() as $row)
		{
			$id = $this->sec->encode($row->Question_ID); 
			$data['url'][$i] =$url.$id;
			$data['id'][$i] =$id;
			$data['title'][$i] = $row->Question_title;
			$data['subject'][$i] = $row->subject."...";
			$data['time'][$i] = $row->QuestionDate;
			$data['img'][$i] = $row->img;
			$data['writer'][$i] = $this->usrMod->getname($row->Q_Account_ID);
			$i++;
		} 
		return $data;
	}

	public function getmyQuestion()
	{
		// SELECT `Question_ID`, `Question_title`, `Question_subject`, `Q_Account_ID`, `QuestionDate`, `img`, `new` FROM `question` WHERE 1
		$this->load->model('security',"sec");
		$this->load->model("userMod","usrMod");
		$this->db->select('Question_ID');
		$this->db->select('Question_title');
		$this->db->select('Q_Account_ID');
		$this->db->select('LEFT(Question_subject, 200) as subject');
		$this->db->select('QuestionDate');
		$this->db->select('img');
		$this->db->where('Q_Account_ID',$this->session->userdata('Account_ID'));
		$this->db->from('question');
		$res = $this->db->get();
		$data = [];
		$i = 0;
		$url = base_url()."Questioncont/Question/"; 
		foreach ($res->result() as $row)
		{
			$id = $this->sec->encode($row->Question_ID); 
			$data['url'][$i] =$url.$id;
			$data['id'][$i] =$id;
			$data['title'][$i] = $row->Question_title;
			$data['subject'][$i] = $row->subject."...";
			$data['time'][$i] = $row->QuestionDate;
			$data['img'][$i] = $row->img;
			$data['writer'][$i] = $this->usrMod->getname($row->Q_Account_ID);
			$i++;
		} 
		return $data;
	}

	public function writeQuestion($Question)
	{
		$this->db->insert('question',$Question);
		return $this->db->insert_id();
	}


	public function updateQuestion($QuestionID , $Question)
	{
		$this->db->where('Question_ID',$QuestionID);
        $this->db->update('question', $Question);
	}


	public function deleteQuestion($QuestionID)
	{
		$this->db->where('Question_ID',$QuestionID);
        $this->db->delete('question');
	}

	// SELECT `Question_ID`, `Question_title`, `Question_subject`, `Q_Account_ID`, `QuestionDate`, `img`, `new` FROM `question` WHERE 1
	public function HasPermissiontoDeleteQusetion($questionid){
		$this->db->where('Question_ID',$questionid);
		$this->db->where('Q_Account_ID',$this->session->userdata('Account_ID'));
		$this->db->select('*');
		$this->db->from('question');
		$res = $this->db->get();
		if($res->num_rows() > 0){
			return true;
		}
		return false;
	}
}
?>
