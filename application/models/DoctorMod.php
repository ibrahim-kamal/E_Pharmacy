<?php
class doctorMod extends CI_Model {
	
	public function get_doctor_info($Accountid)
	{
		//SELECT `Doctor_ID`, `doc_memberShip`, `photo_Doc_memberShip`, `Doc_AccountId`, `photo_Doc_memberShip_Name` FROM `doctor` WHERE 1
		$this->db->select('*');
		$this->db->from('doctor');	
		$this->db->where('Doc_AccountId' , $Accountid);
		$res = $this->db->get();
		$data = [];
        if ($res->num_rows() > 0) {
        	$i = 0;
            foreach ($res->result() as $row) {
            	$data['doc_memberShip'] = $row->doc_memberShip;
            	$data['photo_Doc_memberShip_Name'] = $row->photo_Doc_memberShip_Name;
            }
        }

        return $data;


	}

	//SELECT `Doctor_ID`, `doc_memberShip`, `photo_Doc_memberShip`, `Doc_AccountId`, `photo_Doc_memberShip_Name` FROM `doctor` WHERE 1
	public function getAccountid($DID)
    {
        $this->db->select('Doc_AccountId');
        $this->db->from('doctor');
        $this->db->where('Doctor_ID' , $DID);    
        $res = $this->db->get();
        foreach ($res->result() as $row) {
            return $row->Doc_AccountId;
        }
        return -1;
    }

    public function getDoctorName($DID){
    	$id = $this->getAccountid($DID);
    	$this->load->model("userMod","usrMod");
    	return $this->usrMod->getname($id);

    }

    public function getDoctorimg($DID){
        $id = $this->getAccountid($DID);
        $this->load->model("accontMod","accMod");
        return $this->accMod->getimg($id);

    }


}




?>