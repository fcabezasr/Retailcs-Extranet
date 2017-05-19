<?php
	
class Mtype_user {

	private $padre;
	private $db;
	private $result;

	/** VARIABLES **/

	private $IdTypeUser;
	private $Description;
	private $RegistryDate;
	private $UpdateDate;
	private $State;


	function __construct($el){
		
		$this->padre = $el;
		$this->db = $this->padre->lib('DB');
		$this->result = array('result' => array('success' => 0, 'message' => '', 'id' => null));
	}


	/********************* MÉTODOS *********************/


	public function selectTypeUser(){

		$sql = $this->db->_query("SELECT idtype_user, description, DATE_FORMAT(registry_date, '%d-%m-%Y') AS registry_date, state FROM tbl_type_user WHERE 1");
		$arrayTypeUser = array();
	
		while($datos = $sql->fetch_object()){
			array_push($arrayTypeUser, $datos);
		}

		if($arrayTypeUser){
			$this->result['result']['success'] = 1;
			$this->result['result']['message'] = 'La consulta se realizó satisfactoriamente.';
			$this->result['result']['arrayTypeUser'] = $arrayTypeUser;
		}else{
			$this->result['result']['success'] = 0;
			$this->result['result']['message'] = 'Ocurrió un error al realizar la consulta.';
			$this->result['result']['arrayTypeUser'] = null;
		}

		return $this->result;
	}


    public function selectTypeUserxId(){

    	$type_user = $this->db->_query("SELECT idtype_user, description FROM tbl_type_user WHERE idtype_user = '".$this->getIdTypeUser()."' AND state = 1")->fetch_object();

		if($type_user){
			$this->result['result']['success'] = 1;
			$this->result['result']['message'] = 'La consulta se realizó satisfactoriamente.';
			$this->result['result']['type_user'] = $type_user;
		}else{
			$this->result['result']['success'] = 0;
			$this->result['result']['message'] = 'Ocurrió un error al realizar la consulta.';
			$this->result['result']['type_user'] = null;
		}

		return $this->result;
    }


	public function insertTypeUser(){
		
		if ($this->getIdTypeUser()!='' || $this->getIdTypeUser()!=null) {
			$sql = $this->db->_query("UPDATE tbl_type_user SET description = '".$this->getDescription()."', update_date = '".$this->getUpdateDate()."', state = 1 WHERE idtype_user = ".$this->getIdTypeUser()."");

			if($sql){
				$this->result['result']['success'] = 1;
				$this->result['result']['message'] = 'Los datos del tipo de usuario "<strong>'.$this->getDescription().'</strong>" se han actualizado satisfactoriamente.';
				$this->result['result']['id'] = $this->getIdTypeUser();
				$this->result['result']['description'] = $this->getDescription();
				$this->result['result']['nameboton'] = 'Guardar';
			} else {
				$this->result['result']['success'] = 0;
				$this->result['result']['message'] = 'Ocurrió un error, los datos del tipo de usuario "<strong>'.$this->getDescription().'</strong>" no se ha actualizado.';
				$this->result['result']['id'] = '';
				$this->result['result']['description'] = '';
				$this->result['result']['nameboton'] = 'Actualizar';
			}
		} else {
			$sql = $this->db->_query("INSERT INTO tbl_type_user (description, update_date) VALUES ('".$this->getDescription()."', '".$this->getUpdateDate()."')");

			if($sql){
				$this->result['result']['success'] = 1;
				$this->result['result']['message'] = 'El tipo de usuario "<strong>'.$this->getDescription().'</strong>" se ha registrado satisfactoriamente.';
				$this->result['result']['id'] = $this->db->mysql()->insert_id;
				$this->result['result']['description'] = $this->getDescription();
				$this->result['result']['nameboton'] = 'Guardar';
			}else{
				$this->result['result']['success'] = 0;
				$this->result['result']['message'] = 'Ocurrió un error, el tipo de usuario "<strong>'.$this->getDescription().'</strong>"" no se ha registrado.';
				$this->result['result']['id'] = '';
				$this->result['result']['description'] = '';
				$this->result['result']['nameboton'] = 'Guardar';
			}
		}

		return $this->result;
	}


	public function updateTypeUser(){

		$sql = $this->db->_query("SELECT * FROM tbl_type_user WHERE idtype_user = ".$this->getIdTypeUser()."")->fetch_object();
	
		if($sql){
			$this->result['result']['success'] = 1;
			$this->result['result']['message'] = 'Actualice los datos correspondientes.';
			$this->result['result']['objTypeUser'] = $sql;
			$this->result['result']['nameboton'] = 'Actualizar';
		} else {
			$this->result['result']['success'] = 0;
			$this->result['result']['message'] = 'Ocurrió un error al realizar la consulta.';
			$this->result['result']['objTypeUser'] = '';
			$this->result['result']['nameboton'] = 'Guardar';
		}

		return $this->result;
	}


	public function deleteTypeUser(){

		$sql = $this->db->_query("SELECT iduser FROM tbl_user WHERE idtype_user = ".$this->getIdTypeUser()." AND state = 1");

		if ($sql->num_rows > 0) {
			$this->result['result']['success'] = 0;
			$this->result['result']['message'] = '<strong>Alerta!</strong> El Tipo de Usuario está vinculado a algún Usuario, por ende no puede eliminarlo.';
		} else {
			$sql = $this->db->_query("UPDATE tbl_type_user SET state = 0 WHERE idtype_user = ".$this->getIdTypeUser()."");

			if($sql){
				$this->result['result']['success'] = 1;
				$this->result['result']['message'] = 'El tipo de usuario se ha <strong>deshabilitado</strong> correctamente.';
				$this->result['result']['id'] = $this->getIdTypeUser();
			} else {
				$this->result['result']['success'] = 0;
				$this->result['result']['message'] = 'Ocurrió un error, vuelva a realizar la acción.';
			}
		}

		return $this->result;
	}


	public function validateTypeUser(){

		$sql = $this->db->_query("SELECT idtype_user FROM tbl_type_user WHERE description = '".$this->getDescription()."'")->fetch_object();
		
		if($sql){
			$this->result['result']['success'] = 1;
			$this->result['result']['message'] = 'El tipo de usuario "<strong>'.$this->getDescription().'</strong>" ya existe.';
		}else{
			$this->result['result']['success'] = 0;
			$this->result['result']['message'] = 'Ocurrió un error al realizar la consulta.';
		}

		return $this->result;
	}


	public function listTypeUser( $funcion ){

		$sql = $this->db->_query("SELECT idtype_user, description FROM tbl_type_user WHERE state = 1");
		$lista = '';
	
		while($datos = $sql->fetch_object()){
			$lista .= call_user_func($funcion, $datos->idtype_user, $datos->description);
		}

		return $lista;
	}	


	/********************* MÉTODOS SET & GET *********************/

	public function setIdTypeUser($IdTypeUser = null){

		$this->IdTypeUser = $IdTypeUser;
	}

	public function getIdTypeUser(){

		return $this->IdTypeUser;
	}

	public function setDescription($Description = null){

		$this->Description = $Description;
	}

	public function getDescription(){
		
		return $this->Description;
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