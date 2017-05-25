<?php
	
class Mversion {

	private $padre;
	private $db;
	private $session;
	private $result;

	/** VARIABLES **/

	private $IdVersion;
	private $VersionDescription;
	private $VersionOrder;
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

	public function selectVersion(){

		$this->session->start();

		$sql = $this->db->_query("SELECT idversion, version_description, version_order, DATE_FORMAT(registry_date, '%d-%m-%Y') AS registry_date, state FROM tbl_version WHERE 1");
		$array_version = array();

		while($datos = $sql->fetch_object()){
			array_push($array_version, $datos);
		}

		if($array_version){
			$this->result['result']['success'] = 1;
			$this->result['result']['arrayVersion'] = $array_version;

			if ($_SESSION['Business']['Language']=='en') {
				$this->result['result']['message'] = 'The query was successful.';
			} else {
				$this->result['result']['message'] = 'La consulta se realizó satisfactoriamente.';
			}
		}else{
			$this->result['result']['success'] = 0;
			$this->result['result']['arrayVersion'] = null;

			if ($_SESSION['Business']['Language']=='en') {
				$this->result['result']['message'] = 'An error occurred while performing the query.';
			} else {
				$this->result['result']['message'] = 'Ocurrió un error al realizar la consulta.';
			}
		}

		return $this->result;
	}


	public function selectVersionxIdVersion(){

		$this->session->start();
		
		$sql = $this->db->_query("SELECT idversion, version_description FROM tbl_version WHERE idversion = ".$this->getIdVersion()." AND state = 1")->fetch_object();

		if($sql){
			$this->result['result']['success'] = 1;
			$this->result['result']['object_version'] = $sql;

			if ($_SESSION['Business']['Language']=='en') {
				$this->result['result']['message'] = 'The query was successful.';
			} else {
				$this->result['result']['message'] = 'La consulta se realizó satisfactoriamente.';
			}
		}else{
			$this->result['result']['success'] = 0;
			$this->result['result']['object_version'] = null;

			if ($_SESSION['Business']['Language']=='en') {
				$this->result['result']['message'] = 'An error occurred while performing the query.';
			} else {
				$this->result['result']['message'] = 'Ocurrió un error al realizar la consulta.';
			}
		}

		return $this->result;
	}


	public function selectVersionxIdVersionMenu(){

		$this->session->start();
		
		$sql = $this->db->_query("SELECT idversion, version_description, version_order FROM tbl_version WHERE idversion = ".$this->getIdVersion()." AND state = 1")->fetch_object();
		
		if($sql){
			$this->result['result']['success'] = 1;
			$this->result['result']['object_version'] = $sql;

			if ($_SESSION['Business']['Language']=='en') {
				$this->result['result']['message'] = 'The query was successful.';
			} else {
				$this->result['result']['message'] = 'La consulta se realizó satisfactoriamente.';
			}
		}else{
			$this->result['result']['success'] = 0;
			$this->result['result']['object_version'] = null;

			if ($_SESSION['Business']['Language']=='en') {
				$this->result['result']['message'] = 'An error occurred while performing the query.';
			} else {
				$this->result['result']['message'] = 'Ocurrió un error al realizar la consulta.';
			}
		}

		return $this->result;
	}


	public function insertVersion(){

		$this->session->start();
		
		if ($this->getIdVersion()!='' || $this->getIdVersion()!=null) {
			$sql = $this->db->_query("UPDATE tbl_version SET version_description = '".$this->getVersionDescription()."', update_date = '".$this->getUpdateDate()."', state = 1 WHERE idversion = ".$this->getIdVersion()."");

			if($sql){
				$this->result['result']['success'] = 1;
				$this->result['result']['id'] = $this->getIdVersion();
				$this->result['result']['version'] = $this->getVersionDescription();
				
				if ($_SESSION['Business']['Language']=='en') {
					$this->result['result']['message'] = 'The data for the "<strong>'.$this->getVersionDescription().'</strong>" version has been updated successfully.';
					$this->result['result']['nameboton'] = 'Save';	
				} else {
					$this->result['result']['message'] = 'Los datos de la versión "<strong>'.$this->getVersionDescription().'</strong>" se han actualizado satisfactoriamente.';
					$this->result['result']['nameboton'] = 'Guardar';
				}
			} else {
				$this->result['result']['success'] = 0;
				
				if ($_SESSION['Business']['Language']=='en') {
					$this->result['result']['message'] = 'An error occurred, the data from the "<strong>'.$this->getVersionDescription().'</strong>" version was not updated.';
					$this->result['result']['nameboton'] = 'Update';					
				} else {
					$this->result['result']['message'] = 'Ocurrió un error, los datos de la versión "<strong>'.$this->getVersionDescription().'</strong>" no se ha actualizado.';
					$this->result['result']['nameboton'] = 'Actualizar';
				}
			}
		} else {
			$sql = $this->db->_query("INSERT INTO tbl_version (version_description, update_date) VALUES ('".$this->getVersionDescription()."', '".$this->getUpdateDate()."')");
			
			if($sql){
				$this->result['result']['success'] = 1;
				$this->result['result']['id'] = $this->db->mysql()->insert_id;
				$this->result['result']['version'] = $this->getVersionDescription();

				if ($_SESSION['Business']['Language']=='en') {
					$this->result['result']['message'] = 'The "<strong>'.$this->getVersionDescription().'</strong>" version has been successfully registered.';
					$this->result['result']['nameboton'] = 'Save';	
				} else {
					$this->result['result']['message'] = 'La versión "<strong>'.$this->getVersionDescription().'</strong>" se ha registrado satisfactoriamente.';
					$this->result['result']['nameboton'] = 'Guardar';
				}
			}else{
				$this->result['result']['success'] = 0;
				
				if ($_SESSION['Business']['Language']=='en') {
					$this->result['result']['message'] = 'An error occurred, the "<strong>'.$this->getVersionDescription().'</strong>" version was not registered.';
					$this->result['result']['nameboton'] = 'Save';	
				} else {
					$this->result['result']['message'] = 'Ocurrió un error, la versión "<strong>'.$this->getVersionDescription().'</strong>" no se ha registrado.';
					$this->result['result']['nameboton'] = 'Guardar';
				}
			}
		}

		return $this->result;
	}


	public function updateVersion(){

		$this->session->start();

		$sql = $this->db->_query("SELECT * FROM tbl_version WHERE idversion = ".$this->getIdVersion()."")->fetch_object();
	
		if($sql){
			$this->result['result']['success'] = 1;
			$this->result['result']['objVersion'] = $sql;

			if ($_SESSION['Business']['Language']=='en') {
				$this->result['result']['message'] = 'Update the corresponding data.';
				$this->result['result']['nameboton'] = 'Update';
			} else {
				$this->result['result']['message'] = 'Actualice los datos correspondientes.';
				$this->result['result']['nameboton'] = 'Actualizar';
			}
		} else {
			$this->result['result']['success'] = 0;
			$this->result['result']['objVersion'] = '';
			
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


	public function deleteVersion(){

		$this->session->start();

		$sql = $this->db->_query("SELECT idproduct, idversion FROM tbl_version_product WHERE idversion = ".$this->getIdVersion()." AND state = 1");

		if ($sql->num_rows > 0) {
			$this->result['result']['success'] = 0;
			
			if ($_SESSION['Business']['Language']=='en') {
				$this->result['result']['message'] = '<strong>Alert!</strong> The Version is linked to some Product, therefore can not delete it.';
			} else {
				$this->result['result']['message'] = '<strong>Alerta!</strong> La Versión está vinculado a algún Producto, por ende no puede eliminarlo.';
			}
		} else {
			$sql = $this->db->_query("UPDATE tbl_version SET state = 0 WHERE idversion = ".$this->getIdVersion()."");

			if($sql){
				$this->result['result']['success'] = 1;
				$this->result['result']['id'] = $this->getIdVersion();

				if ($_SESSION['Business']['Language']=='en') {
					$this->result['result']['message'] = 'The version has been successfully <strong>disabled</strong>.';
				} else {
					$this->result['result']['message'] = 'La versión se ha <strong>deshabilitado</strong> correctamente.';
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


	public function listVersion( $funcion ){

		$sql = $this->db->_query("SELECT idversion, version_description FROM tbl_version WHERE state = 1");
		$lista = '';
	
		while($datos = $sql->fetch_object()){
			$lista .= call_user_func($funcion, $datos->idversion, $datos->version_description);
		}

		return $lista;
	}


	public function validateVersion(){

		$this->session->start();

		$sql = $this->db->_query("SELECT idversion FROM tbl_version WHERE version_description = '".$this->getVersionDescription()."'")->fetch_object();
		
		if($sql){
			$this->result['result']['success'] = 1;
			
			if ($_SESSION['Business']['Language']=='en') {
				$this->result['result']['message'] = 'The "<strong>'.$this->getVersionDescription().'</strong>" version already exists.';
			} else {
				$this->result['result']['message'] = 'La versión "<strong>'.$this->getVersionDescription().'</strong>" ya existe.';
			}
		}else{
			$this->result['result']['success'] = 0;
			
			if ($_SESSION['Business']['Language']=='en') {
				$this->result['result']['message'] = 'An error occurred while performing the query.';
			} else {
				$this->result['result']['message'] = 'Ocurrió un error al realizar la consulta.';
			}
		}

		return $this->result;
	}


	/********************* MÉTODOS SET & GET *********************/

	public function setIdVersion($IdVersion = null){

		$this->IdVersion = $IdVersion;
	}

	public function getIdVersion(){
		
		return $this->IdVersion;
	}

	public function setVersionDescription($VersionDescription = null){

		$this->VersionDescription = $VersionDescription;
	}

	public function getVersionDescription(){
		
		return $this->VersionDescription;
	}

	public function setVersionOrder($VersionOrder = null){

		$this->VersionOrder = $VersionOrder;
	}

	public function getVersionOrder(){
		
		return $this->VersionOrder;
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