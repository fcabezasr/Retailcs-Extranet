<?php
	
class Mbusiness {

	private $padre;
	private $db;
	private $result;

	/** VARIABLES **/

	private $IdBusiness;
	private $BusinessName;
	private $Ruc;
	private $Address;
	private $Item;
	private $RegistryDate;
	private $UpdateDate;
	private $State;


	function __construct($el){
		
		$this->padre = $el;
		$this->db = $this->padre->lib('DB');
		$this->result = array('result' => array('success' => 0, 'message' => '', 'id' => null));
	}


	/********************* MÉTODOS *********************/


	public function selectBusiness(){

		$sql = $this->db->_query("SELECT idbusiness, business_name, ruc, address, DATE_FORMAT(registry_date, '%d-%m-%Y') AS registry_date, state FROM tbl_business WHERE 1");
		$arrayBusiness = array();
	
		while($datos = $sql->fetch_object()){
			array_push($arrayBusiness, $datos);
		}

		if($arrayBusiness){
			$this->result['result']['success'] = 1;
			$this->result['result']['message'] = 'La consulta se realizó satisfactoriamente.';
			$this->result['result']['arrayBusiness'] = $arrayBusiness;
		}else{
			$this->result['result']['success'] = 0;
			$this->result['result']['message'] = 'Ocurrió un error al realizar la consulta.';
			$this->result['result']['arrayBusiness'] = null;
		}

		return $this->result;
	}


    public function selectBusinessxId(){

    	$business = $this->db->_query("SELECT idbusiness, business_name FROM tbl_business WHERE idbusiness = '".$this->getIdBusiness()."' AND state = 1")->fetch_object();

		if($business){
			$this->result['result']['success'] = 1;
			$this->result['result']['message'] = 'La consulta se realizó satisfactoriamente.';
			$this->result['result']['business'] = $business;
		}else{
			$this->result['result']['success'] = 0;
			$this->result['result']['message'] = 'Ocurrió un error al realizar la consulta.';
			$this->result['result']['business'] = null;
		}

		return $this->result;
    }


	public function insertBusiness(){
		
		if ($this->getIdBusiness()!='' || $this->getIdBusiness()!=null) {
			//$sql = $this->db->_query("UPDATE tbl_business SET business_name = '".$this->getBusinessName()."', ruc = '".$this->getRuc()."', address = '".$this->getAddress()."', update_date = '".$this->getUpdateDate()."', state = 1 WHERE idbusiness = ".$this->getIdBusiness()."");
			$sql = $this->db->_query("UPDATE tbl_business SET business_name = '".$this->getBusinessName()."', ruc = '".$this->getRuc()."', update_date = '".$this->getUpdateDate()."', state = 1 WHERE idbusiness = ".$this->getIdBusiness()."");

			if($sql){
				$this->result['result']['success'] = 1;
				$this->result['result']['message'] = 'Los datos de la empresa "<strong>'.$this->getBusinessName().'</strong>" se han actualizado satisfactoriamente.';
				$this->result['result']['id'] = $this->getIdBusiness();
				$this->result['result']['businessname'] = $this->getBusinessName();
				$this->result['result']['nameboton'] = 'Guardar';
			} else {
				$this->result['result']['success'] = 0;
				$this->result['result']['message'] = 'Ocurrió un error, los datos de la empresa "<strong>'.$this->getBusinessName().'</strong>" no se ha actualizado.';
				$this->result['result']['id'] = '';
				$this->result['result']['businessname'] = '';
				$this->result['result']['nameboton'] = 'Actualizar';
			}			
		} else {
			//$sql = $this->db->_query("INSERT INTO tbl_business (business_name, ruc, address, update_date) VALUES ('".$this->getBusinessName()."', '".$this->getRuc()."', '".$this->getAddress()."', '".$this->getUpdateDate()."')");
			$sql = $this->db->_query("INSERT INTO tbl_business (business_name, ruc, update_date) VALUES ('".$this->getBusinessName()."', '".$this->getRuc()."', '".$this->getUpdateDate()."')");
			
			if($sql){
				$this->result['result']['success'] = 1;
				$this->result['result']['message'] = 'La empresa "<strong>'.$this->getBusinessName().'</strong>" se ha registrado satisfactoriamente.';
				$this->result['result']['id'] = $this->db->mysql()->insert_id;
				$this->result['result']['businessname'] = $this->getBusinessName();
				$this->result['result']['nameboton'] = 'Guardar';
			} else {
				$this->result['result']['success'] = 0;
				$this->result['result']['message'] = 'Ocurrió un error, la empresa "<strong>'.$this->getBusinessName().'</strong>" no se ha registrado.';
				$this->result['result']['id'] = '';
				$this->result['result']['businessname'] = '';
				$this->result['result']['nameboton'] = 'Guardar';
			}
		}

		return $this->result;
	}


	public function updateBusiness(){

		$sql = $this->db->_query("SELECT * FROM tbl_business WHERE idbusiness = ".$this->getIdBusiness()."")->fetch_object();
		
		if($sql){
			$this->result['result']['success'] = 1;
			$this->result['result']['message'] = 'Actualice los datos correspondientes.';
			$this->result['result']['objBusiness'] = $sql;
			$this->result['result']['nameboton'] = 'Actualizar';
		} else {
			$this->result['result']['success'] = 0;
			$this->result['result']['message'] = 'Ocurrió un error al realizar la consulta.';
			$this->result['result']['objBusiness'] = '';
			$this->result['result']['nameboton'] = 'Guardar';
		}

		return $this->result;
	}


	public function deleteBusiness(){

		$sql = $this->db->_query("SELECT iduser FROM tbl_user WHERE idbusiness = ".$this->getIdBusiness()." AND state = 1");

		if ($sql->num_rows > 0) {
			$this->result['result']['success'] = 0;
			$this->result['result']['message'] = '<strong>Alerta!</strong> La empresa está vinculado a algún Usuario, por ende no puede eliminarlo.';
		} else {
			$sql = $this->db->_query("UPDATE tbl_business SET state = 0 WHERE idbusiness = ".$this->getIdBusiness()."");

			if($sql){
				$this->result['result']['success'] = 1;
				$this->result['result']['message'] = 'La empresa se ha <strong>deshabilitado</strong> correctamente.';
				$this->result['result']['id'] = $this->getIdBusiness();
			} else {
				$this->result['result']['success'] = 0;
				$this->result['result']['message'] = 'Ocurrió un error, vuelva a realizar la acción.';
			}
		}		

		return $this->result;
	}


	public function validateBusiness(){

		$sql = $this->db->_query("SELECT idbusiness FROM tbl_business WHERE business_name = '".$this->getBusinessName()."'")->fetch_object();
		
		if($sql){
			$this->result['result']['success'] = 1;
			$this->result['result']['message'] = 'La empresa "<strong>'.$this->getBusinessName().'</strong>" ya existe.';
		}else{
			$this->result['result']['success'] = 0;
			$this->result['result']['message'] = 'Ocurrió un error al realizar la consulta.';
		}

		return $this->result;
	}


	public function listBusiness( $funcion ){

		$sql = $this->db->_query("SELECT idbusiness, business_name FROM tbl_business WHERE state = 1");
		$lista = '';
	
		while($datos = $sql->fetch_object()){
			$lista .= call_user_func($funcion, $datos->idbusiness, $datos->business_name);
		}

		return $lista;
	}	


	/********************* MÉTODOS SET & GET *********************/

	public function setIdBusiness($IdBusiness = null){

		$this->IdBusiness = $IdBusiness;
	}

	public function getIdBusiness(){

		return $this->IdBusiness;
	}

	public function setBusinessName($BusinessName = null){

		$this->BusinessName = $BusinessName;
	}

	public function getBusinessName(){
		
		return $this->BusinessName;
	}

	public function setRuc($Ruc = null){

		$this->Ruc = $Ruc;
	}

	public function getRuc(){
		
		return $this->Ruc;
	}

	public function setAddress($Address = null){

		$this->Address = $Address;
	}

	public function getAddress(){
		
		return $this->Address;
	}

	public function setItem($Item = null){

		$this->Item = $Item;
	}

	public function getItem(){
		
		return $this->Item;
	}

	public function setRegistryDate($RegistryDate = null){

		$this->RegistryDate = $RegistryDate;
	}

	public function getRegistryDate(){
		
		return $this->RegistryDate;
	}

	public function setUpdateDate($UpdateDate = null){

		$this->UpdateDate = $UpdateDate;
	}

	public function getUpdateDate(){
		
		return $this->UpdateDate;
	}

	public function setState($State = null){

		$this->State = $State;
	}

	public function getState(){
		
		return $this->State;
	}

}