<?php
	
class Mcontent {

	private $padre;
	private $db;
	private $result;

	/** VARIABLES **/

	private $IdContent;
	private $ContentDescription;
	private $PublicationDate;
	private $RegistryDate;
	private $State;
	private $IdContentType;
	private $IdProduct;
	private $IdVersion;
	

	function __construct($el){
		
		$this->padre = $el;
		$this->db = $this->padre->lib('DB');
		$this->result = array('result' => array('success' => 0, 'message' => '', 'id' => null));
	}


	/********************* MÉTODOS *********************/

    public function selectContentxId(){

    	$content = $this->db->_query("SELECT idcontent, publication_date, idcontent_type, idproduct, idversion FROM tbl_content WHERE idcontent = '".$this->getIdContent()."' AND state = 1")->fetch_object();

    	return $content;
    }


    public function selectContentxIdProductIdContentTypeIdVersion(){

    	$content = $this->db->_query("SELECT idcontent, publication_date FROM tbl_content WHERE idcontent_type = '".$this->getIdContentType()."' AND idproduct = '".$this->getIdProduct()."' AND idversion = '".$this->getIdVersion()."' AND state = 1")->fetch_object();

    	return $content;
    }


    public function insertContent(){

    	$content = $this->db->_query("SELECT idcontent FROM tbl_content WHERE idcontent_type = '".$this->getIdContentType()."' AND idproduct = '".$this->getIdProduct()."' AND idversion = '".$this->getIdVersion()."' AND state = 1")->fetch_object();

    	if ($content) {
    		$idcontent = $content->idcontent;
    	} else {
	    	$content = $this->db->_query("INSERT INTO tbl_content (content_description, publication_date, idcontent_type, idproduct, idversion) VALUES ('".$this->getContentDescription()."','".$this->getPublicationDate()."', ".$this->getIdContentType().", ".$this->getIdProduct().", ".$this->getIdVersion().") ");
			$idcontent = $this->db->mysql()->insert_id; //ID del registro insertado.
    	}

    	if ($idcontent) {
			$this->result['result']['success'] = 1;
			$this->result['result']['message'] = 'Los datos se han registrado satisfactoriamente.';
			$this->result['result']['id'] = $idcontent;
		} else {
			$this->result['result']['success'] = 0;
			$this->result['result']['message'] = 'Los datos no se han registrado, ocurrió un error.';
		}

    	return $this->result;
    }

	/*
    public function selectContentxProductContentType(){

    	$content = $this->db->_query("SELECT * FROM tbl_content WHERE idcontent_type = '".$this->getIdContentType()."' AND idproduct = '".$this->getIdProduct()."' AND state = 1");

    	$arrayContent = array();
    	while ($result = $content->fetch_object()) {
    		array_push($arrayContent, $result);
    	}

    	return $arrayContent;
    }
	*/

	/********************* MÉTODOS SET & GET *********************/

	public function setIdContent($IdContent = null){

		$this->IdContent = $IdContent;
	}

	public function getIdContent(){

		return $this->IdContent;
	}

	public function setContentDescription($ContentDescription = null){

		$this->ContentDescription = $ContentDescription;
	}

	public function getContentDescription(){

		return $this->ContentDescription;
	}

	public function setPublicationDate($PublicationDate = null){

		$this->PublicationDate = $PublicationDate;
	}

	public function getPublicationDate(){

		return $this->PublicationDate;
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

	public function setIdContentType($IdContentType = null){

		$this->IdContentType = $IdContentType;
	}

	public function getIdContentType(){

		return $this->IdContentType;
	}

	public function setIdProduct($IdProduct = null){

		$this->IdProduct = $IdProduct;
	}

	public function getIdProduct(){

		return $this->IdProduct;
	}

	public function setIdVersion($IdVersion = null){

		$this->IdVersion = $IdVersion;
	}

	public function getIdVersion(){
		
		return $this->IdVersion;
	}

}