<?php

class Content extends Nucleo\Includes\Controlador{

	public $obj = null;

	function __construct(){
		parent::__construct();
	}

	// Método que se llama por defecto
	public function index(){	

	}


	public function insertContent($data_json = null){

		$data = json_decode(urldecode($data_json));

		$content = $this->modelo('Mcontent');
		$dateUpdate = date('Y-m-d');

		$content->setContentDescription(utf8_decode($data->idcontent_type.' '.$dateUpdate));
		$content->setPublicationDate($dateUpdate);
		$content->setUpdateDate($dateUpdate);
		$content->setIdContentType($data->idcontent_type);
		$content->setIdProduct($data->idproduct);
		$content->setIdVersion($data->idversion_product);

		$result = $content->insertContent();

		if ($result['result']['success']) {
			$content_detail = $this->modelo('Mcontent_detail');

			$content_detail->setDetailDescription(utf8_decode($data->detail_description));
			$content_detail->setRegistryDate($data->registry_date);
			$content_detail->setUpdateDate($dateUpdate);
			$content_detail->setIdContent($result['result']['id']);

			$result2 = $content_detail->insertContentDetail();

			if ($result2['result']['success']) {
				$result['result']['message2'] = $result2['result']['message'];
			} else {
				$result['result']['message2'] = $result2['result']['message'];
			}
		}

		echo json_encode($result);
	}

}
