<?php

class User extends Nucleo\Includes\Controlador{

	public $obj = null;

	function __construct(){

		parent::__construct();
	}


	// Método que se llama por defecto
	public function index(){

	}


	public function validateUser($user_name = null){

		$m_user = $this->modelo('Muser');
		$m_user->setUserName($user_name);
		$result = $m_user->validateUser();

		echo json_encode($result);
	}


	public function validateTypeUser($description = null){

		$m_type_user = $this->modelo('Mtype_user');
		$m_type_user->setDescription($description);
		$result = $m_type_user->validateTypeUser();

		echo json_encode($result);
	}

}