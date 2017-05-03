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