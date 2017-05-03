<?php
	
class Mfile_type {

	private $padre;
	private $db;
	private $result;

	/** VARIABLES **/

	private $IdFileType;
	private $FileDescription;
	private $NameShort;
	private $RegistryDate;
	private $UpdateDate;
	private $State;


	function __construct($el){
		
		$this->padre = $el;
		$this->db = $this->padre->lib('DB');
		$this->result = array('result' => array('success' => 0, 'message' => '', 'id' => null));
	}


	/********************* MÉTODOS *********************/


    public function selectFileTypexIdFileTypeMenu(){

		$sql = $this->db->_query("SELECT idfile_type, file_description, name_short FROM tbl_file_type WHERE idfile_type = ".$this->getIdFileType()." AND state = 1")->fetch_object();

		if($sql){
			$this->result['result']['success'] = 1;
			$this->result['result']['message'] = 'La consulta se realizó satisfactoriamente.';
			$this->result['result']['object_file_type'] = $sql;
		}else{
			$this->result['result']['success'] = 0;
			$this->result['result']['message'] = 'Ocurrió un error al realizar la consulta.';
			$this->result['result']['object_file_type'] = null;
		}

		return $this->result;
    }


	public function selectFileTypexDescription(){

		$sql = $this->db->_query("SELECT idfile_type, file_description FROM tbl_file_type WHERE file_description LIKE '%".$this->getFileDescription()."%' AND state = 1")->fetch_object();

		if($sql){
			$this->result['result']['success'] = 1;
			$this->result['result']['message'] = 'La consulta se realizó satisfactoriamente.';
			$this->result['result']['object_file_type'] = $sql;
		}else{
			$this->result['result']['success'] = 0;
			$this->result['result']['message'] = 'Ocurrió un error al realizar la consulta.';
			$this->result['result']['object_file_type'] = null;
		}

		return $this->result;		
	}


	/********************* MÉTODOS SET & GET *********************/

	public function setIdFileType($IdFileType = null){

		$this->IdFileType = $IdFileType;
	}

	public function getIdFileType(){
		
		return $this->IdFileType;
	}

	public function setFileDescription($FileDescription = null){

		$this->FileDescription = $FileDescription;
	}

	public function getFileDescription(){
		
		return $this->FileDescription;
	}

	public function setNameShort($NameShort = null){

		$this->NameShort = $NameShort;
	}

	public function getNameShort(){
		
		return $this->NameShort;
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