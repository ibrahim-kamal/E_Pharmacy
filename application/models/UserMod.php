<?php
class userMod extends CI_Model {

	public function get_All_user()
	{

		$this->load->model('security', 'sec');
		$this->db->select('*')->from('Account')->join('user', 'Account.userid = user.UserId');
		$this->load->model('accontMod', 'AccMod');
		$res = $this->db->get();
		$data = [];
		$i = 0;
        if ($res->num_rows() > 0) {
            foreach ($res->result() as $row) {
            	// `Email``Account_ID``userReqest``password``role``userid``code`
            	// `firstName`, `SecandName`
            	//SELECT `UserId`, `firstName`, `SecandName`, `SSN`, `photoSSNCard`, `barthday`, `address`, `city`, `country`, `nightborhood`, `phone`, `SSNImageName` FROM `user` WHERE 1
            	if($row->Account_ID != $this->session->userdata('Account_ID')){
            		$data['UserName'][$i]  =  $row->firstName." ".$row->SecandName;
	            	$data['Email'][$i] =  $row->Email;
	            	$data['Role'][$i]  =  $this->AccMod->gettype($row->role);
	            	$data['SSN'][$i]  =  $row->SSN;
	            	$data['phone'][$i]  =  $row->phone;
	            	$data['address'][$i]  =  $row->address;  
	            	$data['Aid'][$i] = $this->sec->encode($row->Account_ID);
					$i ++;
				}	
            	
        	}
        }
        return $data;
	}

	public function get_new_user()
	{

		$this->load->model('security', 'sec');
		$this->load->model('accontMod', 'AccMod');
		$this->db->select('*')->from('Account')->join('user', 'Account.userid = user.UserId');	
		$this->db->where('newaccount' , 0);
		$res = $this->db->get();
		$data = [];
        if ($res->num_rows() > 0) {
        	$i = 0;
            foreach ($res->result() as $row) {
            	// `Email``Account_ID``userReqest``password``role``userid``code`
            	// `firstName`, `SecandName`
            	//SELECT `UserId`, `firstName`, `SecandName`, `SSN`, `photoSSNCard`, `barthday`, `address`, `city`, `country`, `nightborhood`, `phone`, `SSNImageName` FROM `user` WHERE 1	
            	if($row->Account_ID != $this->session->userdata('Account_ID')){
					$data['UserName'][$i]  =  $row->firstName." ".$row->SecandName;
	            	$data['Email'][$i] =  $row->Email;
	            	$data['Role'][$i]  =  $this->AccMod->gettype($row->role);
	            	$data['SSN'][$i]  =  $row->SSN;
	            	$data['phone'][$i]  =  $row->phone;
	            	$data['address'][$i]  =  $row->address; 
	            	$data['Aid'][$i] = $this->sec->encode($row->Account_ID); 
	            	$i ++;
				}
            	
        	}
        }
        return $data;
	}

	public function get_account_user_info($id)
	{

		$this->load->model('security', 'sec');
		$this->load->model('accontMod', 'AccMod');
		$this->db->select('*')->from('Account')->join('user', 'Account.userid = user.UserId');	
		$this->db->where('Account_ID' , $id);
		$res = $this->db->get();
		$data = [];
        if ($res->num_rows() > 0) {
        	$i = 0;
            foreach ($res->result() as $row) {
            	//SELECT `Account_ID`, `Email`, `code`, `userReqest`, `password`, `role`, `userid`, `newaccount` FROM `account` WHERE 1

				//SELECT `UserId`, `firstName`, `SecandName`, `SSN`, `photoSSNCard`, `barthday`, `address`, `city`, `country`, `nightborhood`, `phone`, `SSNImageName` FROM `user` WHERE 1
            	if($row->newaccount == 0)
            	{
            		$data['newAccount'] = 1;
            	}
            	else
            	{
            		$data['newAccount'] = 0;
            	}
            	if($row->role < 6)
            	{
            		$data['deleteAccount'] = 1;
            	}
            	else
            	{
            		$data['deleteAccount'] = 0;
            	}
            	if($row->userReqest == 0)
            	{
            		$data['Request'] = 1;
            	}
            	else
            	{
            		$data['Request'] = 0;
            	}
            	$data['UserName']  =  $row->firstName." ".$row->SecandName;
            	$data['Email'] =  $row->Email;
            	$data['Role']  =  $this->AccMod->gettype($row->role);
            	$data['SSN']  =  $row->SSN;
            	$data['phone']  =  $row->phone;
            	$data['address']  =  $row->address;
                $data['country']  =  $row->country;
            	$data['city']  =  $row->city;
            	$data['nightborhood']  =  $row->nightborhood;
            	$data['SSNImageName'] = $row->SSNImageName;
            	$data['barthday'] = $row->barthday;
            	$data['Aid'] = $this->sec->encode($row->Account_ID); 
            	$i ++;
        	}
        }
        return $data;
	}

	public function get_user_info($AccountID)
	{
		$this->load->model('doctorMod', 'DocMod');
		$this->load->model('companyMod', 'ComMod');
		$this->load->model('pharmacyMod', 'PhrMod');
		$data = $this->get_account_user_info($AccountID);
		if($data['Role'] == 'doctor'){
			$data += $this->DocMod->get_doctor_info($AccountID);
		}
		else if($data['Role'] == 'company_manager'){
			$data += $this->ComMod->get_company_info($AccountID);
		}
		else if($data['Role'] == 'pharmacy_manager'){
			$data += $this->PhrMod->get_pharmacy_info($AccountID);
		}
		return $data;

	}


    public function remove_user_info($usrId)
    {
        $this->db->where("UserId", $usrId);
        $this->db->delete('user');
    }


    // SELECT `UserId`, `firstName`, `SecandName`, `SSN`, `barthday`, `address`, `city`, `country`, `nightborhood`, `phone`, `SSNImageName` FROM `user` WHERE 1

    public function changeaddress($address)
    {
        $this->load->model('accontMod',"accMod");
        $this->db->where('UserId', 
            $this->accMod->get_user_id($this->session->userdata('Account_ID')));
        $res = $this->db->update('user', array('address' => $address));
    }

    public function phoneisExist($phone)
    {
        //SELECT `UserId`, `firstName`, `SecandName`, `SSN`, `photoSSNCard`, `barthday`, `address`, `city`, `country`, `nightborhood`, `phone`, `SSNImageName` FROM `user` WHERE 1
        $this->db->select('*'); 
        $this->db->where('phone' , $phone);
        $this->db->from('user');
        $res = $this->db->get();
        $data = [];
        if ($res->num_rows() > 0) {
            return true;
        }
        return false;
    }
    public function changephone($phone)
    {

        $this->load->model('accontMod',"accMod");
        $userid = $this->accMod->get_user_id($this->session->userdata('Account_ID'));
        if(!$this->phoneisExist($phone))
        {
            $this->db->where('UserId',$userid);
            return $this->db->update('user', array('phone' => $phone));
        }
        return 0;
    }
	
    public function getname($Account_ID){
        $this->load->model("accontMod","AccMod");
        $userId = $this->AccMod->get_user_id($Account_ID);
        // SELECT `UserId`, `firstName`, `SecandName`, `SSN`, `photoSSNCard`, `barthday`, `address`, `city`, `country`, `nightborhood`, `phone`, `SSNImageName` FROM `user` WHERE 1
        $this->db->select('firstName');
        $this->db->select('SecandName');
        $this->db->from('user');
        $this->db->where('UserId' , $userId);    
        $res = $this->db->get();
        foreach ($res->result() as $row) {
            return $row->firstName." ".$row->SecandName;
        }
        return -1;
    }
}

?>

