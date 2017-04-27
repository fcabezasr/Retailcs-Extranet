<?php

class Login extends Nucleo\Includes\Controlador{

	function __construct(){

		parent::__construct();
	}

	// Método que se llama por defecto
	public function index($name = null){

		if (isset($name)) $name = $name;
		else $name = 'login';
		
		parent::vista(DIR_COMPONENTES.$name, '');
	}


	public function iniciarSession($usuario = null, $contrasena = null){

		$user = $this->modelo('Muser');

		$user->setUserName(not_html_script($usuario));
		$user->setUserPass(not_html_script($contrasena));

		$result = $user->iniciarSession();

		echo json_encode($result);
	}


	public function cerrarSession(){

		$user = $this->modelo('Muser');

		$estado = $user->cerrarSession();

		if ($estado) {
			header('Location: ../');
		}
	}

}
