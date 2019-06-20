<?php
class accontMod extends CI_Model {



	/*

		$this->db->select('users.usrID, users_profiles.userpNick')
         ->from('users')
         ->join('users_profiles', 'users.usrID = users_profiles.usrpID');
		$query = $this->db->get();


	*/
        
	public function login($Email , $Pass)
	{
		$this->db->select('*')->from('Account')->join('user', 'Account.userid = user.UserId');
		$this->db->where('email' , $Email);
		$this->db->where('password' , $Pass);
		$this->db->where('userReqest' , '1');
		$this->db->where('code' , '1111');
        $res = $this->db->get();
        if ($res->num_rows() > 0) {
            foreach ($res->result() as $row) {
            	// `Email``Account_ID``userReqest``password``role``userid``code`
            	// `firstName`, `SecandName`
            	$data['Email'] =  $row->Email;
            	$data['name']  =  $row->firstName." ".$row->SecandName;
            	$data['role']  =  $row->role;
            	$data['Account_ID']  =  $row->Account_ID;
                $data['typesid']     =  $this->getID($row->Account_ID,$row->role);
            	$data['img']     =  base_url()."style/images/".$row->profilephoto;
        	}
        	$this->session->set_userdata($data);
        	return true;
        }
        else
        {
        	return false;
        }
	}


	public function getID($userid,$role)
	{
		$type = $this->gettype($role);
		if($type == "pharmacy_manager"|| $type=="pharmacy_employee")
		{
			$data['DID'] = -1;
			$data['PID'] = $this->getPharmacyID($userid);
			$data['CID'] = -1;
		}
		elseif($type == "doctor")
		{
			$data['DID'] =  $this->getDoctorID($userid);
			$data['PID'] = -1;
			$data['CID'] = -1;
		}
		elseif($type == "company_manager"|| $type=="company_employee")
		{
			$data['DID'] = -1;
			$data['PID'] = -1;
			$data['CID'] = $this->getCompanyID($userid);
		}
		else
		{
			$data['DID'] = -1;
			$data['PID'] = -1;
			$data['CID'] = -1;
		}
		return $data;
	}


	public function gettype($role)
	{
		//SELECT `user_role`, `User_ID` FROM `usertype` WHERE 1
		$this->db->where('User_ID' , $role);
        $this->db->select('user_role');
        $this->db->from('usertype');
        $res = $this->db->get();
        if ($res->num_rows() > 0) {
            foreach ($res->result() as $row) {
            	return $row->user_role;
        	}
        }
	}

	public function getPharmacyID($userid)
	{
		//`Pharmacy_ID``Pharmacy_AccountId`
		$this->db->where('Pharmacy_AccountId' , $userid);
        $this->db->select('Pharmacy_ID');
        $this->db->from('pharmacy');
        $res = $this->db->get();
        if ($res->num_rows() > 0) {
            foreach ($res->result() as $row) {
            	return $row->Pharmacy_ID;
        	}
        }
	} 

	public function getDoctorID($userid)
	{
		//SELECT `Doctor_ID`, `doc_memberShip`, `photo_Doc_memberShip`, `Doc_AccountId`, `photo_Doc_memberShip_Name` FROM `doctor` WHERE 1
		$this->db->where('Doc_AccountId' , $userid);
        $this->db->select('Doctor_ID');
        $this->db->from('doctor');
        $res = $this->db->get();
        if ($res->num_rows() > 0) {
            foreach ($res->result() as $row) {
            	return $row->Doctor_ID;
        	}
        }
	}

	public function getCompanyID($userid)
	{
		//SELECT `company_ID`, `company_Name`, `company_permission`, `photo_company_permission`, `company_AccountId`, `photo_company_permission_Name` FROM `company` WHERE 1
		$this->db->where('company_AccountId' , $userid);
        $this->db->select('company_ID');
        $this->db->from('company');
        $res = $this->db->get();
        if ($res->num_rows() > 0) {
            foreach ($res->result() as $row) {
            	return $row->company_ID;
        	}
        }
	} 

	public function checkUserExists($Email) {
        $res = $this->db->get_where('Account', array('email' => $Email));
        if ($res->num_rows() > 0) {
            return true;
        }
        return false;
    }

    public function seenAccount($Aid)
    {
    	$this->db->where('Account_ID', $Aid);
        $res = $this->db->update('account', array('newaccount' => 1));
    }

    public function RemoveAccount($Aid)
    {
        $this->check_no_Account_use_user_info($Aid);
    	$this->db->where("Account_ID", $Aid);
        $this->db->delete('account');
    }

    public function AcceptAccount($Aid)
    {
        $this->db->where('Account_ID', $Aid);
        $this->db->update('account', array('userReqest' => 1));
    }


    public function get_user_id($Aid)
    {
        $this->db->where('Account_ID' , $Aid );
        $this->db->select('userid');
        $this->db->from('account');
        $res = $this->db->get();
        if ($res->num_rows() > 0) {
            foreach ($res->result() as $row) {
                return $row->userid;
            }
        }
    }

    public function getimg($Aid)
    {
        $this->db->where('Account_ID' , $Aid );
        $this->db->select('profilephoto');
        $this->db->from('account');
        $res = $this->db->get();
        if ($res->num_rows() > 0) {
            foreach ($res->result() as $row) {
                return $row->profilephoto;
            }
        }
    }

    public function check_no_Account_use_user_info($AID)
    {
        // SELECT `Account_ID`, `Email`, `code`, `userReqest`, `password`, `role`, `userid`, `newaccount` FROM `account` WHERE 1;
        $this->load->model('userMod', 'usrMod');
        $sql = '(select userid from account where Account_ID = '.$AID.')';
        $this->db->where('userid' , $sql , false);
        $this->db->select('Account_ID');
        $this->db->from('account');
        $res = $this->db->get();
        if ($res->num_rows() == 1) {
            $this->usrMod->remove_user_info($this->get_user_id($AID));
        }
        
    }


    public function rightpassword($password)
    {
        $this->db->where('password' , $password);
        $this->db->where('Account_ID', $this->session->userdata('Account_ID'));
        $this->db->select('Account_ID');
        $this->db->from('account');
        $res = $this->db->get();
        if ($res->num_rows() == 1) {
            return true;
        }
        return false;
    }
    public function changeEmail($email,$pass)
    {
        if(!$this->checkUserExists($email) && $this->rightpassword($pass)){
            $this->db->where('Account_ID', $this->session->userdata('Account_ID'));
            $this->db->where('password', $pass);
            return $this->db->update('account', array('Email' => $email));
        }
        return 0;
    }


    public function changepassword($pass,$oldpass)
    {
        if($this->rightpassword($oldpass)){
            $this->db->where('Account_ID', $this->session->userdata('Account_ID'));
            $this->db->where('password', $oldpass);
            return $this->db->update('account', array('password' => $pass));
        }
        return 0;
    }



    public function get_role($AID)
    {
        $this->db->select('role')->from('Account')->join('user', 'Account.userid = user.UserId');
        $this->db->where('Account_ID' , $AID);
        $this->db->where('userReqest' , '1');
        $this->db->where('code' , '1111');
        $res = $this->db->get();
        if ($res->num_rows() > 0) {
            foreach ($res->result() as $row) {
                return $row->role;
            }
        }
        else
        {
            return -1;
        }
    }


    
}