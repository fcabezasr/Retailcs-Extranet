<?php

class Content extends Nucleo\Includes\Controlador{

	public $obj = null;

	function __construct(){
		
		parent::__construct();
	}


	// Método que se llama por defecto
	public function index(){	

	}


	public function insertContent(){

		if(!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest'){

			if (isset($_POST)) {
				$content = $this->modelo('Mcontent');
				$dateUpdate = date('Y-m-d');
				$content->setContentDescription(utf8_decode(addslashes($_POST['idcontent-type'].' '.$dateUpdate)));
				$content->setPublicationDate($dateUpdate);
				$content->setUpdateDate($dateUpdate);
				$content->setIdContentType($_POST['idcontent-type']);
				$content->setIdProduct($_POST['idproduct']);
				$content->setIdVersion($_POST['idversion-product']);
				$result = $content->insertContent();

				if ($result['result']['success']) {
					$content_detail = $this->modelo('Mcontent_detail');
					$content_detail->setDetailDescription(utf8_decode(addslashes($_POST['detail-description'])));
					$content_detail->setDetailDescriptionEn(utf8_decode(addslashes($_POST['detail-description-en'])));
					$content_detail->setRegistryDate($_POST['registry-date']);
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
		} else {
			throw new Exception("Error Processing Request", 1);   
		}
	}

}