<?php
	
class Mcontent {

	private $padre;
	private $db;
	private $session;
	private $result;

	/** VARIABLES **/

	private $IdContent;
	private $ContentDescription;
	private $PublicationDate;
	private $RegistryDate;
	private $UpdateDate;
	private $State;
	private $IdContentType;
	private $IdProduct;
	private $IdVersion;
	

	function __construct($el){
		
		$this->padre = $el;
		$this->db = $this->padre->lib('DB');
		$this->session = $this->padre->lib('Session');
		$this->result = array('result' => array('success' => 0, 'message' => '', 'id' => null));
	}


	/********************* MÉTODOS *********************/

    public function selectContentxId(){

    	$content = $this->db->_query("SELECT idcontent, publication_date, idcontent_type, idproduct, idversion FROM tbl_content WHERE idcontent = '".$this->getIdContent()."' AND state = 1")->fetch_object();

    	return $content;
    }


    public function selectContentxIdProductMenu(){

    	$this->session->start();

    	$sql = $this->db->_query("SELECT idcontent, idcontent_type, idproduct, idversion  FROM tbl_content WHERE idproduct = ".$this->getIdProduct()." AND state = 1 ORDER BY idcontent_type");
		$array_content = array();
		
		while($datos = $sql->fetch_object()){
			array_push($array_content, $datos);
		}

		if($array_content){
			$this->result['result']['success'] = 1;
			$this->result['result']['array_content'] = $array_content;

			if ($_SESSION['Business']['Language']=='en') {
				$this->result['result']['message'] = 'The query was successful.';
			} else {
				$this->result['result']['message'] = 'La consulta se realizó satisfactoriamente.';
			}
		}else{
			$this->result['result']['success'] = 0;
			$this->result['result']['array_content'] = null;

			if ($_SESSION['Business']['Language']=='en') {
				$this->result['result']['message'] = 'An error occurred while performing the query.';
			} else {
				$this->result['result']['message'] = 'Ocurrió un error al realizar la consulta.';
			}
		}

		return $this->result;
    }


    public function selectContentxIdProductxIdContentTypeMenu(){

    	$this->session->start();

    	$sql = $this->db->_query("SELECT idcontent, idcontent_type, idproduct, idversion  FROM tbl_content WHERE idproduct = ".$this->getIdProduct()." AND idcontent_type = ".$this->getIdContentType()." AND state = 1");
		$array_content = array();
		
		while($datos = $sql->fetch_object()){
			array_push($array_content, $datos);
		}

		if($array_content){
			$this->result['result']['success'] = 1;
			$this->result['result']['array_content'] = $array_content;

			if ($_SESSION['Business']['Language']=='en') {
				$this->result['result']['message'] = 'The query was successful.';
			} else {
				$this->result['result']['message'] = 'La consulta se realizó satisfactoriamente.';
			}
		}else{
			$this->result['result']['success'] = 0;
			$this->result['result']['array_content'] = null;

			if ($_SESSION['Business']['Language']=='en') {
				$this->result['result']['message'] = 'An error occurred while performing the query.';
			} else {
				$this->result['result']['message'] = 'Ocurrió un error al realizar la consulta.';
			}
		}

		return $this->result;
    }


    public function selectContentxIdProductxIdVersionMenu(){

    	$this->session->start();

    	$sql = $this->db->_query("SELECT idcontent, idcontent_type, idproduct, idversion FROM tbl_content WHERE idproduct = ".$this->getIdProduct()." AND idversion = ".$this->getIdVersion()." AND state = 1");
		$array_content = array();
		
		while($datos = $sql->fetch_object()){
			array_push($array_content, $datos);
		}

		if($array_content){
			$this->result['result']['success'] = 1;
			$this->result['result']['array_content'] = $array_content;

			if ($_SESSION['Business']['Language']=='en') {
				$this->result['result']['message'] = 'The query was successful.';
			} else {
				$this->result['result']['message'] = 'La consulta se realizó satisfactoriamente.';
			}
		}else{
			$this->result['result']['success'] = 0;
			$this->result['result']['array_content'] = null;

			if ($_SESSION['Business']['Language']=='en') {
				$this->result['result']['message'] = 'An error occurred while performing the query.';
			} else {
				$this->result['result']['message'] = 'Ocurrió un error al realizar la consulta.';
			}
		}

		return $this->result;
    }


    public function selectContentxIdProductIdContentTypeIdVersion(){

    	$this->session->start();

    	$sql = $this->db->_query("SELECT idcontent, publication_date FROM tbl_content WHERE idcontent_type = ".$this->getIdContentType()." AND idproduct = ".$this->getIdProduct()." AND idversion = ".$this->getIdVersion()." AND state = 1")->fetch_object();

		if($sql){
			$this->result['result']['success'] = 1;
			$this->result['result']['object_content'] = $sql;

			if ($_SESSION['Business']['Language']=='en') {
				$this->result['result']['message'] = 'The query was successful.';
			} else {
				$this->result['result']['message'] = 'La consulta se realizó satisfactoriamente.';
			}
		}else{
			$this->result['result']['success'] = 0;
			$this->result['result']['object_content'] = null;

			if ($_SESSION['Business']['Language']=='en') {
				$this->result['result']['message'] = 'An error occurred while performing the query.';
			} else {
				$this->result['result']['message'] = 'Ocurrió un error al realizar la consulta.';
			}
		}

		return $this->result;
    }


    public function insertContent(){

    	$this->session->start();

    	$content = $this->db->_query("SELECT idcontent FROM tbl_content WHERE idcontent_type = '".$this->getIdContentType()."' AND idproduct = '".$this->getIdProduct()."' AND idversion = '".$this->getIdVersion()."' AND state = 1")->fetch_object();

    	if ($content) {
    		$idcontent = $content->idcontent;
    	} else {
	    	$content = $this->db->_query("INSERT INTO tbl_content (content_description, publication_date, update_date, idcontent_type, idproduct, idversion) VALUES ('".$this->getContentDescription()."','".$this->getPublicationDate()."','".$this->getUpdateDate()."', ".$this->getIdContentType().", ".$this->getIdProduct().", ".$this->getIdVersion().") ");
			$idcontent = $this->db->mysql()->insert_id; //ID del registro insertado.
    	}

    	if ($idcontent) {
			$this->result['result']['success'] = 1;
			$this->result['result']['id'] = $idcontent;

			if ($_SESSION['Business']['Language']=='en') {
				$this->result['result']['message'] = 'Data has been successfully registered.';
			} else {
				$this->result['result']['message'] = 'Los datos se han registrado satisfactoriamente.';
			}
		} else {
			$this->result['result']['success'] = 0;
			
			if ($_SESSION['Business']['Language']=='en') {
				$this->result['result']['message'] = 'The data has not been registered, an error occurred.';
			} else {
				$this->result['result']['message'] = 'Los datos no se han registrado, ocurrió un error.';
			}
		}

    	return $this->result;
    }


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