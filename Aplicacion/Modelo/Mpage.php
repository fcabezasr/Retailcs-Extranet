<?php

class Mpage {

	private $padre;
	private $db;

	private $pagina;
	private $servicio;

	function __construct($el){

		$this->padre = $el;
		$this->db = $this->padre->lib('DB');
		$this->session = $this->padre->lib('Session');
	}


	public function service(){

		$this->session->start();

		$pagina = $this->getPagina();
		$servicio = $this->getServicio();

		if (isset($_SESSION['Usuario'])) {
				
			$result = array(
				'Estado' => 1,
				'Contenido' => array(
					'Pagina' => $pagina,
					'Servicio' => $servicio
				)
 			);
	
			return $result;
		} else {

			$result = array( 
				'Estado' => 1,
				'Contenido' => array(
					'Pagina' => $pagina,
					'Servicio' => $servicio
				)
  			);

			return $result;
		}

	}


	/******************* VARIABLES *******************/

	public function setPagina($pagina = null){

		$this->pagina = $pagina;
	}

	public function getPagina(){

		return $this->pagina;
	}

	public function setServicio($servicio = null){

		$this->servicio = $servicio;
	}

	public function getServicio(){

		return $this->servicio;
	}

}