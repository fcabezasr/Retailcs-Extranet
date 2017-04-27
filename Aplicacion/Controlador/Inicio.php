<?php

class Inicio extends Nucleo\Includes\Controlador{

	function __construct(){

		parent::__construct();
	}

	// Método que se llama por defecto
	public function index($name = null){

		$user = $this->modelo('Muser');
		$result = $user->validarSession();

		if ($result['result']['success']) {
			if (isset($name)) $name = $name;
			else $name = 'index';
			$inc = parent::vista(DIR_COMPONENTES.$name, '', true);
			$params =  array("page" => $inc);

			parent::vista("contenedor", $params);
		} else {
			header('Location: ./login/');
		}

	}

}
