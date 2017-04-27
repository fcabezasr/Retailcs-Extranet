<?php

class Page extends Nucleo\Includes\Controlador {

	function __construct(){

		parent::__construct();
	}


	// Método que se llama por defecto
	public function index($name = null){

		if (isset($name)) $name = $name;
		else $name = 'page';

		parent::vista(DIR_COMPONENTES.$name, '');
	}


	public function service($pagina = null, $servicio = null, $version = null){

		if (isset($pagina)) $pagina = $pagina;
		else $pagina = 'actualizacion';

		if ($pagina == 'actualizacion' || $pagina == 'correccion') {
			$object_product = array();

			// PRODUCT -- Obtener el id del product
			$product = $this->modelo('Mproduct');
			$product->setProductName($servicio);
			$result_product = $product->selectProductxName();
			$object_product['ObjectProduct']['Product'] = $result_product;

			// CONTENT TYPE -- Obtener el id del Content Type
			$content_type = $this->modelo('Mcontent_type');
			$content_type->setContentDescription($pagina);
			$result_content_type = $content_type->selectContentTypexDescription();
			$object_product['ObjectProduct']['ContentType'] = $result_content_type;

			// VERSION PRODUCT -- Obtener los objects y id de las versiones asociados al product
			$version_product = $this->modelo('Mversion_product');
			$version_product->setIdProduct($result_product->idproduct);
			$version_product->setIdVersion($version);			
			/*Aqui se realizará el cambio, construyendo un ARRAY VERSION x PRODUCT*/
			$array_result_version_product = $version_product->selectVersionProductxIdProductxIdVersion();

			$object_version = array();
			$object_version_total = array();
			foreach ($array_result_version_product as $key_vp => $value_vp) {
				// VERSION -- Obtener un object de la version
				$version = $this->modelo('Mversion');
				$version->setIdVersion($value_vp->idversion);
				$result_version = $version->selectVersionxIdProduct();
				$object_version['Version'] = $result_version;
				
				if (isset($result_version)) {
					// CONTENT -- Obtener el id de content
					$content = $this->modelo('Mcontent');
					$content->setIdContentType($result_content_type->idcontent_type);
					$content->setIdProduct($result_product->idproduct);
					$content->setIdVersion($value_vp->idversion);
					$result_content = $content->selectContentxIdProductIdContentTypeIdVersion();
					$object_version['Content'] = $result_content;

					if (isset($result_content)) {
						// CONTENT DETAIL -- Obtener los objects y id de los content detail asociados al content
						$content_detail = $this->modelo('Mcontent_detail');
						$content_detail->setIdContent($result_content->idcontent);
						$array_result_content_detail = $content_detail->selectContentDetailxIdContent();
						$object_version['ContentDetail'] = $array_result_content_detail;
					}else{
						$object_version['ContentDetail'] = null;
					}
				}else{
					$object_version['Content'] = null;
					$object_version['ContentDetail'] = null;
				}

				array_push($object_version_total, $object_version);
			}

			$object_product['ObjectProduct']['ObjectVersion'] = $object_version_total;
		}

		if ($pagina == 'manual' || $pagina == 'video') {
			$object_product = array();

			// PRODUCT -- Obtener el id del product
			$product = $this->modelo('Mproduct');
			$product->setProductName($servicio);
			$result_product = $product->selectProductxName();
			$object_product['ObjectProduct']['Product'] = $result_product;

			// FILE TYPE -- Obtener el id del File Type
			$file_type = $this->modelo('Mfile_type');
			$file_type->setFileDescription($pagina);
			$result_file_type = $file_type->selectFileTypexDescription();
			$object_product['ObjectProduct']['FileType'] = $result_file_type;

			// VERSION PRODUCT -- Obtener los objects y id de las versiones asociados al product
			$version_product = $this->modelo('Mversion_product');
			$version_product->setIdProduct($result_product->idproduct);
			$version_product->setIdVersion($version);			
			/*Aqui se realizará el cambio, construyendo un ARRAY VERSION x PRODUCT*/
			$array_result_version_product = $version_product->selectVersionProductxIdProductxIdVersion();

			$object_version = array();
			$object_version_total = array();
			foreach ($array_result_version_product as $key_vp => $value_vp) {
				// VERSION -- Obtener un object de la version
				$version = $this->modelo('Mversion');
				$version->setIdVersion($value_vp->idversion);
				$result_version = $version->selectVersionxIdProduct();
				$object_version['Version'] = $result_version;
				
				if (isset($result_version)) {
					// FILE -- Obtener el id de file
					$file = $this->modelo('Mfile');
					$file->setIdFileType($result_file_type->idfile_type);
					$file->setIdProduct($result_product->idproduct);
					$file->setIdVersion($value_vp->idversion);
					$result_file = $file->selectFilexIdProductIdContentTypeIdVersion();
					$object_version['File'] = $result_file;
				}else{
					$object_version['File'] = null;
				}
				
				array_push($object_version_total, $object_version);
			}

			$object_product['ObjectProduct']['ObjectVersion'] = $object_version_total;			
		}

		$param = array("pagina" => $pagina, "servicio" => $servicio, "object_product" => $object_product);

		if (isset($param['object_product'])) {
			echo $inc = parent::vista(DIR_COMPONENTES.$pagina, $param, true);
		} else {
			echo "Ha finalizado su sessión...";
		}
	}


	public function management($pagina = null, $seccion = null){

		if (isset($pagina)) $pagina = $pagina;
		else $pagina = 'usuario';

		$fechaActual = date('Y-m-d');
		$param = array('pagina' => $pagina, 'seccion' => $seccion, 'fechaActual' => $fechaActual);

		switch ($pagina) {
			case 'usuario':
				$business = $this->modelo('Mbusiness');
				$type_user = $this->modelo('Mtype_user');

				switch ($seccion) {
					case 'nuevo':
						$listBusiness = '';
						if(isset($business)) $business->listBusiness(function($idbusiness, $business_name) use(&$listBusiness){
							$listBusiness.= printList($idbusiness, $business_name);
						});
						
						$listTypeUser = '';
						if(isset($type_user)) $type_user->listTypeUser(function($idtype_user, $description) use(&$listTypeUser){
							$listTypeUser.= printList($idtype_user, $description);
						});

						$param['listBusiness'] = $listBusiness;
						$param['listTypeUser'] = $listTypeUser;
						$param['tableUser'] = $this->tableUser();
						break;
					
					case 'tipo':
						$param['tableTypeUser'] = $this->tableTypeUser();
						break;

					default:
						break;
				}
				break;
			
			case 'producto':
				$product = $this->modelo('Mproduct');
				$listProduct = '';

				if(isset($product)) $product->listProduct(function($idproduct, $product_name) use(&$listProduct){
				$listProduct.= printList($idproduct, $product_name);
				});
				
				$param['listProduct'] = $listProduct;
				break;

			case 'contenido':
				$product = $this->modelo('Mproduct');
				$listProduct = '';

				if(isset($product)) $product->listProduct(function($idproduct, $product_name) use(&$listProduct){
				$listProduct.= printList($idproduct, $product_name);
				});
				
				$param['listProduct'] = $listProduct;
				break;

			case 'empresa':

				break;

			default:
				break;
		}

		echo $inc = parent::vista(DIR_COMPONENTES.$pagina, $param, true);
	}


	public function tableUser(){

		$user = $this->modelo('Muser');
		$type_user = $this->modelo('Mtype_user');
		$business = $this->modelo('Mbusiness');
		$result = $user->selectUser();

		if ($result['result']['success']) {

			$arrayUser = array();
			foreach ($result['result']['arrayUser'] as $key => $userData) {

				$data['iduser'] = $userData->iduser;
				$data['user_name'] = $userData->user_name;
				$data['registry_date'] = $userData->registry_date;
				$data['idtype_user'] = $userData->idtype_user;
				$data['type_user'] = '';
				$data['idbusiness'] = $userData->idbusiness;
				$data['business'] = '';
				
				if ($userData->state) {
					$data['state'] = 'Habilitado';
				} else {
					$data['state'] = 'Deshabilitado';
				}

				$type_user->setIdTypeUser($userData->idtype_user);
				$array_typeUser = $type_user->selectTypeUserxId();
				if ($array_typeUser['result']['success']) {
					$objTypeUser = $array_typeUser['result']['type_user'];
					$data['idtype_user'] = $objTypeUser->idtype_user;
					$data['type_user'] = $objTypeUser->description;
				}

				$business->setIdBusiness($userData->idbusiness);
				$array_business = $business->selectBusinessxId();
				if ($array_business['result']['success']) {
					$objBusiness = $array_business['result']['business'];
					$data['idbusiness'] = $objBusiness->idbusiness;
					$data['business'] = $objBusiness->business_name;
				}

				array_push($arrayUser, $data);
			}
		}

		return printTableUser($arrayUser);
	}


	public function tableTypeUser(){

		$type_user = $this->modelo('Mtype_user');

		$result = $type_user->selectTypeUser();
		if ($result['result']['success']) {

			$arrayTypeUser = array();
			foreach ($result['result']['arrayTypeUser'] as $key => $typeUserData) {

				$data['idtype_user'] = $typeUserData->idtype_user;
				$data['description'] = $typeUserData->description;
				$data['registry_date'] = $typeUserData->registry_date;
				
				if ($typeUserData->state) {
					$data['state'] = 'Habilitado';
				} else {
					$data['state'] = 'Deshabilitado';
				}

				array_push($arrayTypeUser, $data);
			}
		}

		return printTableTypeUser($arrayTypeUser);
	}

}