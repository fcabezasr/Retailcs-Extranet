<?php
	
class Mversion_product {

	private $padre;
	private $db;
	private $result;

	/** VARIABLES **/

	private $IdProduct;
	private $IdVersion;
	private $RegistryDescription;
	private $RegistryDate;
	private $State;


	function __construct($el){
		
		$this->padre = $el;
		$this->db = $this->padre->lib('DB');
		$this->result = array('result' => array('success' => 0, 'message' => '', 'id' => null));
	}


	/********************* MÉTODOS *********************/


	public function insertVersionProduct(){
		
		$sql = $this->db->_query("INSERT INTO tbl_version_product (idproduct, idversion, registry_description) VALUES (".$this->getIdProduct().", ".$this->getIdVersion().", '".$this->getRegistryDescription()."')");
		
		if($sql){
			$this->result['result']['success'] = 1;
			$this->result['result']['message'] = 'El producto y la versión se han asociado satisfactoriamente.';
			$this->result['result']['id'] = $this->db->mysql()->insert_id;
		}else{
			$this->result['result']['success'] = 0;
			$this->result['result']['message'] = 'El producto y la versión no se han asociado, ocurrió un error.';
		}

		return $this->result;
	}


    public function selectVersionProductxIdProduct(){

    	$version_product = $this->db->_query("SELECT idproduct, idversion FROM tbl_version_product WHERE idproduct = ".$this->getIdProduct()." AND state = 1");
    	
    	$arrayVersionProduct = array();
    	while ($result = $version_product->fetch_object()) {
    		array_push($arrayVersionProduct, $result);
    	}

    	return $arrayVersionProduct;
    }


    public function selectVersionProductxIdProductxIdVersion(){

    	$version_product = $this->db->_query("SELECT idproduct, idversion FROM tbl_version_product WHERE idproduct = ".$this->getIdProduct()." AND idversion = ".$this->getIdVersion()." AND state = 1");

    	$arrayVersionProduct = array();
    	while ($result = $version_product->fetch_object()) {
    		array_push($arrayVersionProduct, $result);
    	}

    	return $arrayVersionProduct;
    }

	/********************* MÉTODOS SET & GET *********************/

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

	public function setRegistryDescription($RegistryDescription = null){

		$this->RegistryDescription = $RegistryDescription;
	}

	public function getRegistryDescription(){
		
		return $this->RegistryDescription;
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