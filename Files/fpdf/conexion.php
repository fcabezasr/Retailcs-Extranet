<?php

	class Conexion {

		function Conectarse(){

			// Conectarse a y seleccionar una base de datos de MySQL
			$link = new mysqli('localhost', '', '', '');

			// ¡Oh, no! Existe un error 'connect_errno', fallando así el intento de conexión
			if ($link->connect_errno) {
			    // La conexión falló. ¿Que vamos a hacer?
			    echo "Lo sentimos, este sitio web está experimentando problemas.";
			    // Podría ser conveniente mostrar algo interesante, aunque nosotros simplemente saldremos
			    exit;
			}

			return $link;
		}

		function Desconectarse($link){
			
			return $link->close();
		}
		
	}