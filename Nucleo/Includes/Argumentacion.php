<?php
namespace Nucleo\Includes;

define('INC', dirname(__FILE__)."/" );

require INC.'Constantes.php';
require INC.'Config.php';
require INC.'funciones.php';

class Argumentacion  {

	private $argv = array();

	function __construct(){

		$this->argv = self::argumentos();

		${"c"} = DIR_CONTROLADOR.$this->argv['clase'].EXT_PHP;

		if(file_exists(${"c"})){
			require ${"c"};

			$c = (new $this->argv['clase']($this));

			if(isset($this->argv['metodo'])){

					if(method_exists($c, $this->argv['metodo'] ) && is_callable(array($c, $this->argv['metodo'] ))   ) { 
			
						call_user_func_array(array($c, $this->argv['metodo']), count($this->argv['argv'])>0 ? $this->argv['argv'] : array(null) );
			
					} else {
			
						require RUTA_ERROR_404;			
					}			
			} else if( method_exists($c, 'index') ) call_user_func(array($c, 'index') );			
		
		} else {		
			require RUTA_ERROR_404;		
		}
	}

	private function argumentos(){

		$d = str_replace(dirname($_SERVER['SCRIPT_NAME']), '', _isset($_SERVER["REQUEST_URI"]) );
		$d = preg_split('/\?/',$d);
		$s = explode('/',trim( _isset($d[0]),'/'));
	 	$c = ucfirst(strtolower(_isset($s[0])));

		$clase  = ( !empty($c) ) ? $c : 'Inicio';
		$metodo = isset($s[1]) ? $s[1] : null;
		$argv = $s;
		array_splice($argv, 0, 2);

		return array("clase" => $clase, "metodo" => $metodo, "argv" => $argv );

	}

}
