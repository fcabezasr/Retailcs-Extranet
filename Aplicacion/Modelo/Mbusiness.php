<?php
	
class Mbusiness {

	private $padre;
	private $db;
	private $session;
	private $result;

	/** VARIABLES **/

	private $IdBusiness;
	private $BusinessName;
	private $Ruc;
	private $Address;
	private $Item;
	private $Language;
	private $RegistryDate;
	private $UpdateDate;
	private $State;


	function __construct($el){
		
		$this->padre = $el;
		$this->db = $this->padre->lib('DB');
		$this->session = $this->padre->lib('Session');
		$this->result = array('result' => array('success' => 0, 'message' => '', 'id' => null));
	}


	/********************* MÉTODOS *********************/


	public function selectBusiness(){

		$this->session->start();
		
		$sql = $this->db->_query("SELECT idbusiness, business_name, ruc, address, language, DATE_FORMAT(registry_date, '%d-%m-%Y') AS registry_date, state FROM tbl_business WHERE 1");
		$arrayBusiness = array();
	
		while($datos = $sql->fetch_object()){
			array_push($arrayBusiness, $datos);
		}

		if($arrayBusiness){
			$this->result['result']['success'] = 1;
			$this->result['result']['arrayBusiness'] = $arrayBusiness;

			if ($_SESSION['Business']['Language']=='en') {
				$this->result['result']['message'] = 'The query was successful.';
			} else {
				$this->result['result']['message'] = 'La consulta se realizó satisfactoriamente.';
			}
		}else{
			$this->result['result']['success'] = 0;
			$this->result['result']['arrayBusiness'] = null;

			if ($_SESSION['Business']['Language']=='en') {
				$this->result['result']['message'] = 'An error occurred while performing the query.';
			} else {
				$this->result['result']['message'] = 'Ocurrió un error al realizar la consulta.';
			}
		}

		return $this->result;
	}


    public function selectBusinessxId(){

    	$this->session->start();

    	$business = $this->db->_query("SELECT idbusiness, business_name, language FROM tbl_business WHERE idbusiness = '".$this->getIdBusiness()."' AND state = 1")->fetch_object();

		if($business){
			$this->result['result']['success'] = 1;
			$this->result['result']['business'] = $business;

			if ($_SESSION['Business']['Language']=='en') {
				$this->result['result']['message'] = 'The query was successful.';
			} else {
				$this->result['result']['message'] = 'La consulta se realizó satisfactoriamente.';
			}
		}else{
			$this->result['result']['success'] = 0;
			$this->result['result']['business'] = null;

			if ($_SESSION['Business']['Language']=='en') {
				$this->result['result']['message'] = 'An error occurred while performing the query.';
			} else {
				$this->result['result']['message'] = 'Ocurrió un error al realizar la consulta.';
			}
		}

		return $this->result;
    }


	public function insertBusiness(){

		$this->session->start();
		
		if ($this->getIdBusiness()!='' || $this->getIdBusiness()!=null) {
			$sql = $this->db->_query("UPDATE tbl_business SET business_name = '".$this->getBusinessName()."', ruc = '".$this->getRuc()."', language = '".$this->getLanguage()."', update_date = '".$this->getUpdateDate()."', state = 1 WHERE idbusiness = ".$this->getIdBusiness()."");

			if($sql){
				$this->result['result']['success'] = 1;
				$this->result['result']['id'] = $this->getIdBusiness();
				$this->result['result']['businessname'] = $this->getBusinessName();

				if ($_SESSION['Business']['Language']=='en') {
					$this->result['result']['message'] = 'The data from the "<strong>'.$this->getBusinessName().'</strong>" company has been successfully updated.';
					$this->result['result']['nameboton'] = 'Save';
				} else {
					$this->result['result']['message'] = 'Los datos de la empresa "<strong>'.$this->getBusinessName().'</strong>" se han actualizado satisfactoriamente.';
					$this->result['result']['nameboton'] = 'Guardar';
				}
			} else {
				$this->result['result']['success'] = 0;
				$this->result['result']['id'] = '';
				$this->result['result']['businessname'] = '';
				
				if ($_SESSION['Business']['Language']=='en') {
					$this->result['result']['message'] = 'An error occurred, the company data "<strong>'.$this->getBusinessName().'</strong>" has not been updated.';
					$this->result['result']['nameboton'] = 'Update';
				} else {
					$this->result['result']['message'] = 'Ocurrió un error, los datos de la empresa "<strong>'.$this->getBusinessName().'</strong>" no se ha actualizado.';
					$this->result['result']['nameboton'] = 'Actualizar';
				}
			}			
		} else {
			$sql = $this->db->_query("INSERT INTO tbl_business (business_name, ruc, language, update_date) VALUES ('".$this->getBusinessName()."', '".$this->getRuc()."', '".$this->getLanguage()."', '".$this->getUpdateDate()."')");
			
			if($sql){
				$this->result['result']['success'] = 1;
				$this->result['result']['id'] = $this->db->mysql()->insert_id;
				$this->result['result']['businessname'] = $this->getBusinessName();
				
				if ($_SESSION['Business']['Language']=='en') {
					$this->result['result']['message'] = 'The "<strong>'.$this->getBusinessName().'</strong>" company has successfully registered.';
					$this->result['result']['nameboton'] = 'Save';
				} else {
					$this->result['result']['message'] = 'La empresa "<strong>'.$this->getBusinessName().'</strong>" se ha registrado satisfactoriamente.';
					$this->result['result']['nameboton'] = 'Guardar';
				}
			} else {
				$this->result['result']['success'] = 0;
				$this->result['result']['id'] = '';
				$this->result['result']['businessname'] = '';

				if ($_SESSION['Business']['Language']=='en') { 
					$this->result['result']['message'] = 'An error occurred, the "<strong>'.$this->getBusinessName().'</strong>" company was not registered.';
					$this->result['result']['nameboton'] = 'Save';
				} else {
					$this->result['result']['message'] = 'Ocurrió un error, la empresa "<strong>'.$this->getBusinessName().'</strong>" no se ha registrado.';
					$this->result['result']['nameboton'] = 'Guardar';
				}
			}
		}

		return $this->result;
	}


	public function updateBusiness(){

		$this->session->start();

		$sql = $this->db->_query("SELECT * FROM tbl_business WHERE idbusiness = ".$this->getIdBusiness()."")->fetch_object();
		
		if($sql){
			$this->result['result']['success'] = 1;
			$this->result['result']['objBusiness'] = $sql;

			if ($_SESSION['Business']['Language']=='en') {
				$this->result['result']['message'] = 'Update the corresponding data.';
				$this->result['result']['nameboton'] = 'Update';
			} else {
				$this->result['result']['message'] = 'Actualice los datos correspondientes.';
				$this->result['result']['nameboton'] = 'Actualizar';
			}			
		} else {
			$this->result['result']['success'] = 0;
			$this->result['result']['objBusiness'] = '';

			if ($_SESSION['Business']['Language']=='en') {
				$this->result['result']['message'] = 'An error occurred while performing the query.';
				$this->result['result']['nameboton'] = 'Save';
			} else {
				$this->result['result']['message'] = 'Ocurrió un error al realizar la consulta.';
				$this->result['result']['nameboton'] = 'Guardar';
			}
		}

		return $this->result;
	}


	public function deleteBusiness(){

		$this->session->start();

		$sql = $this->db->_query("SELECT iduser FROM tbl_user WHERE idbusiness = ".$this->getIdBusiness()." AND state = 1");

		if ($sql->num_rows > 0) {
			$this->result['result']['success'] = 0;

			if ($_SESSION['Business']['Language']=='en') {
				$this->result['result']['message'] = '<strong>Alert!</strong> The company is linked to some User, therefore can not delete it.';
			} else {
				$this->result['result']['message'] = '<strong>Alerta!</strong> La empresa está vinculado a algún Usuario, por ende no puede eliminarlo.';
			}			
		} else {
			$sql = $this->db->_query("UPDATE tbl_business SET state = 0 WHERE idbusiness = ".$this->getIdBusiness()."");

			if($sql){
				$this->result['result']['success'] = 1;
				$this->result['result']['id'] = $this->getIdBusiness();

				if ($_SESSION['Business']['Language']=='en') {
					$this->result['result']['message'] = 'The company has been successfully <strong>disabled</strong>.';
				} else {
					$this->result['result']['message'] = 'La empresa se ha <strong>deshabilitado</strong> correctamente.';
				}				
			} else {
				$this->result['result']['success'] = 0;

				if ($_SESSION['Business']['Language']=='en') {
					$this->result['result']['message'] = 'An error occurred, redo the action.';
				} else {
					$this->result['result']['message'] = 'Ocurrió un error, vuelva a realizar la acción.';
				}
			}
		}		

		return $this->result;
	}


	public function validateBusiness(){

		$this->session->start();

		$sql = $this->db->_query("SELECT idbusiness FROM tbl_business WHERE business_name = '".$this->getBusinessName()."'")->fetch_object();
		
		if($sql){
			$this->result['result']['success'] = 1;
			
			if ($_SESSION['Business']['Language']=='en') { 
				$this->result['result']['message'] = 'The "<strong>'.$this->getBusinessName().'</strong>" company already exists.';
			} else {
				$this->result['result']['message'] = 'La empresa "<strong>'.$this->getBusinessName().'</strong>" ya existe.';
			}
		}else{
			$this->result['result']['success'] = 0;
			
			if ($_SESSION['Business']['Language']=='en') {
				$this->result['result']['message'] = 'An error occurred while performing the query.';
			} else {
				$this->result['result']['message'] = 'Ocurrió un error al realizar la consulta.';
			}
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

	public function changeLanguage(){

		$this->session->start();
		
		$sql = $this->db->_query("UPDATE tbl_business SET language = '".$this->getLanguage()."' WHERE idbusiness = ".$this->getIdBusiness()."");

		if($sql){
			$this->result['result']['success'] = 1;
			$_SESSION['Business']['Language'] = $this->getLanguage();

			if ($_SESSION['Business']['Language']=='en') {
				$this->result['result']['message'] = 'The language has been successfully updated.';
			} else {
				$this->result['result']['message'] = 'El idioma se ha actualizado satisfactoriamente.';
			}
		}else{
			$this->result['result']['success'] = 0;
			
			if ($_SESSION['Business']['Language']=='en') {
				$this->result['result']['message'] = 'An error occurred while performing the query.';
			} else {
				$this->result['result']['message'] = 'Ocurrió un error al realizar la consulta.';
			}
		}

		return $this->result;
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

	public function setLanguage($Language = null){

		$this->Language = $Language;
	}

	public function getLanguage(){
		
		return $this->Language;
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