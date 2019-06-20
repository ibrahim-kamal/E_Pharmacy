<?php

class companycont extends CI_Controller {
	public function index(){
		$this->general();
	}
	public function general()
	{
		if($this->session->userdata('Account_ID'))
		{
			$this->load->model('userMod', 'usrMod');
			$data = $this->usrMod->get_user_info($this->session->userdata('Account_ID'));
			$data['iscompany'] = "";
			$data['myurl']	= base_url()."companycont/Edit";	
			$this->load->view('setting',$data);
			$this->load->view('myprofile',$data);
		}
	}


	public function Edit(){
		if($this->session->userdata('Account_ID')){
			$this->load->model('userMod', 'usrMod');
			$data = $this->usrMod->get_user_info($this->session->userdata('Account_ID'));
			$data['iscompany'] = "";
			$this->load->view('setting',$data);
			$this->load->view('Edit',$data);
		}
		
	}

	
	public function medicine()
	{
		$this->load->model('medicinemod','MedMod');
		$type = 'company';
		$typeId=$this->session->userdata('typesid')['CID'];
		$data['data'] = $this->MedMod->Medicine($type,false,$typeId);
		$data['iscompany'] = "";
		$this->load->view('setting',$data);
		$this->load->view('medicine',$data);
	}

	public function RemoveMedicine(){
        if (isset($_POST['MedID'])) {
            $this->load->model('medicinemod','MedMod');
            $this->load->model('security','Sec');
            $medID = $this->Sec->decode($_POST['MedID']);
            $type = 'company';
            $typeId = $this->session->userdata('typesid')['CID'];;
            $this->MedMod->Remove($medID,$type,$typeId);
            echo 'Accept';
        }
    }

    public function changeprice(){
        if (isset($_POST['MedID'])) {
            $this->load->library('form_validation');
            $this->form_validation->set_rules('MedPrice','Price','required|numeric|greater_than[0]');
            if(!$this->form_validation->run())
            {
                echo 'error|'.form_error('MedPrice');
                return false;
            }
            $this->load->model('medicinemod','MedMod');
            $this->load->model('security','Sec');
            $medID = $this->Sec->decode($_POST['MedID']);
            $type = 'company';
            $price = $_POST['MedPrice'];
            $typeId = $this->session->userdata('typesid')['CID'];;
            $this->MedMod->changeprice($price,$medID,$type,$typeId);
            echo 'Accept';
        }
    }

    public function changequantity(){
        if (isset($_POST['MedID'])) {
            $this->load->library('form_validation');
            $this->form_validation->set_rules('MedQua','quantity','required|numeric|greater_than[0]');
            if(!$this->form_validation->run())
            {
                echo 'error|'.form_error('MedQua');
                return false;
            }
            $this->load->model('medicinemod','MedMod');
            $this->load->model('security','Sec');
            $medID = $this->Sec->decode($_POST['MedID']);
            $type = 'company';
            $Quantity = $_POST['MedQua'];
            $typeId = $this->session->userdata('typesid')['CID'];;
            $this->MedMod->changeQuantity($Quantity,$medID,$type,$typeId);
            echo 'Accept';
        }
    }
	
}
?>