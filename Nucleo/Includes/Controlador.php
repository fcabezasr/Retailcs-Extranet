<?php
namespace Nucleo\Includes;

class Controlador {

	public $lib = array();
	public $modelo = array();

	function __construct(){}



	public function inc($archivo){
		require $archivo; 
	}


	public function lib($lib){

		if(!isset($this->lib[$lib])){
			${"clase"} = "\\Nucleo\\Librerias\\".$lib;
			$this->lib[$lib] = new ${"clase"}($this);
		} 

		return $this->lib[$lib];
	}


	public function modelo($model, $nuevo = false ){

		if(!isset($this->modelo[$model]) || $nuevo ){
			if(file_exists(DIR_MODELO.$model.EXT_PHP)){
				include_once (DIR_MODELO.$model.EXT_PHP);
				${"clase"} = basename($model);
				$this->modelo[$model] = new ${"clase"}($this);
			} 
		} 

		return $this->modelo[$model];
	}


	public function vista($archivo, $parametros = array(), $retorno = false){
		
		$archivo = DIR_VISTA.$archivo.".phtml";
		if (is_file($archivo)) {
		    ob_start(); $modelo = _isset($this->modelo); if(is_array($parametros) && count($parametros) > 0) extract($parametros);  include $archivo; 
			if($retorno) return ob_get_clean(); echo ob_get_clean();
		}
	}

}
