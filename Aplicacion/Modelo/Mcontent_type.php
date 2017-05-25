<?php
	
class Mcontent_type {

	private $padre;
	private $db;
	private $session;
	private $result;

	/** VARIABLES **/

	private $IdContentType;
	private $ContentDescription;
	private $ContentDescriptionEn;
	private $NameShort;
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


    public function selectContentTypexIdContentTypeMenu(){

    	$this->session->start();

		$sql = $this->db->_query("SELECT idcontent_type, content_description, content_description_en, name_short FROM tbl_content_type WHERE idcontent_type = ".$this->getIdContentType()." AND state = 1")->fetch_object();

		if($sql){
			$this->result['result']['success'] = 1;
			$this->result['result']['object_content_type'] = $sql;

			if ($_SESSION['Business']['Language']=='en') {
				$this->result['result']['message'] = 'The query was successful.';
			} else {
				$this->result['result']['message'] = 'La consulta se realizó satisfactoriamente.';
			}
		}else{
			$this->result['result']['success'] = 0;
			$this->result['result']['object_content_type'] = null;

			if ($_SESSION['Business']['Language']=='en') {
				$this->result['result']['message'] = 'An error occurred while performing the query.';
			} else {
				$this->result['result']['message'] = 'Ocurrió un error al realizar la consulta.';
			}
		}

		return $this->result;
    }


	public function selectContentTypexDescription(){

		$this->session->start();

		$sql = $this->db->_query("SELECT idcontent_type, content_description, content_description_en FROM tbl_content_type WHERE content_description LIKE '%".$this->getContentDescription()."%' AND state = 1")->fetch_object();

		if($sql){
			$this->result['result']['success'] = 1;
			$this->result['result']['object_content_type'] = $sql;

			if ($_SESSION['Business']['Language']=='en') {
				$this->result['result']['message'] = 'The query was successful.';
			} else {
				$this->result['result']['message'] = 'La consulta se realizó satisfactoriamente.';
			}
		}else{
			$this->result['result']['success'] = 0;
			$this->result['result']['object_content_type'] = null;

			if ($_SESSION['Business']['Language']=='en') {
				$this->result['result']['message'] = 'An error occurred while performing the query.';
			} else {
				$this->result['result']['message'] = 'Ocurrió un error al realizar la consulta.';
			}
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

	public function setContentDescriptionEn($ContentDescriptionEn = null){

		$this->ContentDescriptionEn = $ContentDescriptionEn;
	}

	public function getContentDescriptionEn(){
		
		return $this->ContentDescriptionEn;
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