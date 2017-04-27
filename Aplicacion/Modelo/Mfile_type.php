<?php
	
class Mfile_type {

	private $padre;
	private $db;

	/** VARIABLES **/

	private $IdFileType;
	private $FileDescription;
	private $RegistryDate;
	private $State;


	function __construct($el){
		
		$this->padre = $el;
		$this->db = $this->padre->lib('DB');
	}


	/********************* MÉTODOS *********************/

	public function selectFileTypexDescription(){

		$file_type = $this->db->_query("SELECT idfile_type, file_description FROM tbl_file_type WHERE file_description LIKE '%".$this->getFileDescription()."%' AND state = 1")->fetch_object();

		return $file_type;
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