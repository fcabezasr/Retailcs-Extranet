<?php
	
class Mversion {

	private $padre;
	private $db;
	private $result;

	/** VARIABLES **/

	private $IdVersion;
	private $VersionDescription;
	private $RegistryDate;
	private $State;


	function __construct($el){
		
		$this->padre = $el;
		$this->db = $this->padre->lib('DB');
		$this->result = array('result' => array('success' => 0, 'message' => '', 'id' => null));
	}


	/********************* MÉTODOS *********************/


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


	public function selectVersionxIdProduct(){
		
		$version = $this->db->_query("SELECT idversion, version_description FROM tbl_version WHERE idversion = ".$this->getIdVersion()." AND state = 1")->fetch_object();

		return $version;
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
		
	public function setRegistryDate($RegistryDate = null){

		$this->RegistryDate = $RegistryDate;
	}

	public function getRegistryDate(){
		
		return $this->RegistryDate;
	}

	public function setState($State = null){

		$this->State = $State;
	}

	public function getState(){
		
		return $this->State;
	}

}