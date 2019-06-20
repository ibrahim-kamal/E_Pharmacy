<?php


class medicinemod extends CI_Model {
	
	/*
		

	*/
	public function getMedicineName($MID){
		$this->db->select('medicine_name_AR');
		$this->db->select('medicine_name_En');
		$this->db->where('medicine_ID' , $MID);
		$this->db->from('medicine');
		$res = $this->db->get();
		foreach ($res->result() as $row) {
			return $row->medicine_name_En ." ". $row->medicine_name_AR ; 
		}

	}
	public function search($word)
	{		
		/*
			pharmacy cols
			SELECT `Pharmacy_Name`, `Pharmacy_ID`, `Pharmacy_AccountId`, `Pharmacy_state`, `Pharmacy_delevery`, `Pharmacy_memberShip`, `Pharmacy_Permission`, `Pharmacy_Photo_memberShip_Name`, `Pharmacy_Photo_Permission_Name`, `pharmacy_pay`, `pharmacy_gain` FROM `pharmacy` WHERE 1

			medicine cols
			SELECT `medicine_ID`, `medicine_name_AR`, `medicine_name_En`, `MedicineReqest`, `medicinePermission`, `medicinePermission_photo_name` FROM `medicine` WHERE 1

			pharmacymedicinequantity cols
			SELECT `Quantity`, `Quantitypharmacy_ID`, `Quantitymedicine_ID`, `Quantitycompany_ID`, `Pmedicine_price` FROM `pharmacymedicnequantity` WHERE 1

		*/
		$this->load->model("security","sec");
		$this->load->model("companyMod","comMod");
		$data = [];
		$sql = 'SELECT Pharmacy_Name , Pharmacy_ID , Pharmacy_AccountId , Pharmacy_state , Pharmacy_delevery , uses_AR , uses_EN , medicine_ID , medicine_name_AR , medicine_name_En , Quantity ,Quantitycompany_ID , Pmedicine_price FROM pharmacy
				INNER JOIN
				(
				    SELECT * FROM pharmacymedicnequantity
				    INNER JOIN
				    (
				        SELECT * FROM `medicine`
				        INNER JOIN 
				        (
				        	SELECT  `Uses_medicine_ID`,
							GROUP_CONCAT(`uses_EN` SEPARATOR "," ) as uses_EN,
							GROUP_CONCAT(`uses_AR` SEPARATOR "," ) as uses_AR
							FROM `medicineuses` GROUP BY `Uses_medicine_ID`
				        ) 
				        as table3
				        on table3.Uses_medicine_ID = medicine.medicine_ID 
				        where 
				        (
					        `medicine_name_En` like "%'.$word.'%" 
					        OR medicine_name_AR like "%'.$word.'%" 
					        OR uses_AR = "%'.$word.'%" 
					        OR uses_EN like "%'.$word.'%"
				        ) 
				        and medicine.MedicineReqest = 1
				    ) 
				    as table1
				    on pharmacymedicnequantity.Quantitymedicine_ID = table1.medicine_ID
				    WHERE Quantity > 0
				)
				AS table2
				on pharmacy.Pharmacy_ID = table2.Quantitypharmacy_ID;';

		$query = $this->db->query($sql);
		$i = 0;
		if($this->session->userdata('Account_ID'))
		{
			$data['loged'] = true;
		}
		else
		{
			$data['loged'] = false;
		}
		foreach ($query->result() as $row)
		{
			$data['Pharmacy_Name'][$i] = $row->Pharmacy_Name;
			$data['Pharmacy_ID'][$i] = $this->sec->encode($row->Pharmacy_ID);
			$data['Pharmacy_AccountId'][$i] = $this->sec->encode($row->Pharmacy_AccountId);
			$data['Pharmacy_state'][$i] = $row->Pharmacy_state;
			$data['Pharmacy_delevery'][$i] = $row->Pharmacy_delevery;
			$data['uses_AR'][$i] = $row->uses_AR;
			$data['uses_EN'][$i] = $row->uses_EN;
			$data['medicine_ID'][$i] = $this->sec->encode($row->medicine_ID);
			$data['medicine_name_AR'][$i] = $row->medicine_name_AR;
			$data['medicine_name_En'][$i] = $row->medicine_name_En;
			$data['Quantity'][$i] = $row->Quantity;
			$data['Quantitycompany_ID'][$i] = $this->sec->encode($row->Quantitycompany_ID);
			$data['company_Name'][$i] = $this->comMod->getCompanyname($row->Quantitycompany_ID);
			$data['Pmedicine_price'][$i] = $row->Pmedicine_price;
			$data['medicinebooked'][$i] = $this->Patient_Is_Booked_Medicine($row->medicine_ID,$row->Quantitycompany_ID,$row->Pharmacy_ID);

			$i++;
		}
		return $data;		
	}



	public function medicine_Uses_sideEffect_contraceptive($medID){
		// $sql = 'select `contraceptive_medicine_ID`,GROUP_CONCAT(`contraceptive_AR` SEPARATOR "," ) as `contraceptive_AR`,GROUP_CONCAT(`contraceptive_EN` SEPARATOR "," ) as `contraceptive_EN`,GROUP_CONCAT(`uses_AR` SEPARATOR "," ) as `uses_AR` , GROUP_CONCAT(`uses_EN` SEPARATOR "," ) as `uses_EN` ,
		// GROUP_CONCAT(`sideEffect_AR` SEPARATOR "," ) as `sideEffect_AR` ,
		// GROUP_CONCAT(`sideEffect_EN` SEPARATOR "," ) as `sideEffect_EN` 
		// from medicinecontraceptive 
		// INNER JOIN
		// medicineuses 
		// on medicinecontraceptive.contraceptive_medicine_ID = medicineuses.Uses_medicine_ID
		// INNER JOIN
		// medicinesideeffect
		// on medicineuses.Uses_medicine_ID = medicinesideeffect.effect_medicine_ID
		// where contraceptive_medicine_ID = '.$medID.'
		// GROUP BY `contraceptive_medicine_ID`
		// '; 
		$sql =  'SELECT uses_AR,uses_EN , sideEffect_AR , sideEffect_EN , contraceptive_AR ,contraceptive_EN from (
    (
        SELECT medicineuses.Uses_medicine_ID,GROUP_CONCAT(`uses_AR` SEPARATOR "," ) as `uses_AR` , 		GROUP_CONCAT(`uses_EN` SEPARATOR "," ) as `uses_EN` 
 		FROM medicineuses
    	GROUP BY medicineuses.Uses_medicine_ID
	)
	as table1
    INNER JOIN
    (
        SELECT medicinesideeffect.effect_medicine_ID , GROUP_CONCAT(`sideEffect_AR` SEPARATOR "," ) 		as `sideEffect_AR` , GROUP_CONCAT(`sideEffect_EN` SEPARATOR "," ) as `sideEffect_EN` 
        FROM medicinesideeffect
        GROUP BY medicinesideeffect.effect_medicine_ID
    )
    AS table2
    ON table1.Uses_medicine_ID = table2.effect_medicine_ID
    INNER JOIN
    (
        SELECT `contraceptive_medicine_ID`,GROUP_CONCAT(`contraceptive_AR` SEPARATOR "," ) as 			`contraceptive_AR`,GROUP_CONCAT(`contraceptive_EN` SEPARATOR "," ) as `contraceptive_EN`
        FROM medicinecontraceptive
        GROUP BY medicinecontraceptive.contraceptive_medicine_ID
    )
    AS table3
    ON table2.effect_medicine_ID  = table3.contraceptive_medicine_ID 
)
WHERE Uses_medicine_ID = '.$medID.';';
		$query = $this->db->query($sql);
		$data = []; 
		foreach ($query->result() as $row)
		{
			$data['contraceptive_AR'] = $row->contraceptive_AR ; 
			$data['contraceptive_EN'] = $row->contraceptive_EN ; 
			$data['uses_AR'] = $row->uses_AR ; 
			$data['uses_EN'] = $row->uses_EN ; 
			$data['sideEffect_AR'] = $row->sideEffect_AR ; 
			$data['sideEffect_EN'] = $row->sideEffect_EN ; 
		}
		return $data ;
	}


	public function order($type,$data)
	{
		if($type == 'patient'){
			$id = $this->patient_has_Booked($data[0]);
			if($id == -1){
				$this->db->insert('patientmedicinequantity_order',$data[0]);
				$id = $this->patient_has_Booked($data[0]);; 
			}
			$data[1]['orderID'] = $id;
			if(!$this->Patient_Is_Booked_Medicine($data[1]['MedicineID'],$data[1]['CompanyID'],$data[0]['order_pharmacy_ID'])){
				$id = $this->db->insert('patient_order',$data[1]);
			}
		}
		else if($type == 'pharmacy'){
			$id = $this->pharmacy_has_Booked($data[0]);
			if($id == -1){
				$this->db->insert('pharmacymedicinequantity_order',$data[0]);
				$id = $this->pharmacy_has_Booked($data[0]);
			}
			$data[1]['orderID'] = $id;
			if(!$this->pharmacy_Is_Booked_Medicine($data[1]['MedicineID'],$data[0]['ordercompany_ID'])){
				$id = $this->db->insert('pharmacy_order',$data[1]);
			}
		}
	}

	public function pharmacy_Is_Booked_Medicine($MedicineID,$CompanyID)
	{
		// SELECT 'true' FROM `patient_order` WHERE `MedicineID` = 19  and `CompanyID` = 1 and `orderID` = (SELECT `orderID`  FROM `patientmedicinequantity_order` WHERE `orderAccountId` =1 and `order_pharmacy_ID` =1) ; 
		// SELECT `pharmacy_order_ID`, `orderID`, `MedicineID` FROM `pharmacy_order` WHERE 1

		if(!$this->session->userdata('Account_ID')) return false;
		$sql = 
			"(
				SELECT `orderID`  FROM `pharmacymedicinequantity_order` WHERE 
				`orderpharmacy_ID` = ".$this->session->userdata('typesid')['PID'] 
				."&&
				`ordercompany_ID`  = ".$CompanyID." 
			)";
		$this->db->where('MedicineID',$MedicineID,false);
		$this->db->where('orderID',$sql,false);
		$this->db->select('*');
		$this->db->from('pharmacy_order');
		$result = $this->db->get();
		if($result->num_rows() > 0)
		{
			return true;
		}
		else
		{
			return false;
		}

	}

	public function pharmacy_has_Booked($data)
	{
		$id = -1;
		$this->db->where($data);
		$this->db->select('orderID');
		$this->db->from('pharmacymedicinequantity_order');
		$result = $this->db->get();
		if($result->num_rows() > 0)
		{
			foreach ($result->result() as $row) {
				$id = $row->orderID;
			}
		}
		return $id;
	}


	public function patient_has_Booked($data)
	{
		$id = -1;
		$this->db->where($data);
		$this->db->select('orderID');
		$this->db->from('patientmedicinequantity_order');
		$result = $this->db->get();
		if($result->num_rows() > 0)
		{
			foreach ($result->result() as $row) {
				$id = $row->orderID;
			}
		}
		return $id;
	}

	public function Patient_Is_Booked_Medicine($MedicineID,$CompanyID,$order_pharmacy_ID)
	{
		// SELECT 'true' FROM `patient_order` WHERE `MedicineID` = 19  and `CompanyID` = 1 and `orderID` = (SELECT `orderID`  FROM `patientmedicinequantity_order` WHERE `orderAccountId` =1 and `order_pharmacy_ID` =1) ; 
		if(!$this->session->userdata('Account_ID')) return false;
		$sql = "(SELECT `orderID`  FROM `patientmedicinequantity_order` WHERE `orderAccountId` = ".$this->session->userdata('Account_ID')." and `order_pharmacy_ID` =".$order_pharmacy_ID.")";
		$this->db->where('MedicineID',$MedicineID,false);
		$this->db->where('CompanyID',$CompanyID,false);
		$this->db->where('orderID',$sql,false);
		$this->db->select('*');
		$this->db->from('patient_order');
		$result = $this->db->get();
		if($result->num_rows() > 0)
		{
			return true;
		}
		else
		{
			return false;
		}

	}

	/*
		pharmacy cols
		SELECT `Pharmacy_Name`, `Pharmacy_ID`, `Pharmacy_AccountId`, `Pharmacy_state`, `Pharmacy_delevery`, `Pharmacy_memberShip`, `Pharmacy_Permission`, `Pharmacy_Photo_memberShip_Name`, `Pharmacy_Photo_Permission_Name`, `pharmacy_pay`, `pharmacy_gain` FROM `pharmacy` WHERE 1

		medicine cols
		SELECT `medicine_ID`, `medicine_name_AR`, `medicine_name_En`, `MedicineReqest`, `medicinePermission`, `medicinePermission_photo_name` FROM `medicine` WHERE 1

		pharmacymedicinequantity cols
		SELECT `Quantity`, `Quantitypharmacy_ID`, `Quantitymedicine_ID`, `Quantitycompany_ID`, `Pmedicine_price` FROM `pharmacymedicnequantity` WHERE 1

		company 
		SELECT `company_ID`, `company_Name`, `company_permission`, `company_AccountId`, `photo_company_permission_Name` FROM `company` WHERE 1

		SELECT `Quantity`, `medicinemedicine_ID`, `companycompany_ID`, `Cmedicine_price` FROM `companymedicnequantity` WHERE 1

	*/
	// public function medicine_details($medicineId){
	// 	$this->db->select('*');
	// 	$this->db->from('medicine');
	// 	$this->db->where('medicine_ID',$medicineId);
	// 	$data = [];
	// 	$i = 0;
	// 	foreach ($result->result() as $row) {
	// 		$data['medicine_ID'][$i]	    = $row->medicine_ID;
	// 		$data['medicine_name_AR'][$i]   = $row->medicine_name_AR;
	// 		$data['medicine_name_En'][$i]   = $row->medicine_name_En;
	// 		$data['medicinePermission'][$i] = $row->medicinePermission;
	// 		$data['img'][$i] 				= base_url()."style/images/".$row->medicinePermission_photo_name;
	// 		$data['price'][$i] 				= $row->price;
	// 		$i++;
	// 	}
	// }


	public function medicine_details($medicineId,$type,$new=false,$typeId =-1){
		$data = [];
		$i = 0;
		$imgdir = base_url()."style/images/";
		$this->load->model('security','sec');
		if ($type == 'other') {
			$this->db->select('medicine_ID');
			$this->db->select('medicine_name_AR');
			$this->db->select('medicine_name_En');
			$this->db->select('MedicineReqest');
			$this->db->select('company_ID');
			$this->db->select('company_Name');
			$this->db->select('medicinePermission');
			$this->db->select('medicinePermission_photo_name');
			$this->db->from('medicine');
			$this->db->join('companymedicnequantity','medicine_ID=medicinemedicine_ID');
			$this->db->join('company','company_ID=companycompany_ID');
			$this->db->where('medicine_ID',$medicineId);
			$res = $this->db->get();
			foreach ($res->result() as $row) {
				$data['medID']		= $this->sec->encode($row->medicine_ID); 	
				$data['nameAr']			= $row->medicine_name_AR; 	
				$data['nameEng'] 		= $row->medicine_name_En; 	
				if($row->MedicineReqest == 1)
				{
					$data['req']			= 'accept'; 	
				}
				else{
					$data['req']			= 'pending';	
				}
				$data['comId']		= $this->sec->encode($row->company_ID); 	
				$data['MedCompanyname'] = $row->company_Name; 	
				$data['permission'] = $row->medicinePermission; 	
				$data['img'] = $imgdir.$row->medicinePermission_photo_name; 
				$data['remove'] = false;	
			}


		}
		else if ($type == 'company') {
			$this->db->select('medicine_ID');
			$this->db->select('medicine_name_AR');
			$this->db->select('medicine_name_En');
			$this->db->select('MedicineReqest');
			$this->db->select('company_ID');
			$this->db->select('company_Name');
			$this->db->select('Cmedicine_price');
			$this->db->select('Quantity');
			$this->db->select('medicinePermission');
			$this->db->select('medicinePermission_photo_name'); 
			$this->db->from('medicine');
			$this->db->join('companymedicnequantity','medicine_ID=medicinemedicine_ID');
			$this->db->join('company','company_ID=companycompany_ID');
			$this->db->where('company_ID',$typeId);
			$this->db->where('medicine_ID',$medicineId);
			$res = $this->db->get();
			foreach ($res->result() as $row) {
				$data['medID']			= $this->sec->encode($row->medicine_ID); 	
				$data['nameAr']		= $row->medicine_name_AR; 	
				$data['nameEng']		= $row->medicine_name_En; 	
				if($row->MedicineReqest == 1)
				{
					$data['req']			= 'accept'; 	
				}
				else{
					$data['req']		= 'pending';	
				}
				$data['comId']		= $this->sec->encode($row->company_ID); 	
				$data['MedCompanyname']= $row->company_Name; 	
				$data['price'] = $row->Cmedicine_price; 	
				$data['quantity'] = $row->Quantity; 
				$data['permission']= $row->medicinePermission; 	
				$data['img'] = $imgdir.$row->medicinePermission_photo_name;
				$data['remove'] = true;	 	
				$i++;
			}
			if ($data == [] ) {
				$this->db->select('medicine_ID');
				$this->db->select('medicine_name_AR');
				$this->db->select('medicine_name_En');
				$this->db->select('MedicineReqest');
				$this->db->select('company_ID');
				$this->db->select('company_Name');
				$this->db->select('Cmedicine_price');
				$this->db->select('Quantity');
				$this->db->select('medicinePermission');
				$this->db->select('medicinePermission_photo_name'); 
				$this->db->from('medicine');
				$this->db->join('companyhasmedicne','medicine_ID=medicinemedicine_ID');
				$this->db->join('company','company_ID=companycompany_ID');
				$this->db->where('company_ID',$typeId);
				$this->db->where('medicine_ID',$medicineId);
				$res = $this->db->get();
				foreach ($res->result() as $row) {
					$data['medID'] 			= $this->sec->encode($row->medicine_ID); 	
					$data['nameAr']			= $row->medicine_name_AR; 	
					$data['nameEng'] 		= $row->medicine_name_En; 	
					if($row->MedicineReqest == 1)
					{
						$data['req']			= 'accept'; 	
					}
					else{
						$data['req']			= 'pending';	
					}
					$data['comId']			= $this->sec->encode($row->company_ID); 	
					$data['MedCompanyname'] = $row->company_Name; 	
					$data['price'] = $row->Cmedicine_price; 	
					$data['quantity'] = $row->Quantity; 	
					$data['permission'] = $row->medicinePermission; 	
					$data['img'] = $imgdir.$row->medicinePermission_photo_name; 
					$data['remove'] = true;
				}
				if ($data == [] ) {
					return $this->medicine_details($medicineId,'other',$new=false,$typeId =-1);
				}
			}
		}
		else if ($type == 'pharamcy') {
			/*
				select `medicine_ID`, `medicine_name_AR`, `medicine_name_En`, `MedicineReqest`, `company_ID`,pharmacymedicnequantity.Quantity as Quantity ,`company_Name`, `Pmedicine_price`
				from pharmacy 
				join pharmacymedicnequantity 
				on pharmacy.Pharmacy_ID = pharmacymedicnequantity.Quantitypharmacy_ID 
				join medicine 
				on pharmacymedicnequantity.Quantitymedicine_ID = medicine.medicine_ID
				join company 
				on pharmacymedicnequantity.Quantitycompany_ID = company.company_ID
			*/

			$this->db->select('medicine_ID');
			$this->db->select('medicine_name_AR');
			$this->db->select('medicine_name_En');
			$this->db->select('MedicineReqest');
			$this->db->select('company_ID');
			$this->db->select('company_Name');
			$this->db->select('Quantity');
			$this->db->select('Pmedicine_price');
			$this->db->select('medicinePermission');
			$this->db->select('medicinePermission_photo_name');
			$this->db->from('pharmacy');
			$this->db->join('pharmacymedicnequantity','Pharmacy_ID = Quantitypharmacy_ID');
			$this->db->join('medicine','Quantitymedicine_ID=medicine_ID');
			// $this->db->join('companymedicnequantity','medicine_ID=medicinemedicine_ID');
			$this->db->join('company','Quantitycompany_ID=company_ID');
			$this->db->where('Pharmacy_ID',$typeId);
			$this->db->where('medicine_ID',$medicineId);
			$res = $this->db->get();
			foreach ($res->result() as $row) {
				$data['medID'] 			= $this->sec->encode($row->medicine_ID); 	
				$data['nameAr']			= $row->medicine_name_AR; 	
				$data['nameEng'] 		= $row->medicine_name_En; 	
				if($row->MedicineReqest == 1)
				{
					$data['req']			= 'accept'; 	
				}
				else{
					$data['req']			= 'pending';	
				}
				$data['comId']			= $this->sec->encode($row->company_ID); 	
				$data['MedCompanyname'] = $row->company_Name; 	
				$data['price'] = $row->Pmedicine_price; 	
				$data['quantity'] = $row->Quantity; 
				$data['permission'] = $row->medicinePermission; 	
				$data['img'] = $imgdir.$row->medicinePermission_photo_name; 	
				$data['remove'] = true;
			}
			if ($data == [] ) {
				return $this->medicine_details($medicineId,'other',$new=false,$typeId =-1);
			}
		}
		return $data;

	}


	public function Medicine($type,$new=false,$typeId =-1){
		$data = [];
		$i = 0;
		$this->load->model('security','sec');
		if ($type == 'admin') {
			$this->db->select('medicine_ID');
			$this->db->select('medicine_name_AR');
			$this->db->select('medicine_name_En');
			$this->db->select('MedicineReqest');
			$this->db->select('company_ID');
			$this->db->select('company_Name');
			$this->db->from('medicine');
			$this->db->join('companymedicnequantity','medicine_ID=medicinemedicine_ID');
			$this->db->join('company','company_ID=companycompany_ID');
			$res = $this->db->get();
			foreach ($res->result() as $row) {
				$data['medID'][$i] 			= $this->sec->encode($row->medicine_ID); 	
				$data['nameAr'][$i]			= $row->medicine_name_AR; 	
				$data['nameEng'][$i] 		= $row->medicine_name_En; 	
				if($row->MedicineReqest == 1)
				{
					$data['req'][$i]			= 'accept'; 	
				}
				else{
					$data['req'][$i]			= 'pending';	
				}
				$data['comId'][$i]			= $this->sec->encode($row->company_ID); 	
				$data['MedCompanyname'][$i] = $row->company_Name; 	
				$i++;
			}


		}
		else if ($type == 'company') {
			$this->db->select('medicine_ID');
			$this->db->select('medicine_name_AR');
			$this->db->select('medicine_name_En');
			$this->db->select('MedicineReqest');
			$this->db->select('company_ID');
			$this->db->select('company_Name');
			$this->db->select('Cmedicine_price');
			$this->db->select('Quantity');
			$this->db->from('medicine');
			$this->db->join('companymedicnequantity','medicine_ID=medicinemedicine_ID');
			$this->db->join('company','company_ID=companycompany_ID');
			$this->db->where('company_ID',$typeId);
			$res = $this->db->get();
			foreach ($res->result() as $row) {
				$data['medID'][$i] 			= $this->sec->encode($row->medicine_ID); 	
				$data['nameAr'][$i]			= $row->medicine_name_AR; 	
				$data['nameEng'][$i] 		= $row->medicine_name_En; 	
				if($row->MedicineReqest == 1)
				{
					$data['req'][$i]			= 'accept'; 	
				}
				else{
					$data['req'][$i]			= 'pending';	
				}
				$data['comId'][$i]			= $this->sec->encode($row->company_ID); 	
				$data['MedCompanyname'][$i] = $row->company_Name; 	
				$data['price'][$i] = $row->Cmedicine_price; 	
				$data['quantity'][$i] = $row->Quantity; 	
				$i++;
			}
			$this->db->select('medicine_ID');
			$this->db->select('medicine_name_AR');
			$this->db->select('medicine_name_En');
			$this->db->select('MedicineReqest');
			$this->db->select('company_ID');
			$this->db->select('company_Name');
			$this->db->select('Cmedicine_price');
			$this->db->select('Quantity');
			$this->db->from('medicine');
			$this->db->join('companyhasmedicne','medicine_ID=medicinemedicine_ID');
			$this->db->join('company','company_ID=companycompany_ID');
			$this->db->where('company_ID',$typeId);
			$res = $this->db->get();
			foreach ($res->result() as $row) {
				$data['medID'][$i] 			= $this->sec->encode($row->medicine_ID); 	
				$data['nameAr'][$i]			= $row->medicine_name_AR; 	
				$data['nameEng'][$i] 		= $row->medicine_name_En; 	
				if($row->MedicineReqest == 1)
				{
					$data['req'][$i]			= 'accept'; 	
				}
				else{
					$data['req'][$i]			= 'pending';	
				}
				$data['comId'][$i]			= $this->sec->encode($row->company_ID); 	
				$data['MedCompanyname'][$i] = $row->company_Name; 	
				$data['price'][$i] = $row->Cmedicine_price; 	
				$data['quantity'][$i] = $row->Quantity; 	
				$i++;
			}
		}
		else if ($type == 'pharamcy') {
			/*
				select `medicine_ID`, `medicine_name_AR`, `medicine_name_En`, `MedicineReqest`, `company_ID`,pharmacymedicnequantity.Quantity as Quantity ,`company_Name`, `Pmedicine_price`
				from pharmacy 
				join pharmacymedicnequantity 
				on pharmacy.Pharmacy_ID = pharmacymedicnequantity.Quantitypharmacy_ID 
				join medicine 
				on pharmacymedicnequantity.Quantitymedicine_ID = medicine.medicine_ID
				join company 
				on pharmacymedicnequantity.Quantitycompany_ID = company.company_ID
			*/

			$this->db->select('medicine_ID');
			$this->db->select('medicine_name_AR');
			$this->db->select('medicine_name_En');
			$this->db->select('MedicineReqest');
			$this->db->select('company_ID');
			$this->db->select('company_Name');
			$this->db->select('Quantity');
			$this->db->select('Pmedicine_price');
			$this->db->from('pharmacy');
			$this->db->join('pharmacymedicnequantity','Pharmacy_ID = Quantitypharmacy_ID');
			$this->db->join('medicine','Quantitymedicine_ID=medicine_ID');
			// $this->db->join('companymedicnequantity','medicine_ID=medicinemedicine_ID');
			$this->db->join('company','Quantitycompany_ID=company_ID');
			$this->db->where('Pharmacy_ID',$typeId);
			$res = $this->db->get();
			foreach ($res->result() as $row) {
				$data['medID'][$i] 			= $this->sec->encode($row->medicine_ID); 	
				$data['nameAr'][$i]			= $row->medicine_name_AR; 	
				$data['nameEng'][$i] 		= $row->medicine_name_En; 	
				if($row->MedicineReqest == 1)
				{
					$data['req'][$i]			= 'accept'; 	
				}
				else{
					$data['req'][$i]			= 'pending';	
				}
				$data['comId'][$i]			= $this->sec->encode($row->company_ID); 	
				$data['MedCompanyname'][$i] = $row->company_Name; 	
				$data['price'][$i] = $row->Pmedicine_price; 	
				$data['quantity'][$i] = $row->Quantity; 	
				$i++;
			}
		}
		return $data;

	}


	//`MedicineReqest` `medicine_ID` medicine
	public function Accept($medID){
		$this->db->where('medicine_ID',$medID);
        $this->db->update('medicine',array('MedicineReqest' => 1));
	}

	public function Remove($medID,$type,$typeId=-1){
		if($type == 'admin'){
			$this->db->where('medicine_ID',$medID);
        	$this->db->delete('medicine');
		}
		else if($type =='company'){
			$this->db->where('medicinemedicine_ID',$medID);
			$this->db->where('companycompany_ID',$typeId);
        	$this->db->delete('companymedicnequantity');
			$this->db->where('medicinemedicine_ID',$medID);
        	$this->db->where('companycompany_ID',$typeId);
        	$this->db->delete('companyhasmedicne');
		}
		else if($type =='pharmacy'){
			$this->db->where('Quantitymedicine_ID',$medID);
			$this->db->where('Quantitypharmacy_ID',$typeId);
        	$this->db->delete('pharmacymedicnequantity');
		} 
	}



	public function changeprice($price,$medID,$type,$typeId){
		if($type == 'company'){
        	$this->db->where('companycompany_ID',$typeId);
        	$this->db->where('medicinemedicine_ID',$medID);
        	$this->db->update('companymedicnequantity',array('Cmedicine_price' => $price));
        	$this->db->where('medicinemedicine_ID',$medID);
        	$this->db->where('companycompany_ID',$typeId);
        	$this->db->update('companyhasmedicne',array('Cmedicine_price' => $price));
		}
		else if($type == 'pharmacy'){
			$this->db->where('Quantitypharmacy_ID',$typeId);
        	$this->db->where('Quantitymedicine_ID',$medID);
        	$this->db->update('pharmacymedicnequantity',array('Pmedicine_price' => $price));
		}
	}

	public function changeQuantity($Quantity,$medID,$type,$typeId){
		$this->db->set('Quantity', 'Quantity +'.$Quantity, FALSE);
		if($type == 'company'){
			$this->db->set('Quantity', 'Quantity +'.$Quantity, FALSE);
        	$this->db->where('companycompany_ID',$typeId);
        	$this->db->where('medicinemedicine_ID',$medID);
        	$this->db->update('companymedicnequantity');
        	$this->db->set('Quantity', 'Quantity +'.$Quantity, FALSE);
        	$this->db->where('medicinemedicine_ID',$medID);
        	$this->db->where('companycompany_ID',$typeId);
        	$this->db->update('companyhasmedicne');
		}
		else if($type == 'pharmacy'){
			$this->db->where('Quantitypharmacy_ID',$typeId);
        	$this->db->where('Quantitymedicine_ID',$medID);
        	$this->db->update('pharmacymedicnequantity');
		}
	}



	public function Arrive($orderID,$type){
		if($type == 'patient'){
			$this->db->where('patient_order_ID',$orderID);
        	$this->db->delete('patient_order');	
		}
		else if($type == 'phrmacy'){

			$this->db->where('pharmacy_order_ID',$orderID);

        	$this->db->delete('pharmacy_order');
		}
	}



	public function getPatientBooks($AID){
		/*
			SELECT * from patientmedicinequantity_order 
			INNER JOIN patient_order 
			on patientmedicinequantity_order.orderID = patient_order.orderID
			WHERE orderAccountId = $AID and OrderOrBook = 0
		*/
		/*
			orderID	
			orderAccountId	
			order_pharmacy_ID
			OrderOrBook
			patient_order_ID
			orderID	MedicineID
			CompanyID
			orderQuantity	
		*/
		$this->load->model("companyMod","comMod");
		$this->load->model("pharmacyMod","phrMod");
		$this->load->model('security','sec');
		$this->db->select('orderAccountId');
		$this->db->select('order_pharmacy_ID');
		$this->db->select('OrderOrBook');
		$this->db->select('patient_order_ID');
		$this->db->select('patientmedicinequantity_order.orderID as orderID');
		$this->db->select('MedicineID');
		$this->db->select('CompanyID');
		$this->db->select('orderQuantity');
		$this->db->from('patientmedicinequantity_order');
		$this->db->join('patient_order','patientmedicinequantity_order.orderID = patient_order.orderID');
		$this->db->where('orderAccountId',$AID);
		$this->db->where('OrderOrBook',0);
		$res = $this->db->get();
		$i = 0;
		$data = [];
		foreach ($res->result() as $row) {
			$data['PID'][$row->order_pharmacy_ID] = 
										$this->sec->encode($row->order_pharmacy_ID);

			$data['PAID'][$row->order_pharmacy_ID] = 
										base_url()."Accountcont/profile/".$this->sec->encode($this->phrMod->getAccountid($row->order_pharmacy_ID));

			$data['Pname'][$row->order_pharmacy_ID] = 
										$this->phrMod->getPharmacyname($row->order_pharmacy_ID);

			$data[$row->order_pharmacy_ID]['AID'][$i] = 
										$this->sec->encode($row->orderAccountId);
			
			$data[$row->order_pharmacy_ID]['order'][$i] = 
										$row->OrderOrBook;
			
			$data[$row->order_pharmacy_ID]['UID'][$i] =
										$this->sec->encode( $row->patient_order_ID);
			
			$data['OID'][$row->order_pharmacy_ID] = 
										$this->sec->encode($row->orderID);
			
			$data[$row->order_pharmacy_ID]['MID'][$i] =
										base_url()."medicinecont/medicine/".$this->sec->encode($row->MedicineID);

			$data[$row->order_pharmacy_ID]['QMID'][$i] =
										$this->sec->encode($row->MedicineID);

			$data[$row->order_pharmacy_ID]['MName'][$i] =
										$this->getMedicineName($row->MedicineID);
			
			$data[$row->order_pharmacy_ID]['CID'][$i] = 
										$this->sec->encode($row->CompanyID);
			$data[$row->order_pharmacy_ID]['CAID'][$i] = 
										base_url()."Accountcont/profile/".$this->sec->encode($this->comMod->getAccountid($row->CompanyID));
			$data[$row->order_pharmacy_ID]['Cname'][$i] = 
										$this->comMod->getCompanyname($row->CompanyID);
			$data[$row->order_pharmacy_ID]['Quantity'][$i] = $row->orderQuantity;
			$i++;
		}
		return $data;
	}


	//SELECT `patient_order_ID`, `orderID`, `MedicineID`, `CompanyID`, `orderQuantity` FROM `patient_order` WHERE 1

	public function get_count_medicine_order($orderID,$num){
		$this->db->select('count(orderID) as OID');
		$this->db->select('orderID',$orderID);
		$this->db->from('patient_order');
		$res = $this->db->get();
		foreach ($res->result() as $row) {
			if($row->OID == $num){
				return true;
			}
		}
		return false;
	}

	//SELECT `orderID`, `orderAccountId`, `order_pharmacy_ID`, `OrderOrBook` FROM `patientmedicinequantity_order` WHERE 1

	public function Patientorder($orderId,$med){
		$this->load->model('security','sec');
		$this->db->where('orderID',$orderId);
	    $this->db->update('patientmedicinequantity_order',array('OrderOrBook' => 1));
		foreach ($med as $ID => $Med_Que) {
			if($Med_Que > 0 ){
				$this->db->where('orderID',$orderId);
				$this->db->where('MedicineID',$this->sec->decode($ID));
	    		$this->db->update('patient_order',array('orderQuantity' => $Med_Que));	
			}	
			else{
				$this->db->where('orderID',$orderId);
				$this->db->where('MedicineID',$this->sec->decode($ID));
				$this->db->delete('patient_order');
			}
		}
	}




	public function getPatientorder($AID){
		/*
			SELECT * from patientmedicinequantity_order 
			INNER JOIN patient_order 
			on patientmedicinequantity_order.orderID = patient_order.orderID
			WHERE orderAccountId = $AID and OrderOrBook = 0
		*/
		/*
			orderID	
			orderAccountId	
			order_pharmacy_ID
			OrderOrBook
			patient_order_ID
			orderID	MedicineID
			CompanyID
			orderQuantity	
		*/
		$this->load->model("companyMod","comMod");
		$this->load->model("pharmacyMod","phrMod");
		$this->load->model('security','sec');
		$this->db->select('orderAccountId');
		$this->db->select('order_pharmacy_ID');
		$this->db->select('OrderOrBook');
		$this->db->select('patient_order_ID');
		$this->db->select('patientmedicinequantity_order.orderID as orderID');
		$this->db->select('MedicineID');
		$this->db->select('CompanyID');
		$this->db->select('orderQuantity');
		$this->db->from('patientmedicinequantity_order');
		$this->db->join('patient_order','patientmedicinequantity_order.orderID = patient_order.orderID');
		$this->db->where('orderAccountId',$AID);
		$this->db->where('OrderOrBook',1);
		$res = $this->db->get();
		$i = 0;
		$data = [];
		foreach ($res->result() as $row) {
			$data['PID'][$row->order_pharmacy_ID] = 
										$this->sec->encode($row->order_pharmacy_ID);

			$data['PAID'][$row->order_pharmacy_ID] = 
										base_url()."Accountcont/profile/".$this->sec->encode($this->phrMod->getAccountid($row->order_pharmacy_ID));

			$data['Pname'][$row->order_pharmacy_ID] = 
										$this->phrMod->getPharmacyname($row->order_pharmacy_ID);

			$data[$row->order_pharmacy_ID]['AID'][$i] = 
										$this->sec->encode($row->orderAccountId);
			
			$data[$row->order_pharmacy_ID]['order'][$i] = 
										$row->OrderOrBook;
			
			$data[$row->order_pharmacy_ID]['UID'][$i] =
										$this->sec->encode( $row->patient_order_ID);
			
			$data['OID'][$row->order_pharmacy_ID] = 
										$this->sec->encode($row->orderID);
			
			$data[$row->order_pharmacy_ID]['MID'][$i] =
										base_url()."medicinecont/medicine/".$this->sec->encode($row->MedicineID);

			$data[$row->order_pharmacy_ID]['QMID'][$i] =
										$this->sec->encode($row->MedicineID);

			$data[$row->order_pharmacy_ID]['MName'][$i] =
										$this->getMedicineName($row->MedicineID);
			
			$data[$row->order_pharmacy_ID]['CID'][$i] = 
										$this->sec->encode($row->CompanyID);
			$data[$row->order_pharmacy_ID]['CAID'][$i] = 
										base_url()."Accountcont/profile/".$this->sec->encode($this->comMod->getAccountid($row->CompanyID));
			$data[$row->order_pharmacy_ID]['Cname'][$i] = 
										$this->comMod->getCompanyname($row->CompanyID);
			$data[$row->order_pharmacy_ID]['Quantity'][$i] = $row->orderQuantity;
			$i++;
		}
		return $data;
	}

	public function cancelMedicine(){

	}

	public function sell(){

	}
	public function sellmedicine($medID){

	}



// 	SELECT companymedicnequantity.medicinemedicine_ID as owner , medicine.* ,  companyhasmedicne.* FROM companymedicnequantity INNER JOIN
// (SELECT medicine.* , companyhasmedicne.* FROM medicine INNER JOIN companyhasmedicne ON medicine.medicine_ID = companyhasmedicne.medicinemedicine_ID) as tableA 
// ON companymedicnequantity.medicinemedicine_ID = tableA.medicinemedicine_ID


	// public function getallmedicine(){
	// $sql1 =  SELECT * FROM medicine INNER JOIN companymedicnequantity ON medicine.medicine_ID = 
	// companymedicnequantity.medicinemedicine_ID;
	// $sql2 = SELECT companymedicnequantity.medicinemedicine_ID as owner , medicine.* ,  companyhasmedicne.* FROM companymedicnequantity INNER JOIN
	// (SELECT * FROM medicine INNER JOIN companyhasmedicne ON medicine.medicine_ID = companyhasmedicne.medicinemedicine_ID) as tableA 
	// ON companymedicnequantity.medicinemedicine_ID tableA.medicine_ID

	// 	$sql = '
	// 				SELECT * FROM `medicine`
	// 		        INNER JOIN 
	// 		        (
	// 		        	SELECT  `Uses_medicine_ID`,
	// 					GROUP_CONCAT(`uses_EN` SEPARATOR "," ) as uses_EN,
	// 					GROUP_CONCAT(`uses_AR` SEPARATOR "," ) as uses_AR
	// 					FROM `medicineuses` GROUP BY `Uses_medicine_ID`
	// 		        ) 
	// 		        as table3
	// 		        on table3.Uses_medicine_ID = medicine.medicine_ID  
	// 		        and medicine.MedicineReqest = 1
	// 			'
	// }



	public function getallmedicine(){
		$data = [];
		$i = 0;
		$this->load->model('security','sec');
		$this->load->model('companyMod','comMod');
		$this->db->select('medicine_ID');
		$this->db->select('medicine_name_AR');
		$this->db->select('medicine_name_En');
		$this->db->select('MedicineReqest');
		$this->db->select('company_ID');
		$this->db->select('company_Name');
		$this->db->select('Cmedicine_price');
		$this->db->select('Quantity');
		$this->db->from('medicine');
		$this->db->join('companymedicnequantity','medicine_ID = medicinemedicine_ID');
		$this->db->join('company','company_ID = companycompany_ID');
		$this->db->where('MedicineReqest','1');
		$res = $this->db->get();
		foreach ($res->result() as $row) {
			$data['medID'][$i] 			= $this->sec->encode($row->medicine_ID); 	
			$data['nameAr'][$i]			= $row->medicine_name_AR; 	
			$data['nameEng'][$i] 		= $row->medicine_name_En; 	
			if($row->MedicineReqest == 1)
			{
				$data['req'][$i]			= 'accept'; 	
			}
			$data['comId'][$i]			= $this->sec->encode($row->company_ID); 	
			$data['AcomId'][$i]			= $this->sec->encode($this->comMod->getAccountid($row->company_ID)); 	
			$data['MedCompanyname'][$i] = $row->company_Name; 	
			$data['price'][$i] = $row->Cmedicine_price; 	
			$data['quantity'][$i] = $row->Quantity; 
			if($this->pharmacy_Is_Booked_Medicine($row->medicine_ID,$row->company_ID)){
				$data['booked'][$i] = 'booked';
			}	
			$i++;
		}
		$this->db->select('medicine_ID');
		$this->db->select('medicine_name_AR');
		$this->db->select('medicine_name_En');
		$this->db->select('MedicineReqest');
		$this->db->select('company_ID');
		$this->db->select('company_Name');
		$this->db->select('Cmedicine_price');
		$this->db->select('Quantity');
		$this->db->from('medicine');
		$this->db->join('companyhasmedicne','medicine_ID=medicinemedicine_ID');
		$this->db->join('company','company_ID=companycompany_ID');
		$this->db->where('MedicineReqest','1');
		$res = $this->db->get();
		foreach ($res->result() as $row) {
			$data['medID'][$i] 			= $this->sec->encode($row->medicine_ID); 	
			$data['nameAr'][$i]			= $row->medicine_name_AR; 	
			$data['nameEng'][$i] 		= $row->medicine_name_En; 	
			if($row->MedicineReqest == 1)
			{
				$data['req'][$i]			= 'accept'; 	
			}
			$data['comId'][$i]			= $this->sec->encode($row->company_ID); 	
			$data['AcomId'][$i]			= $this->sec->encode($this->comMod->getAccountid($row->company_ID)); 	
			$data['MedCompanyname'][$i] = $row->company_Name; 	
			$data['price'][$i] = $row->Cmedicine_price; 	
			$data['quantity'][$i] = $row->Quantity; 	
			if($this->pharmacy_Is_Booked_Medicine($row->medicine_ID,$row->company_ID)){
				$data['booked'][$i] = 'booked';
			}
			$i++;
		}
		return $data;
	}







}



?>