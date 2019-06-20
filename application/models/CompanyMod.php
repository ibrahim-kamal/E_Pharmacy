<?php
class companyMod extends CI_Model {

	public function get_company_info($Accountid)
	{
		//SELECT `company_ID`, `company_Name`, `company_permission`, `photo_company_permission`, `company_AccountId`, `photo_company_permission_Name` FROM `company` WHERE 1
		$this->db->select('*');
		$this->db->from('company');	
		$this->db->where('company_AccountId' , $Accountid);
		$res = $this->db->get();
		$data = [];
        if ($res->num_rows() > 0) {
        	$i = 0;
            foreach ($res->result() as $row) {
            	$data['company_Name'] = $row->company_Name;
            	$data['company_permission'] = $row->company_permission;
            	$data['photo_company_permission_Name'] = $row->photo_company_permission_Name;
                $data['companyphone'] = $row->companyphone;
                $data['companyaddress'] = $row->companyaddress;
                $data['companycountry'] = $row->companycountry;
                $data['companycity'] = $row->companycity;
                $data['companyneighborhood'] = $row->companyneighborhood;
            }
        }

        return $data;


	}

	public function getCompanyname($companyid)
	{
		$this->db->select('company_Name');
		$this->db->from('company');	
		$this->db->where('company_ID' , $companyid);
		$res = $this->db->get();
		if ($res->num_rows() > 0) {
        	$i = 0;
            foreach ($res->result() as $row) {
            	return $row->company_Name;
            }
        }
	}


	public function getAccountid($CID)
    {
        $this->db->select('company_AccountId');
        $this->db->from('company');
        $this->db->where('company_ID' , $CID);    
        $res = $this->db->get();
        foreach ($res->result() as $row) {
            return $row->company_AccountId;
        }
        return -1;
    }


    


}
?>