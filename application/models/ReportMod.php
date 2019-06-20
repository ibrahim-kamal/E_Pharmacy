<?php 
class ReportMod extends CI_Model {


	// SELECT `report_ID`, `report_title`, `report_subject`, `new` FROM `report` WHERE 1
	 
	/*
		SELECT `role`, `reportreport_ID`, `pharmacypharmacy_ID`, `useruserId` FROM `reportpersonorpharmacy` WHERE 1
	*/

	/* 
	SELECT
	 `role`, `reportreport_ID`, `pharmacypharmacy_ID`, `companycompany_ID` 
	FROM `reportcompanyorpharmacy` WHERE 1
	*/ 


	public function getAllreport()
	{
		return $this->Get_Pharmacy_Patient_Report() + $this->Get_Company_Pharmacy_Report();
	}

	public function Get_New_Report()
	{

		return $this->Get_Pharmacy_Patient_Report(true) + $this->Get_Company_Pharmacy_Report(true);
	}
	public function Get_New_Company_Report()
	{
		return $this->Get_Company_Pharmacy_Report(true,'C');
	}
	public function Get_New_Pharmacy_Report()
	{
		return $this->Get_Pharmacy_Patient_Report(true,'P')+$this->Get_Company_Pharmacy_Report(true,'P');
	}
	public function Get_New_Patient_Report()
	{
		return $this->Get_Pharmacy_Patient_Report(true,'U');
	}

	// public function Get_Pharmacy_Patient_Report($new = false , $role = '')
	// {
	// 	$data = [];
	// 	$this->load->model('pharmacyMod','phrMod');
	// 	$this->load->model('userMod','usrMod');
	// 	$sql = 'SELECT * FROM `report` 
	// 	INNER JOIN reportpersonorpharmacy 
	// 	ON
	// 	`report_ID` = `reportreport_ID`';
	// 	if($new)
	// 	{
	// 		if($role != '')
	// 		{
	// 			$sql .='WHERE new = 0 and role = '.$role.'';
	// 			$role = '';
	// 		}
	// 		else
	// 		{
	// 			$sql .= 'WHERE new = 0';
	// 		} 
	// 	}
	// 	if($role != '')
	// 	{
	// 		$sql .= 'WHERE role = '.$role.'';
	// 	}
	// 	$res = $this->db->query($sql);
	// 	$i = 0;
	// 	foreach($res->result() as $row)
	// 	{
	// 		$data[$row->role]['report_ID'][$i] = $row->report_ID;
	// 		$data[$row->role]['report_title'][$i] = $row->report_title;
	// 		$data[$row->role]['report_subject'][$i] = $row->report_subject;
	// 		$data[$row->role]['pharmacypharmacy_ID'][$i] = $row->pharmacypharmacy_ID;
	// 		$pahrmacyaccount = 
	// 						$this->phrMod->getAccountid($row->pharmacypharmacy_ID);
	// 		$data[$row->role]['pharmacyinfo'][$i] =
	// 								 $this->phrMod->get_pharmacy_info($pahrmacyaccount);
	// 		$data[$row->role]['useruserId'][$i] = $row->useruserId;
	// 		$data[$row->role]['userinfo'][$i] = $this->usrMod->get_account_user_info($row->useruserId);
	// 		$data[$row->role][][$i] = $row->;
	// 		$i++;
	// 	}
	// }


	public function Get_Company_Pharmacy_Report($new = false , $role = '')
	{
		$data = [];
		$this->load->model('pharmacyMod','phrMod');
		$this->load->model('companyMod','comMod');
		$sql = 'SELECT * FROM `report` 
		INNER JOIN reportcompanyorpharmacy
		ON
		`report_ID` = `reportreport_ID`';
		if($new)
		{
			if($role != '')
			{
				$sql .='WHERE new = 0 and role = '.$role.'';
				$role = '';
			}
			else
			{
				$sql .= 'WHERE new = 0';
			} 
		}
		if($role != '')
		{
			$sql .= 'WHERE role = '.$role.'';
		}
		$res = $this->db->query($sql);
		$i = 0;
		foreach($res->result() as $row)
		{
			$data[$row->role]['report_ID'][$i] = $row->report_ID;
			$data[$row->role]['report_title'][$i] = $row->report_title;
			$data[$row->role]['report_subject'][$i] = $row->report_subject;
			$data[$row->role]['pharmacypharmacy_ID'][$i] = $row->pharmacypharmacy_ID;
			$pahrmacyaccount = 
							$this->phrMod->getAccountid($row->pharmacypharmacy_ID);
			$data[$row->role]['pharmacyinfo'][$i] =
									 $this->phrMod->get_pharmacy_info($pahrmacyaccount);
			$data[$row->role]['companycompany_ID'][$i] = $row->companycompany_ID;
			$companyaccount = 
							$this->comMod->getAccountid($row->companycompany_ID);
			$data[$row->role]['companyinfo'][$i] =
									 $this->phrMod->get_pharmacy_info($companyaccount);

			$i++;
		}
	}


	public function patientReport($report,$reportinfo)
	{
		$this->db->insert('report',$report);
		$reportinfo['reportreport_ID'] = $this->db->insert_id();		
		$reportinfo['role'] = 'U';
		$this->db->insert('reportpersonorpharmacy',$reportinfo);
	}

	public function companyReport($report,$reportinfo)
	{
		$this->db->insert('report',$report);
		$reportinfo['reportreport_ID'] = $this->db->insert_id();
		$reportinfo['role'] = 'C';
		$this->db->insert('reportcompanyorpharmacy',$reportinfo);
	}

	public function pharmacyReport($report,$reportinfo)
	{
		$this->db->insert('report',$report);
		$id = $this->db->insert_id();
		$reportinfo['role'] = 'P';
		if($this->session->userdata('typesid')['CID'] != -1){
			$reportinfo['reportreport_ID'] = $id ;
			$this->db->insert('reportcompanyorpharmacy',$reportinfo);
		}
		else{
			$reportinfo['reportreport_ID'] = $id ;
			$this->db->insert('reportpersonorpharmacy',$reportinfo);
		}
	}

}

?>