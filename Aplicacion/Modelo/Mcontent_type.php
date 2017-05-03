<?php
	
class Mcontent_type {

	private $padre;
	private $db;
	private $result;

	/** VARIABLES **/

	private $IdContentType;
	private $ContentDescription;
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


    public function selectContentTypexIdContentTypeMenu(){

		$sql = $this->db->_query("SELECT idcontent_type, content_description, name_short FROM tbl_content_type WHERE idcontent_type = ".$this->getIdContentType()." AND state = 1")->fetch_object();

		if($sql){
			$this->result['result']['success'] = 1;
			$this->result['result']['message'] = 'La consulta se realizó satisfactoriamente.';
			$this->result['result']['object_content_type'] = $sql;
		}else{
			$this->result['result']['success'] = 0;
			$this->result['result']['message'] = 'Ocurrió un error al realizar la consulta.';
			$this->result['result']['object_content_type'] = null;
		}

		return $this->result;
    }


	public function selectContentTypexDescription(){

		$sql = $this->db->_query("SELECT idcontent_type, content_description FROM tbl_content_type WHERE content_description LIKE '%".$this->getContentDescription()."%' AND state = 1")->fetch_object();

		if($sql){
			$this->result['result']['success'] = 1;
			$this->result['result']['message'] = 'La consulta se realizó satisfactoriamente.';
			$this->result['result']['object_content_type'] = $sql;
		}else{
			$this->result['result']['success'] = 0;
			$this->result['result']['message'] = 'Ocurrió un error al realizar la consulta.';
			$this->result['result']['object_content_type'] = null;
		}

		return $this->result;
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