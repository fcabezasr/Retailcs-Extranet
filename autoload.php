<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

class Autoloader
{
    public static function Ejecutar() {
        return spl_autoload_register(array('Autoloader', 'Carga'));
    }

    public static function Carga($nombreClase) {
	
		$archivo = str_replace('\\','/',$nombreClase).".php";
		//echo $archivo."<br />";
		if(file_exists($archivo)) {require $archivo;}
    }
}

Autoloader::Ejecutar();