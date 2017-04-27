<?php
	
class Mcontent_detail {

	private $padre;
	private $db;
	private $result;

	/** VARIABLES **/

	private $IdContentDetail;
	private $DetailDescription;
	private $RegistryDate;
	private $State;
	private $IdContent;


	function __construct($el){
		
		$this->padre = $el;
		$this->db = $this->padre->lib('DB');
		$this->result = array('result' => array('success' => 0, 'message' => '', 'id' => null));
	}


	/********************* MÉTODOS *********************/

	public function selectContentDetailxIdContent(){

		$content_detail = $this->db->_query("SELECT idcontent_detail, detail_description, registry_date FROM tbl_content_detail WHERE idcontent = '".$this->getIdContent()."' AND state = 1");
	
		$array_content_detail = array();
		while ($obj = $content_detail->fetch_object()) {
			array_push($array_content_detail, $obj);
		}

		return $array_content_detail;
	}


	public function insertContentDetail(){

		$content_detail = $this->db->_query("INSERT INTO tbl_content_detail (detail_description, registry_date, idcontent) VALUES ('".$this->getDetailDescription()."','".$this->getRegistryDate()."', ".$this->getIdContent().") ");

		if($content_detail){
			$this->result['result']['success'] = 1;
			$this->result['result']['message'] = 'Los datos se han registrado satisfactoriamente.';
			$this->result['result']['id'] = $this->db->mysql()->insert_id;
		}else{
			$this->result['result']['success'] = 0;
			$this->result['result']['message'] = 'Los datos no se han registrado, ocurrió un error.';
		}

		return $this->result;
	}

	/********************* MÉTODOS SET & GET *********************/

	public function setIdContentDetail($IdContentDetail = null){

		$this->IdContentDetail = $IdContentDetail;
	}

	public function getIdContentDetail(){
		
		return $this->IdContentDetail;
	}

	public function setDetailDescription($DetailDescription = null){

		$this->DetailDescription = $DetailDescription;
	}

	public function getDetailDescription(){
		
		return $this->DetailDescription;
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

	public function setIdContent($IdContent = null){

		$this->IdContent = $IdContent;
	}

	public function getIdContent(){
		
		return $this->IdContent;
	}

}