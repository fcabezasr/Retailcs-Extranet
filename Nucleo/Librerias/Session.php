<?php
namespace Nucleo\Librerias;

class Session  {

    private static $instancia;


    function __construct(){ }


    public static function i(){

        if(!isset(self::$instancia)){
				self::$instancia = self::Session(); 
        }
        return self::$instancia;  
    }

 	public static function start(){
		if (session_id() == false){
			session_start();			//Inicia la Session
			session_regenerate_id();	//Regenera un Id reciente de la Session
			session_id();				//Genera un Id a la Session
		}
	}

	public static function destroy(){
		if (session_id() == true){
			session_unset();	//Libera las variables de Session
			session_destroy();	//Destruye la Session
		}
	}

	public static function dump(){
		if (session_id() == true){
			echo '<pre>';
			print_r($_SESSION);
			echo '</pre>';
		}
	}



    /******************* VARIABLES *******************/

}

?>