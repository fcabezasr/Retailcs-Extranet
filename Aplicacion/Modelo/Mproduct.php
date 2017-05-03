<?php
	
class Mproduct {

	private $padre;
	private $db;
	private $result;

	/** VARIABLES **/

	private $IdProduct;
	private $ProductName;
	private $ProductIcono;
	private $ProductOrder;
	private $RegistryDate;
	private $UpdateDate;
	private $State;


	function __construct($el){
		
		$this->padre = $el;
		$this->db = $this->padre->lib('DB');
		$this->result = array('result' => array('success' => 0, 'message' => '', 'id' => null));
	}


	/********************* MÉTODOS *********************/


	public function selectProduct(){

		$sql = $this->db->_query("SELECT idproduct, product_name, product_icono, product_order, DATE_FORMAT(registry_date, '%d-%m-%Y') AS registry_date, state FROM tbl_product WHERE state = 1");
		$array_product = array();

		while($datos = $sql->fetch_object()){
			array_push($array_product, $datos);
		}

		if($array_product){
			$this->result['result']['success'] = 1;
			$this->result['result']['message'] = 'La consulta se realizó satisfactoriamente.';
			$this->result['result']['arrayProduct'] = $array_product;
		}else{
			$this->result['result']['success'] = 0;
			$this->result['result']['message'] = 'Ocurrió un error al realizar la consulta.';
			$this->result['result']['arrayProduct'] = null;
		}

		return $this->result;
	}


	public function selectProductMenu(){

		$sql = $this->db->_query("SELECT idproduct, product_name, product_icono, product_order FROM tbl_product WHERE state = 1");
		$array_product = array();

		while($datos = $sql->fetch_object()){
			array_push($array_product, $datos);
		}

		if($array_product){
			$this->result['result']['success'] = 1;
			$this->result['result']['message'] = 'La consulta se realizó satisfactoriamente.';
			$this->result['result']['array_product'] = $array_product;
		}else{
			$this->result['result']['success'] = 0;
			$this->result['result']['message'] = 'Ocurrió un error al realizar la consulta.';
			$this->result['result']['array_product'] = null;
		}

		return $this->result;
	}


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


	public function selectProductxIdProduct(){

		$sql = $this->db->_query("SELECT idproduct, product_name FROM tbl_product WHERE idproduct = ".$this->getIdProduct()." AND state = 1")->fetch_object();

		if($sql){
			$this->result['result']['success'] = 1;
			$this->result['result']['message'] = 'La consulta se realizó satisfactoriamente.';
			$this->result['result']['id'] = $sql->idproduct;
			$this->result['result']['product'] = $sql;
		}else{
			$this->result['result']['success'] = 0;
			$this->result['result']['message'] = 'Ocurrió un error al realizar la consulta.';
		}

		return $this->result;
	}


	public function selectProductxName(){

		$sql = $this->db->_query("SELECT idproduct, product_name FROM tbl_product WHERE product_name LIKE '%".$this->getProductName()."%' AND state = 1")->fetch_object();

		if($sql){
			$this->result['result']['success'] = 1;
			$this->result['result']['message'] = 'La consulta se realizó satisfactoriamente.';
			$this->result['result']['id'] = $sql->idproduct;
			$this->result['result']['product'] = $sql;
		}else{
			$this->result['result']['success'] = 0;
			$this->result['result']['message'] = 'Ocurrió un error al realizar la consulta.';
		}

		return $this->result;
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

	public function setProductIcono($ProductIcono = null){

		$this->ProductIcono = $ProductIcono;
	}

	public function getProductIcono(){
		
		return $this->ProductIcono;
	}

	public function setProductOrder($ProductOrder = null){

		$this->ProductOrder = $ProductOrder;
	}

	public function getProductOrder(){
		
		return $this->ProductOrder;
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