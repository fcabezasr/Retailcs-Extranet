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


	public function insertProduct($product_name = null){

		$product = $this->modelo('Mproduct');
		$product->setProductName(urldecode($product_name));		
		$result = $product->insertProduct();
		
		echo json_encode($result);
	}


	public function insertVersion($idproduct = null, $version_description = null, $registry_description = null){

		$version = $this->modelo('Mversion');
		$version->setVersionDescription($version_description);		
		$result = $version->insertVersion();

		if ($result['result']['id'] > 0) {
			
			$version_product = $this->modelo('Mversion_product');

			$version_product->setIdProduct($idproduct);
			$version_product->setIdVersion($result['result']['id']);
			$version_product->setRegistryDescription(urldecode($registry_description));
			$result2 = $version_product->insertVersionProduct();

			if ($result2['result']['success']) {
				$result['result']['message2'] = $result2['result']['message'];
			} else {
				$result['result']['message2'] = $result2['result']['message'];
			}
		}
		
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

}

