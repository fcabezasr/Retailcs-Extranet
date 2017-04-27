<?php
namespace Nucleo\Librerias;

class DB  {

    private static $instancia; 

    function __construct(){}
 	private function __wake(){}
    private function __clone(){throw new Exception("Imposible clonear en la clase: ".__CLASS__);}


    public static function mysql(){

        if(!isset(self::$instancia)){
			try {
				self::$instancia = new \mysqli($GLOBALS['db']['SERVIDOR'], $GLOBALS['db']['USUARIO'], $GLOBALS['db']['CLAVE'], $GLOBALS['db']['BASEDEDATOS']);  
				if(self::$instancia->connect_error) throw new Exception('No se pudo conectar a la base de datos');
			} catch(Exception $e) {
				self::mostrarError($e, !1);
			}
        }
        
        return self::$instancia;
    }


	/**
	* Método para establecer e invocar el recurso de una determinada consulta a Mysql.
	* @param string $query - Cadena de la consulta
	* @access public static
	* @return resource
	*/

	public static function _query($query) {

		try {
			if(!self::conexion()) self::$instancia = self::mysql();
			$sql = self::$instancia->query($query);
			if(!$sql) echo self::$instancia->error; //throw new Exception('Error en la consulta:'.self::$instancia->error);  
			
			return $sql;

		} catch(Exception $e) {
			self::mostrarError($e); 
		}

		return null;
	}


	/**
	* Método para mostrar los errores que arroja Mysql.
	* @param object  $o - Objecto donde está almacenada el mensaje del error.
	* @param boolean $i - booleano para mostrar el error completo (file and line).
	* @access private static
	* @return void
	*/

	private static function mostrarError($o, $i = true) {$msj = "MYSQL DICE: ".$o->getMessage(); if($i)echo($msj);else die($msj); }
	

	/**
	* Método para consultar el estado de la conexión a Mysql
	* @access public static
	* @return boolean
	*/
	
	public static function conexion() {
		return isset(self::$instancia);
	}

	//private function __destruct(){
	//  if(self::conexion() ) self::$instancia->close();
	//}
}

?>