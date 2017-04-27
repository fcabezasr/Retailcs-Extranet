<?php
	
class Mcontent_type {

	private $padre;
	private $db;

	/** VARIABLES **/

	private $IdContentType;
	private $ContentDescription;
	private $RegistryDate;
	private $State;


	function __construct($el){
		
		$this->padre = $el;
		$this->db = $this->padre->lib('DB');
	}


	/********************* MÉTODOS *********************/

	public function selectContentTypexDescription(){

		$content_type = $this->db->_query("SELECT idcontent_type, content_description FROM tbl_content_type WHERE content_description LIKE '%".$this->getContentDescription()."%' AND state = 1")->fetch_object();

		return $content_type;
	}


	/********************* MÉTODOS SET & GET *********************/

	public function setIdContentType($IdContentType = null){

		$this->IdContentType = $IdContentType;
	}

	public function getIdContentType(){
		
		return $this->IdContentType;
	}

	public function setContentDescription($ContentDescription = null){

		$this->ContentDescription = $ContentDescription;
	}

	public function getContentDescription(){
		
		return $this->ContentDescription;
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