<?php
class pharmacyMod extends CI_Model {

	
	public function get_pharmacy_info($Accountid)
	{
		//SELECT `Pharmacy_Name`, `Pharmacy_ID`, `Pharmacy_AccountId`, `Pharmacy_Photo_memberShip`, `Pharmacy_state`, `Pharmacy_delevery`, `Pharmacy_memberShip`, `Pharmacy_Photo_Permission`, `Pharmacy_Permission`, `Pharmacy_Photo_memberShip_Name`, `Pharmacy_Photo_Permission_Name`, `pharmacy_pay`, `pharmacy_gain` FROM `pharmacy` WHERE 1

		$this->db->select('*');
		$this->db->from('pharmacy');	
		$this->db->where('Pharmacy_AccountId' , $Accountid);
		$res = $this->db->get();
		$data = [];
        if ($res->num_rows() > 0) {
        	$i = 0;
            foreach ($res->result() as $row) {
            	$data['Pharmacy_Name'] = $row->Pharmacy_Name;
            	$data['Pharmacy_state'] = $row->Pharmacy_state;
            	$data['Pharmacy_memberShip'] = $row->Pharmacy_memberShip;
            	$data['Pharmacy_Photo_memberShip_Name'] = $row->Pharmacy_Photo_memberShip_Name;
            	$data['Pharmacy_Permission'] = $row->Pharmacy_Permission;
                $data['Pharmacy_Photo_Permission_Name'] = $row->Pharmacy_Photo_Permission_Name;
                /*
                companyphone companyneighborhood companycity companycountry
                */
                $data['pharmacyphone'] = $row->pharmacyphone;
                $data['pharmacyaddress'] = $row->pharmacyaddress;
                $data['pharmacycountry'] = $row->pharmacycountry;
                $data['pharmacycity'] = $row->pharmacycity;
                $data['pharmacyneighborhood'] = $row->pharmacyneighborhood;
            }
        }

        return $data;


	}

    

    public function getAccountid($PID)
    {
        $this->db->select('Pharmacy_AccountId');
        $this->db->from('pharmacy');
        $this->db->where('Pharmacy_ID' , $PID);    
        $res = $this->db->get();
        foreach ($res->result() as $row) {
            return $row->Pharmacy_AccountId;
        }
        return -1;
    }


    public function state($state,$phrId){
        $this->db->where('Pharmacy_ID',$phrId);
        $this->db->update('pharmacy',array('Pharmacy_state' =>$state));
    }

    public function get_pharmacy_state($Accountid)
    {
        $this->db->select('Pharmacy_state');
        $this->db->from('pharmacy');    
        $this->db->where('Pharmacy_AccountId' , $Accountid);
        $res = $this->db->get();
        if ($res->num_rows() > 0) {
            foreach ($res->result() as $row) {
                return $row->Pharmacy_state;
            }
        }
    }


    //SELECT `Pharmacy_Name`, `Pharmacy_ID`, `Pharmacy_AccountId`, `Pharmacy_Photo_memberShip`, `Pharmacy_state`, `Pharmacy_delevery`, `Pharmacy_memberShip`, `Pharmacy_Photo_Permission`, `Pharmacy_Permission`, `Pharmacy_Photo_memberShip_Name`, `Pharmacy_Photo_Permission_Name`, `pharmacy_pay`, `pharmacy_gain` FROM `pharmacy` WHERE 1

    public function getPharmacyname($pharmacyid)
    {
        $this->db->select('Pharmacy_Name');
        $this->db->from('pharmacy'); 
        $this->db->where('Pharmacy_ID' , $pharmacyid);
        $res = $this->db->get();
        if ($res->num_rows() > 0) {
            $i = 0;
            foreach ($res->result() as $row) {
                return $row->Pharmacy_Name;
            }
        }
    }

}




?>