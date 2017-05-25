<?php
	
class Mversion_product {

	private $padre;
	private $db;
	private $session;
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
		$this->session = $this->padre->lib('Session');
		$this->result = array('result' => array('success' => 0, 'message' => '', 'id' => null));
	}


	/********************* MÉTODOS *********************/

    public function selectVersionProduct(){

    	$this->session->start();

    	$sql = $this->db->_query("SELECT idproduct, idversion, registry_description, registry_date, state FROM tbl_version_product WHERE 1");
		$array_version_product = array();
		
		while($datos = $sql->fetch_object()){
			array_push($array_version_product, $datos);
		}

		if($array_version_product){
			$this->result['result']['success'] = 1;
			$this->result['result']['array_version_product'] = $array_version_product;

			if ($_SESSION['Business']['Language']=='en') {
				$this->result['result']['message'] = 'The query was successful.';
			} else {
				$this->result['result']['message'] = 'La consulta se realizó satisfactoriamente.';
			}
		}else{
			$this->result['result']['success'] = 0;
			$this->result['result']['array_version_product'] = null;

			if ($_SESSION['Business']['Language']=='en') {
				$this->result['result']['message'] = 'An error occurred while performing the query.';
			} else {
				$this->result['result']['message'] = 'Ocurrió un error al realizar la consulta.';
			}
		}

		return $this->result;
    }


    public function selectVersionProductxIdProductMenu(){

    	$this->session->start();

    	$sql = $this->db->_query("SELECT idproduct, idversion FROM tbl_version_product WHERE idproduct = ".$this->getIdProduct()." AND state = 1");
		$array_version_product = array();
		
		while($datos = $sql->fetch_object()){
			array_push($array_version_product, $datos);
		}

		if($array_version_product){
			$this->result['result']['success'] = 1;
			$this->result['result']['array_version_product'] = $array_version_product;

			if ($_SESSION['Business']['Language']=='en') {
				$this->result['result']['message'] = 'The query was successful.';
			} else {
				$this->result['result']['message'] = 'La consulta se realizó satisfactoriamente.';
			}
		}else{
			$this->result['result']['success'] = 0;
			$this->result['result']['array_version_product'] = null;

			if ($_SESSION['Business']['Language']=='en') {
				$this->result['result']['message'] = 'An error occurred while performing the query.';
			} else {
				$this->result['result']['message'] = 'Ocurrió un error al realizar la consulta.';
			}
		}

		return $this->result;
    }


    public function selectVersionProductxIdProduct(){

    	$this->session->start();

    	$sql = $this->db->_query("SELECT idproduct, idversion FROM tbl_version_product WHERE idproduct = ".$this->getIdProduct()." AND state = 1");
    	$arrayVersionProduct = array();

    	while ($datos = $sql->fetch_object()) {
    		array_push($arrayVersionProduct, $datos);
    	}

		if($arrayVersionProduct){
			$this->result['result']['success'] = 1;
			$this->result['result']['arrayVersionProduct'] = $arrayVersionProduct;

			if ($_SESSION['Business']['Language']=='en') {
				$this->result['result']['message'] = 'The query was successful.';
			} else {
				$this->result['result']['message'] = 'La consulta se realizó satisfactoriamente.';
			}
		}else{
			$this->result['result']['success'] = 0;
			$this->result['result']['arrayVersionProduct'] = null;

			if ($_SESSION['Business']['Language']=='en') {
				$this->result['result']['message'] = 'An error occurred while performing the query.';
			} else {
				$this->result['result']['message'] = 'Ocurrió un error al realizar la consulta.';
			}
		}

		return $this->result;
    }


    public function selectVersionProductxIdProductxIdVersion(){

    	$this->session->start();

    	$sql = $this->db->_query("SELECT idproduct, idversion FROM tbl_version_product WHERE idproduct = ".$this->getIdProduct()." AND idversion = ".$this->getIdVersion()." AND state = 1");

    	$arrayVersionProduct = array();
    	while ($datos = $sql->fetch_object()) {
    		array_push($arrayVersionProduct, $datos);
    	}

		if($sql){
			$this->result['result']['success'] = 1;
			$this->result['result']['arrayVersionProduct'] = $arrayVersionProduct;

			if ($_SESSION['Business']['Language']=='en') {
				$this->result['result']['message'] = 'The query was successful.';
			} else {
				$this->result['result']['message'] = 'La consulta se realizó satisfactoriamente.';
			}
		}else{
			$this->result['result']['success'] = 0;
			$this->result['result']['arrayVersionProduct'] = null;

			if ($_SESSION['Business']['Language']=='en') {
				$this->result['result']['message'] = 'An error occurred while performing the query.';
			} else {
				$this->result['result']['message'] = 'Ocurrió un error al realizar la consulta.';
			}
		}

		return $this->result;
    }


	public function insertVersionProduct(){

		$this->session->start();

		if ($this->getState()) {
			$sql = $this->db->_query("SELECT idproduct, idversion FROM tbl_version_product WHERE idproduct = ".$this->getIdProduct()." AND idversion = ".$this->getIdVersion()."")->fetch_object();

			if ($sql) {
				$this->result['result']['success'] = 0;
				
				if ($_SESSION['Business']['Language']=='en') {
					$this->result['result']['message'] = 'The link between the product and the version already exists.';			
				} else {
					$this->result['result']['message'] = 'La vinculación entre el producto y la versión ya existe.';
				}
			} else {
				$sql = $this->db->_query("INSERT INTO tbl_version_product (idproduct, idversion, registry_description) VALUES (".$this->getIdProduct().", ".$this->getIdVersion().", '".$this->getRegistryDescription()."')");
			
				if($sql){
					$this->result['result']['success'] = 1;
					
					if ($_SESSION['Business']['Language']=='en') {
						$this->result['result']['message'] = 'The product and version have been successfully associated.';
						$this->result['result']['nameboton'] = 'Save';	
					} else {
						$this->result['result']['message'] = 'El producto y la versión se han asociado satisfactoriamente.';
						$this->result['result']['nameboton'] = 'Guardar';
					}
				}else{
					$this->result['result']['success'] = 0;
					
					if ($_SESSION['Business']['Language']=='en') {
						$this->result['result']['message'] = 'An error occurred, the product and version have not been associated.';
						$this->result['result']['nameboton'] = 'Save';	
					} else {
						$this->result['result']['message'] = 'Ocurrió un error., el producto y la versión no se han asociado.';
						$this->result['result']['nameboton'] = 'Guardar';
					}
				}
			}			
		} else {
			$sql = $this->db->_query("UPDATE tbl_version_product SET registry_description = '".$this->getRegistryDescription()."', state = 1 WHERE idproduct = ".$this->getIdProduct()." AND idversion = ".$this->getIdVersion()."");
			
			if($sql){
				$this->result['result']['success'] = 1;
				
				if ($_SESSION['Business']['Language']=='en') {
					$this->result['result']['message'] = 'The version and product link data has been successfully updated.';
					$this->result['result']['nameboton'] = 'Save';
				} else {
					$this->result['result']['message'] = 'Los datos de la vinculación de la versión y el producto se han actualizado satisfactoriamente.';
					$this->result['result']['nameboton'] = 'Guardar';
				}
			} else {
				$this->result['result']['success'] = 0;
				
				if ($_SESSION['Business']['Language']=='en') {
					$this->result['result']['message'] = 'An error occurred, the version binding data and the product have not been updated.';
					$this->result['result']['nameboton'] = 'Update';
				} else {
					$this->result['result']['message'] = 'Ocurrió un error, los datos de la vinculación de la versión y el producto no se han actualizado.';
					$this->result['result']['nameboton'] = 'Actualizar';
				}
			}
		}

		return $this->result;
	}


    public function updateVersionProduct(){

    	$this->session->start();

    	$sql = $this->db->_query("SELECT * FROM tbl_version_product WHERE idproduct = ".$this->getIdProduct()." AND idversion = ".$this->getIdVersion()."")->fetch_object();

		if($sql){
			$this->result['result']['success'] = 1;
			$this->result['result']['objVersionProduct'] = $sql;

			if ($_SESSION['Business']['Language']=='en') {
				$this->result['result']['message'] = 'Update the corresponding data.';
				$this->result['result']['nameboton'] = 'Update';
			} else {
				$this->result['result']['message'] = 'Actualice los datos correspondientes.';
				$this->result['result']['nameboton'] = 'Actualizar';
			}
		}else{
			$this->result['result']['success'] = 0;
			$this->result['result']['objVersionProduct'] = null;
			
			if ($_SESSION['Business']['Language']=='en') {
				$this->result['result']['message'] = 'An error occurred while performing the query.';
				$this->result['result']['nameboton'] = 'Save';
			} else {
				$this->result['result']['message'] = 'Ocurrió un error al realizar la consulta.';
				$this->result['result']['nameboton'] = 'Guardar';
			}
		}

		return $this->result;
    }


	public function deleteVersionProduct(){

		$this->session->start();

		$sql = $this->db->_query("SELECT idcontent FROM tbl_content WHERE idproduct = ".$this->getIdProduct()." AND idversion = ".$this->getIdVersion()." AND state = 1");
		$num_content = $sql->num_rows;

		$sql = $this->db->_query("SELECT idfile FROM tbl_file WHERE idproduct = '".$this->getIdProduct()."' AND idversion = '".$this->getIdVersion()."' AND state = 1");
		$num_file = $sql->num_rows;

		if (($num_content + $num_file) > 0) {
			$this->result['result']['success'] = 0;
			
			if ($_SESSION['Business']['Language']=='en') {
				$this->result['result']['message'] = '<strong>Alert!</strong> The Version & Product is linked to some Content or File, therefore you can not delete it.';
			} else {
				$this->result['result']['message'] = '<strong>Alerta!</strong> La Versión & Producto está vinculado a algún Contenido o Archivo, por ende no puede eliminarlo.';
			}
		} else {
			$sql = $this->db->_query("UPDATE tbl_version_product SET state = 0 WHERE idproduct = ".$this->getIdProduct()." AND idversion = ".$this->getIdVersion()."");

			if($sql){
				$this->result['result']['success'] = 1;
				
				if ($_SESSION['Business']['Language']=='en') {
					$this->result['result']['message'] = 'The product version has been <strong>disabled</strong> successfully.';
				} else {
					$this->result['result']['message'] = 'La versión - producto se ha <strong>deshabilitado</strong> correctamente.';
				}
			} else {
				$this->result['result']['success'] = 0;
				
				if ($_SESSION['Business']['Language']=='en') {
					$this->result['result']['message'] = 'An error occurred, redo the action.';
				} else {
					$this->result['result']['message'] = 'Ocurrió un error, vuelva a realizar la acción.';
				}
			}
		}

		return $this->result;
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