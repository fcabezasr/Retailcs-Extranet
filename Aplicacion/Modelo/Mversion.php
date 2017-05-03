<?php
	
class Mversion {

	private $padre;
	private $db;
	private $result;

	/** VARIABLES **/

	private $IdVersion;
	private $VersionDescription;
	private $VersionOrder;
	private $RegistryDate;
	private $UpdateDate;
	private $State;


	function __construct($el){
		
		$this->padre = $el;
		$this->db = $this->padre->lib('DB');
		$this->result = array('result' => array('success' => 0, 'message' => '', 'id' => null));
	}


	/********************* MÉTODOS *********************/


	public function selectVersion(){

		$sql = $this->db->_query("SELECT idversion, version_description, version_order, DATE_FORMAT(registry_date, '%d-%m-%Y') AS registry_date, state FROM tbl_version WHERE state = 1");
		$array_version = array();

		while($datos = $sql->fetch_object()){
			array_push($array_version, $datos);
		}

		if($array_version){
			$this->result['result']['success'] = 1;
			$this->result['result']['message'] = 'La consulta se realizó satisfactoriamente.';
			$this->result['result']['arrayVersion'] = $array_version;
		}else{
			$this->result['result']['success'] = 0;
			$this->result['result']['message'] = 'Ocurrió un error al realizar la consulta.';
			$this->result['result']['arrayVersion'] = null;
		}

		return $this->result;
	}


	public function selectVersionxIdVersion(){
		
		$sql = $this->db->_query("SELECT idversion, version_description FROM tbl_version WHERE idversion = ".$this->getIdVersion()." AND state = 1")->fetch_object();

		if($sql){
			$this->result['result']['success'] = 1;
			$this->result['result']['message'] = 'La consulta se realizó satisfactoriamente.';
			$this->result['result']['object_version'] = $sql;
		}else{
			$this->result['result']['success'] = 0;
			$this->result['result']['message'] = 'Ocurrió un error al realizar la consulta.';
			$this->result['result']['object_version'] = null;
		}

		return $this->result;
	}


	public function selectVersionxIdVersionMenu(){
		
		$sql = $this->db->_query("SELECT idversion, version_description, version_order FROM tbl_version WHERE idversion = ".$this->getIdVersion()." AND state = 1")->fetch_object();
		
		if($sql){
			$this->result['result']['success'] = 1;
			$this->result['result']['message'] = 'La consulta se realizó satisfactoriamente.';
			$this->result['result']['object_version'] = $sql;
		}else{
			$this->result['result']['success'] = 0;
			$this->result['result']['message'] = 'Ocurrió un error al realizar la consulta.';
			$this->result['result']['object_version'] = null;
		}

		return $this->result;
	}


	public function insertVersion(){
		
		$sql = $this->db->_query("INSERT INTO tbl_version (version_description) VALUES ('".$this->getVersionDescription()."')");
		
		if($sql){
			$this->result['result']['success'] = 1;
			$this->result['result']['message'] = 'La versión <strong>'.$this->getVersionDescription().'</strong> se ha registrado satisfactoriamente.';
			$this->result['result']['id'] = $this->db->mysql()->insert_id;
			$this->result['result']['version'] = $this->getVersionDescription();
		}else{
			$this->result['result']['success'] = 0;
			$this->result['result']['message'] = 'La versión <strong>'.$this->getVersionDescription().'</strong> no se ha registrado, ocurrió un error.';
		}

		return $this->result;
	}


	public function listVersion( $funcion ){

		$sql = $this->db->_query("SELECT idversion, version_description FROM tbl_version WHERE state = 1");
		$lista = '';
	
		while($datos = $sql->fetch_object()){
			$lista .= call_user_func($funcion, $datos->idversion, $datos->version_description);
		}

		return $lista;
	}
	

	/********************* MÉTODOS SET & GET *********************/

	public function setIdVersion($IdVersion = null){

		$this->IdVersion = $IdVersion;
	}

	public function getIdVersion(){
		
		return $this->IdVersion;
	}

	public function setVersionDescription($VersionDescription = null){

		$this->VersionDescription = $VersionDescription;
	}

	public function getVersionDescription(){
		
		return $this->VersionDescription;
	}

	public function setVersionOrder($VersionOrder = null){

		$this->VersionOrder = $VersionOrder;
	}

	public function getVersionOrder(){
		
		return $this->VersionOrder;
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