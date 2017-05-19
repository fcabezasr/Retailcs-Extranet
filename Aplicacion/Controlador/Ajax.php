<?php

class Ajax extends Nucleo\Includes\Controlador{

	public $obj = null;

	function __construct(){
		
		parent::__construct();
	}

	// Método que se llama por defecto
	public function index(){	

	}


	public function contentPdf($idcontent = null, $description = null, $product = null, $version = null){

		$result = array(
			'result' => array(
				'success' => 1, 
				'message' => 'Generación de PDF', 
				'idcontent' => $idcontent,
				'description' => $description,
				'product' => $product,
				'version' => $version
			)
		);

		echo json_encode($result);
	}


	public function listVersion($idproduct = null){

		$version_product = $this->modelo('Mversion_product');
		$version_product->setIdProduct($idproduct);
		$listVersion = $version_product->selectVersionProductxIdProduct();
		$option_version = '<option value="">-- Seleccione --</option>';

		if ($listVersion['result']['success']) {
			
			foreach ($listVersion['result']['arrayVersionProduct'] as $key => $array_version_product) {
				$mversion = $this->modelo('Mversion');
				$mversion->setIdVersion($array_version_product->idversion);
				$result_version = $mversion->selectVersionxIdVersion();

				if ($result_version['result']['success']) {
					$r_version = $result_version['result']['object_version'];
					$option_version = $option_version.printList($r_version->idversion, $r_version->version_description);
				}				
			}
		}

		echo $option_version;
	}


	public function validateProduct($product_name = null){

		$m_product = $this->modelo('Mproduct');
		$m_product->setProductName($product_name);
		$result = $m_product->validateProduct();

		echo json_encode($result);
	}


	public function validateVersion($version_description = null){

		$m_version = $this->modelo('Mversion');
		$m_version->setVersionDescription($version_description);
		$result = $m_version->validateVersion();

		echo json_encode($result);
	}

	public function validateBusiness($business_name = null){

		$m_business = $this->modelo('Mbusiness');
		$m_business->setBusinessName($business_name);
		$result = $m_business->validateBusiness();

		echo json_encode($result);
	}

}