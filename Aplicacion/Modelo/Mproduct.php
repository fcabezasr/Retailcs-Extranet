<?php
	
class Mproduct {

	private $padre;
	private $db;
	private $result;

	/** VARIABLES **/

	private $IdProduct;
	private $ProductName;
	private $RegistryDate;
	private $State;


	function __construct($el){
		
		$this->padre = $el;
		$this->db = $this->padre->lib('DB');
		$this->result = array('result' => array('success' => 0, 'message' => '', 'id' => null));
	}


	/********************* MÉTODOS *********************/


	public function insertProduct(){
		
		$sql = $this->db->_query("INSERT INTO tbl_product (product_name) VALUES ('".$this->getProductName()."')");
		
		if($sql){
			$this->result['result']['success'] = 1;
			$this->result['result']['message'] = 'El producto <strong>'.$this->getProductName().'</strong> se ha registrado satisfactoriamente.';
			$this->result['result']['id'] = $this->db->mysql()->insert_id;
			$this->result['result']['product'] = $this->getProductName();
		}else{
			$this->result['result']['success'] = 0;
			$this->result['result']['message'] = 'El producto <strong>'.$this->getProductName().'</strong> no se ha registrado, ocurrió un error.';
		}

		return $this->result;
	}


	public function selectProductxName(){

		$product = $this->db->_query("SELECT idproduct, product_name FROM tbl_product WHERE product_name LIKE '%".$this->getProductName()."%' AND state = 1")->fetch_object();

		return $product;
	}


	public function listProduct( $funcion ){

		$sql = $this->db->_query("SELECT idproduct, product_name FROM tbl_product WHERE state = 1");
		$lista = '';
	
		while($datos = $sql->fetch_object()){
			$lista .= call_user_func($funcion, $datos->idproduct, $datos->product_name);
		}

		return $lista;
	}


	/********************* MÉTODOS SET & GET *********************/

	public function setIdProduct($IdProduct = null){

		$this->IdProduct = $IdProduct;
	}

	public function getIdProduct(){
		
		return $this->IdProduct;
	}

	public function setProductName($ProductName = null){

		$this->ProductName = $ProductName;
	}

	public function getProductName(){
		
		return $this->ProductName;
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