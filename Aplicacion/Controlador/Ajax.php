<?php

class Ajax extends Nucleo\Includes\Controlador{

	public $obj = null;

	function __construct(){
		parent::__construct();
	}

	// Método que se llama por defecto
	public function index(){	

	}


	public function contentPdf($idcontent = null){

		if (isset($pagina)) $pagina = $pagina;
		else $pagina = 'pdfcontent';

		$content = $this->modelo('Mcontent');
		$content->setIdContent($idcontent);
		$result_content = $content->selectContentxId();

		$content_detail = $this->modelo('Mcontent_detail');
		$content_detail->setIdContent($idcontent);
		$array_result_content = $content_detail->SelectContentDetailxIdContent();
		
		$param = array('array_result_content' => $array_result_content);
		
		$inc = parent::vista(DIR_COMPONENTES.$pagina, $param, true);

		echo $inc;
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

}

