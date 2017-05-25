<?php
	
class Muser {

	private $padre;
	private $db;
	private $session;
	private $result;

	/** VARIABLES **/

	private $IdUser;
	private $UserName;
	private $UserPass;
	private $UserIcono;
	private $RegistryDate;
	private $UpdateDate;
	private $State;
	private $IdTypeUser;
	private $IdBusiness;


	function __construct($el){
		
		$this->padre = $el;
		$this->db = $this->padre->lib('DB');
		$this->session = $this->padre->lib('Session');
		$this->result = array('result' => array('success' => 0, 'message' => '', 'id' => null));
	}


	/********************* MÉTODOS *********************/

	public function selectUser(){

		$this->session->start();

		$sql = $this->db->_query("SELECT iduser, user_name, user_pass, DATE_FORMAT(registry_date, '%d-%m-%Y') AS registry_date, state, idtype_user, idbusiness FROM tbl_user WHERE 1");
		$arrayUser = array();
	
		while($datos = $sql->fetch_object()){
			array_push($arrayUser, $datos);
		}

		if($arrayUser){
			$this->result['result']['success'] = 1;
			$this->result['result']['arrayUser'] = $arrayUser;

			if ($_SESSION['Business']['Language']=='en') {
				$this->result['result']['message'] = 'The query was successful.';
			} else {
				$this->result['result']['message'] = 'La consulta se realizó satisfactoriamente.';
			}
		}else{
			$this->result['result']['success'] = 0;
			$this->result['result']['arrayUser'] = null;

			if ($_SESSION['Business']['Language']=='en') {
				$this->result['result']['message'] = 'An error occurred while performing the query.';
			} else {
				$this->result['result']['message'] = 'Ocurrió un error al realizar la consulta.';
			}
		}

		return $this->result;
	}


	public function insertUser(){

		$this->session->start();
		
		if ($this->getIdUser()!='' || $this->getIdUser()!=null) {
			$sql = $this->db->_query("UPDATE tbl_user SET user_name = '".$this->getUserName()."', user_pass = '".$this->getUserPass()."', update_date = '".$this->getUpdateDate()."', idtype_user = ".$this->getIdTypeUser().", idbusiness = ".$this->getIdBusiness().", state = 1 WHERE iduser = ".$this->getIdUser()."");

			if($sql){
				$this->result['result']['success'] = 1;
				$this->result['result']['id'] = $this->getIdUser();
				$this->result['result']['username'] = $this->getUserName();			

				if ($_SESSION['Business']['Language']=='en') {
					$this->result['result']['message'] = 'The user data "<strong>'.$this->getUserName().'</strong>" has been updated successfully.';
					$this->result['result']['nameboton'] = 'Save';
				} else {
					$this->result['result']['message'] = 'Los datos del usuario "<strong>'.$this->getUserName().'</strong>" se han actualizado satisfactoriamente.';
					$this->result['result']['nameboton'] = 'Guardar';
				}
			} else {
				$this->result['result']['success'] = 0;
				$this->result['result']['id'] = '';
				$this->result['result']['username'] = '';
				
				if ($_SESSION['Business']['Language']=='en') { 
					$this->result['result']['message'] = 'An error occurred, the user data "<strong>'.$this->getUserName().'</strong>" was not updated.';
					$this->result['result']['nameboton'] = 'Update';
				} else {
					$this->result['result']['message'] = 'Ocurrió un error, los datos del usuario "<strong>'.$this->getUserName().'</strong>" no se ha actualizado.';
					$this->result['result']['nameboton'] = 'Actualizar';
				}
			}			
		} else {
			$sql = $this->db->_query("INSERT INTO tbl_user (user_name, user_pass, update_date, idtype_user, idbusiness) VALUES ('".$this->getUserName()."', '".$this->getUserPass()."', '".$this->getUpdateDate()."', ".$this->getIdTypeUser().", ".$this->getIdBusiness().")");

			if($sql){
				$this->result['result']['success'] = 1;
				$this->result['result']['id'] = $this->db->mysql()->insert_id;
				$this->result['result']['username'] = $this->getUserName();
				
				if ($_SESSION['Business']['Language']=='en') {
					$this->result['result']['message'] = 'The user "<strong>'.$this->getUserName().'</strong>" has been successfully registered.';
					$this->result['result']['nameboton'] = 'Save';
				} else {
					$this->result['result']['message'] = 'El usuario "<strong>'.$this->getUserName().'</strong>" se ha registrado satisfactoriamente.';
					$this->result['result']['nameboton'] = 'Guardar';
				}
			} else {
				$this->result['result']['success'] = 0;
				$this->result['result']['id'] = '';
				$this->result['result']['username'] = '';
				
				if ($_SESSION['Business']['Language']=='en') {
					$this->result['result']['message'] = 'An error occurred, the user "<strong>'.$this->getUserName().'</strong>" was not registered.';
					$this->result['result']['nameboton'] = 'Save';
				} else {
					$this->result['result']['message'] = 'Ocurrió un error, el usuario "<strong>'.$this->getUserName().'</strong>" no se ha registrado.';
					$this->result['result']['nameboton'] = 'Guardar';
				}
			}
		}

		return $this->result;
	}


	public function updateUser(){

		$this->session->start();

		$sql = $this->db->_query("SELECT * FROM tbl_user WHERE iduser = ".$this->getIdUser()."")->fetch_object();
	
		if($sql){
			$this->result['result']['success'] = 1;
			$this->result['result']['objUser'] = $sql;
			
			if ($_SESSION['Business']['Language']=='en') {
				$this->result['result']['message'] = 'Update the corresponding data.';
				$this->result['result']['nameboton'] = 'Update';
			} else {
				$this->result['result']['message'] = 'Actualice los datos correspondientes.';
				$this->result['result']['nameboton'] = 'Actualizar';
			}
		} else {
			$this->result['result']['success'] = 0;
			$this->result['result']['objUser'] = '';
			
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


	public function deleteUser(){

		$this->session->start();

		$sql = $this->db->_query("UPDATE tbl_user SET state = 0 WHERE iduser = ".$this->getIdUser()."");

		if($sql){
			$this->result['result']['success'] = 1;
			$this->result['result']['id'] = $this->getIdUser();

			if ($_SESSION['Business']['Language']=='en') {
				$this->result['result']['message'] = 'The user has been successfully <strong>disabled</strong>.';
			} else {
				$this->result['result']['message'] = 'El usuario se ha <strong>deshabilitado</strong> correctamente.';
			}
		} else {
			$this->result['result']['success'] = 0;
			
			if ($_SESSION['Business']['Language']=='en') {
				$this->result['result']['message'] = 'An error occurred, redo the action.';
			} else {
				$this->result['result']['message'] = 'Ocurrió un error, vuelva a realizar la acción.';
			}
		}

		return $this->result;
	}


	public function validateUser(){

		$this->session->start();

		$sql = $this->db->_query("SELECT iduser FROM tbl_user WHERE user_name = '".$this->getUserName()."'")->fetch_object();
		
		if($sql){
			$this->result['result']['success'] = 1;
			
			if ($_SESSION['Business']['Language']=='en') {
				$this->result['result']['message'] = 'The user "<strong>'.$this->getUserName().'</strong>" already exists.';
			} else {
				$this->result['result']['message'] = 'El usuario "<strong>'.$this->getUserName().'</strong>" ya existe.';
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


	public function iniciarSession(){

		$this->session->start();
		
		$user_name = $this->db->_query("SELECT * FROM tbl_user WHERE user_name = '".$this->getUserName()."' AND state = 1")->fetch_object();
		
		// State = 0 : Usuario y contraseña incorrectos
		$this->result['result']['success'] = 0;
		$this->result['result']['message'] = 'Usuario y contraseña incorrectos.';	
		if (!($user_name)) {
			// State = 2 : El usuario no existe
			$this->result['result']['success'] = 2;
			$this->result['result']['message'] = 'El usuario no existe.';		
		} else {
			$user = $this->db->_query("SELECT * FROM tbl_user WHERE user_name = '".$this->getUserName()."' AND user_pass = '".$this->getUserPass()."' AND state = 1")->fetch_object();

			if ($user) {

				$business = $this->db->_query("SELECT * FROM tbl_business WHERE idbusiness = ".$user->idbusiness." AND state = 1")->fetch_object();
				
				$_SESSION['User']['Id'] = $user->iduser;
				$_SESSION['User']['Name'] = $user->user_name;
				$_SESSION['User']['Type'] = $user->idtype_user;
				$_SESSION['Business']['Id'] = $user->idbusiness;
				$_SESSION['Business']['Name'] = $business->business_name;
				$_SESSION['Business']['Language'] = $business->language;

				// State = 1 : Usuario correcto
				$this->result['result']['success'] = 1;
				$this->result['result']['message'] = 'Usuario y contraseña correctos.';
				$this->result['result']['id'] = $user->iduser;
			} else {
				// State = 3 : La contraseña es incorrecta
				$this->result['result']['success'] = 3;
				$this->result['result']['message'] = 'La contraseña es incorrecta.';
			}
		}

		return $this->result;
	}


	public function cerrarSession(){

		$this->session->start();
		$this->session->destroy();

		if (isset($_SESSION['User'])) {
			$this->result['result']['success'] = 0;
			$this->result['result']['message'] = 'Ocurrió un problema al finalizar sesión.';
		} else {
			$this->result['result']['success'] = 1;
			$this->result['result']['message'] = 'La sesión ha finalizado correctamente.';
		}

		return $this->result;
	}


	public function validarSession(){

		$this->session->start();

		if (isset($_SESSION['User'])) {
			$this->result['result']['success'] = 1;
			$this->result['result']['message'] = 'Se ha iniciado sesión correctamente.';
			$this->result['result']['id'] = $_SESSION['User']['Id'];
			$this->result['result']['name'] = $_SESSION['User']['Name'];
		} else {
			$this->result['result']['success'] = 0;
			$this->result['result']['message'] = 'Los datos son incorrectos.';
		}

		return $this->result;
	}
	

	/********************* MÉTODOS SET & GET *********************/

	public function setIdUser($IdUser = null){

		$this->IdUser = $IdUser;
	}

	public function getIdUser(){

		return $this->IdUser;
	}

	public function setUserName($UserName = null){

		$this->UserName = $UserName;
	}

	public function getUserName(){

		return $this->UserName;
	}

	public function setUserPass($UserPass = null){

		$this->UserPass = $UserPass;
	}

	public function getUserPass(){

		return $this->UserPass;
	}

	public function setUserIcono($UserIcono = null){

		$this->UserIcono = $UserIcono;
	}

	public function getUserIcono(){
		
		return $this->UserIcono;
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

	public function setIdTypeUser($IdTypeUser = null){

		$this->IdTypeUser = $IdTypeUser;
	}

	public function getIdTypeUser(){

		return $this->IdTypeUser;
	}

	public function setIdBusiness($IdBusiness = null){

		$this->IdBusiness = $IdBusiness;
	}

	public function getIdBusiness(){

		return $this->IdBusiness;
	}

}