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

		// PAGINA: "Actualización" & "Corrección"
		if ($pagina == 'actualizacion' || $pagina == 'correccion') {
			$object_product = array();

			// PRODUCT -- Obtener el id del product
			$product = $this->modelo('Mproduct');
			$product->setIdProduct($servicio);
			$result_product = $product->selectProductxIdProduct();

			if ($result_product['result']['success']) {
				$r_product = $result_product['result']['product'];
				$object_product['ObjectProduct']['Product'] = $r_product;

				// CONTENT TYPE -- Obtener el id del Content Type
				$content_type = $this->modelo('Mcontent_type');
				$content_type->setContentDescription($pagina);
				$result_content_type = $content_type->selectContentTypexDescription();

				if ($result_content_type['result']['success']) {
					$r_content_type = $result_content_type['result']['object_content_type'];
					$object_product['ObjectProduct']['ContentType'] = $r_content_type;

					// VERSION PRODUCT -- Obtener los objects y id de las versiones asociados al product
					$version_product = $this->modelo('Mversion_product');
					$version_product->setIdProduct($r_product->idproduct);
					$version_product->setIdVersion($version);			
					
					//Aqui se realizará el cambio, construyendo un ARRAY VERSION x PRODUCT
					$array_result_version_product = $version_product->selectVersionProductxIdProductxIdVersion();

					if ($array_result_version_product['result']['success']) {
						
						$object_version = array();
						$object_version_total = array();
						foreach ($array_result_version_product['result']['arrayVersionProduct'] as $key_vp => $value_vp) {
							// VERSION -- Obtener un object de la version
							$version = $this->modelo('Mversion');
							$version->setIdVersion($value_vp->idversion);
							$result_version = $version->selectVersionxIdVersion();

							if ($result_version['result']['success']) {
								
								$object_version['Version'] = $result_version['result']['object_version'];
								
								if (isset($result_version['result']['object_version'])) {
									// CONTENT -- Obtener el id de content
									$content = $this->modelo('Mcontent');
									$content->setIdContentType($r_content_type->idcontent_type);
									$content->setIdProduct($r_product->idproduct);
									$content->setIdVersion($value_vp->idversion);
									$result_content = $content->selectContentxIdProductIdContentTypeIdVersion();
										
									if ($result_content['result']['success']) {
										$r_content = $result_content['result']['object_content'];
										$object_version['Content'] = $r_content;

										if (isset($r_content)) {
											// CONTENT DETAIL -- Obtener los objects y id de los content detail asociados al content
											$content_detail = $this->modelo('Mcontent_detail');
											$content_detail->setIdContent($r_content->idcontent);
											$array_result_content_detail = $content_detail->selectContentDetailxIdContent();
											
											if ($array_result_content_detail['result']['success']) {
												$object_version['ContentDetail'] = $array_result_content_detail['result']['array_content_detail'];
											}
											
										}else{
											$object_version['ContentDetail'] = null;
										}
									}
								}else{
									$object_version['Content'] = null;
									$object_version['ContentDetail'] = null;
								}

								array_push($object_version_total, $object_version);
							}
						}

						$object_product['ObjectProduct']['ObjectVersion'] = $object_version_total;
					}
				}
			}
		}

		// PAGINA: "Manual" & "Video"
		if ($pagina == 'manual' || $pagina == 'video') {
			$object_product = array();

			// PRODUCT -- Obtener el id del product
			$product = $this->modelo('Mproduct');
			$product->setIdProduct($servicio);
			$result_product = $product->selectProductxIdProduct();

			if ($result_product['result']['success']) {
				$r_product = $result_product['result']['product'];
    			$object_product['ObjectProduct']['Product'] = $r_product;

				// FILE TYPE -- Obtener el id del File Type
				$file_type = $this->modelo('Mfile_type');
				$file_type->setFileDescription($pagina);
				$result_file_type = $file_type->selectFileTypexDescription();

				if ($result_file_type['result']['success']) {
					$r_file_type = $result_file_type['result']['object_file_type'];
					$object_product['ObjectProduct']['FileType'] = $r_file_type;

					// VERSION PRODUCT -- Obtener los objects y id de las versiones asociados al product
					$version_product = $this->modelo('Mversion_product');
					$version_product->setIdProduct($r_product->idproduct);
					$version_product->setIdVersion($version);			
					//Aqui se realizará el cambio, construyendo un ARRAY VERSION x PRODUCT
					$array_result_version_product = $version_product->selectVersionProductxIdProductxIdVersion();

					if ($array_result_version_product['result']['success']) {						
						$object_version = array();
						$object_version_total = array();
						foreach ($array_result_version_product['result']['arrayVersionProduct'] as $key_vp => $value_vp) {
							// VERSION -- Obtener un object de la version
							$version = $this->modelo('Mversion');
							$version->setIdVersion($value_vp->idversion);
							$result_version = $version->selectVersionxIdVersion();

							if ($result_version['result']['success']) {
								$object_version['Version'] = $result_version['result']['object_version'];
								
								if (isset($result_version['result']['object_version'])) {
									// FILE -- Obtener el id de file
									$file = $this->modelo('Mfile');
									$file->setIdFileType($r_file_type->idfile_type);
									$file->setIdProduct($r_product->idproduct);
									$file->setIdVersion($value_vp->idversion);
									$result_file = $file->selectFilexIdProductIdContentTypeIdVersion();

									if ($result_file['result']['success']) {
										$object_version['File'] = $result_file['result']['array_file'];
									}									
								}else{
									$object_version['File'] = null;
								}
								
								array_push($object_version_total, $object_version);
							}
						}

						$object_product['ObjectProduct']['ObjectVersion'] = $object_version_total;			
					}
				}
			}
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
				switch ($seccion) {
					case 'nuevo':
						$business = $this->modelo('Mbusiness');
						$type_user = $this->modelo('Mtype_user');						
						
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
				switch ($seccion) {
					case 'nuevo':
						$param['tableProduct'] = $this->tableProduct();
						break;

					case 'version':
						$param['tableVersion'] = $this->tableVersion();
						break;

					case 'vinculo':
						$product = $this->modelo('Mproduct');
						$version = $this->modelo('Mversion');

						$listProduct = '';
						if(isset($product)) $product->listProduct(function($idproduct, $product_name) use(&$listProduct){
							$listProduct.= printList($idproduct, $product_name);
						});

						$listVersion = '';
						if(isset($version)) $version->listVersion(function($idversion, $version_description) use(&$listVersion){
							$listVersion.= printList($idversion, $version_description);
						});

						$param['listProduct'] = $listProduct;
						$param['listVersion'] = $listVersion;
						$param['tableVersionProduct'] = $this->tableVersionProduct();
						break;

					default:
						break;
				}

				break;

			case 'contenido':
				$product = $this->modelo('Mproduct');
				$listProduct = '';

				if(isset($product)) $product->listProduct(function($idproduct, $product_name) use(&$listProduct){
					$listProduct.= printList($idproduct, $product_name);
				});
				
				$param['listProduct'] = $listProduct;
				break;

			case 'archivo':
				$product = $this->modelo('Mproduct');
				$listProduct = '';

				if(isset($product)) $product->listProduct(function($idproduct, $product_name) use(&$listProduct){
					$listProduct.= printList($idproduct, $product_name);
				});
				
				$param['listProduct'] = $listProduct;
				break;

			case 'empresa':
				switch ($seccion) {
					case 'nuevo':
						$param['tableBusiness'] = $this->tableBusiness();
						break;

					default:
						break;
				}
				break;

			default:
				break;
		}

		echo $inc = parent::vista(DIR_COMPONENTES.$pagina, $param, true);
	}


	/********************          BUSINESS       ********************/

	public function insertBusiness(){
		
		if(!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest'){

			if (isset($_POST)) {
				$fechaActual = date('Y/m/d');
				$business = $this->modelo('Mbusiness');
				$business->setIdBusiness($_POST['business-id']);
				$business->setBusinessName(utf8_decode(addslashes($_POST['business-name'])));
				$business->setRuc(utf8_decode(addslashes($_POST['ruc'])));
				$business->setAddress(utf8_decode(addslashes($_POST['address'])));
				$business->setUpdateDate($fechaActual);
				$result = $business->insertBusiness();

				if ($result['result']['success']) {
					$result['result']['datatable'] = $this->tableBusiness();
				} else {
					$result['result']['datatable'] = '';
				}

				echo json_encode($result);

			}
		} else {
			throw new Exception("Error Processing Request", 1);   
		}
	}


	public function updateBusiness($idbusiness = null){

		$business = $this->modelo('Mbusiness');
		$business->setIdBusiness($idbusiness);
		$result = $business->updateBusiness();

		if ($result['result']['success']) {
			$result['result']['datatable'] = $this->tableBusiness();
		} else {
			$result['result']['datatable'] = '';
		}

		echo json_encode($result);
	}


	public function deleteBusiness($idbusiness = null){

		$business = $this->modelo('Mbusiness');
		$business->setIdBusiness($idbusiness);
		$result = $business->deleteBusiness();

		if ($result['result']['success']) {
			$result['result']['datatable'] = $this->tableBusiness();
		} else {
			$result['result']['datatable'] = '';
		}

		echo json_encode($result);
	}


	public function tableBusiness(){

		$business = $this->modelo('Mbusiness');
		$result = $business->selectBusiness();
		$arrayBusiness = array();

		if ($result['result']['success']) {
			foreach ($result['result']['arrayBusiness'] as $key => $businessData) {
				$data['idbusiness'] = $businessData->idbusiness;
				$data['business_name'] = $businessData->business_name;
				$data['ruc'] = $businessData->ruc;
				$data['address'] = $businessData->address;
				$data['registry_date'] = $businessData->registry_date;
				$data['state'] = $businessData->state;

				array_push($arrayBusiness, $data);
			}
		}

		return printTableBusiness($arrayBusiness);
	}


	/********************          USER       ********************/

	public function insertUser($iduser = null, $user_name = null, $password = null, $business_name = null, $type_user = null){
		
		$fechaActual = date('Y/m/d');
		$user = $this->modelo('Muser');
		$user->setIdUser($iduser);
		$user->setUserName($user_name);
		$user->setUserPass($password);
		$user->setUpdateDate($fechaActual);
		$user->setIdBusiness($business_name);
		$user->setIdTypeUser($type_user);
		$result = $user->insertUser();
		
		if ($result['result']['success']) {
			$result['result']['datatable'] = $this->tableUser();
		} else {
			$result['result']['datatable'] = '';
		}
		
		echo json_encode($result);
	}


	public function updateUser($iduser = null){

		$user = $this->modelo('Muser');
		$user->setIdUser($iduser);
		$result = $user->updateUser();

		if ($result['result']['success']) {
			$result['result']['datatable'] = $this->tableUser();
		} else {
			$result['result']['datatable'] = '';
		}

		echo json_encode($result);
	}


	public function deleteUser($iduser = null){

		$user = $this->modelo('Muser');
		$user->setIdUser($iduser);
		$result = $user->deleteUser();

		if ($result['result']['success']) {
			$result['result']['datatable'] = $this->tableUser();
		} else {
			$result['result']['datatable'] = '';
		}

		echo json_encode($result);
	}


	public function tableUser(){

		$user = $this->modelo('Muser');
		$type_user = $this->modelo('Mtype_user');
		$business = $this->modelo('Mbusiness');
		$result = $user->selectUser();
		$arrayUser = array();

		if ($result['result']['success']) {
			foreach ($result['result']['arrayUser'] as $key => $userData) {
				$data['iduser'] = $userData->iduser;
				$data['user_name'] = $userData->user_name;
				$data['registry_date'] = $userData->registry_date;
				$data['idtype_user'] = $userData->idtype_user;
				$data['type_user'] = '';
				$data['idbusiness'] = $userData->idbusiness;
				$data['business'] = '';
				$data['state'] = $userData->state;

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


	/********************        TYPE USER    ********************/

	public function insertTypeUser($idtype_user = null, $description_type = null){

		$fechaActual = date('Y/m/d');
		$type_user = $this->modelo('Mtype_user');
		$type_user->setIdTypeUser($idtype_user);
		$type_user->setDescription(urldecode($description_type));
		$type_user->setUpdateDate($fechaActual);
		$result = $type_user->insertTypeUser();

		if ($result['result']['success']) {
			$result['result']['datatable'] = $this->tableTypeUser();
		} else {
			$result['result']['datatable'] = '';
		}
				
		echo json_encode($result);
	}


	public function updateTypeUser($idtype_user = null){

		$type_user = $this->modelo('Mtype_user');
		$type_user->setIdTypeUser($idtype_user);
		$result = $type_user->updateTypeUser();

		if ($result['result']['success']) {
			$result['result']['datatable'] = $this->tableTypeUser();
		} else {
			$result['result']['datatable'] = '';
		}

		echo json_encode($result);
	}


	public function deleteTypeUser($idtype_user = null){

		$type_user = $this->modelo('Mtype_user');
		$type_user->setIdTypeUser($idtype_user);
		$result = $type_user->deleteTypeUser();

		if ($result['result']['success']) {
			$result['result']['datatable'] = $this->tableTypeUser();
		}

		echo json_encode($result);
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
				$data['state'] = $typeUserData->state;

				array_push($arrayTypeUser, $data);
			}
		}

		return printTableTypeUser($arrayTypeUser);
	}


	/********************         PRODUCT     ********************/

	public function tableProduct(){

		$m_product = $this->modelo('Mproduct');
		$result = $m_product->selectProduct();
		$arrayProduct = array();

		if ($result['result']['success']) {
			foreach ($result['result']['arrayProduct'] as $key => $productData) {
				$data['idproduct'] = $productData->idproduct;
				$data['product_name'] = $productData->product_name;
				$data['product_icono'] = $productData->product_icono;
				$data['product_order'] = $productData->product_order;
				$data['registry_date'] = $productData->registry_date;
				$data['state'] = $productData->state;

				array_push($arrayProduct, $data);
			}
		}

		return printTableProduct($arrayProduct);
	}


	/********************         VERSION     ********************/

	public function insertVersion($idversion = null, $version_description = null){

		$fechaActual = date('Y/m/d');
		$version = $this->modelo('Mversion');
		$version->setIdVersion($idversion);
		$version->setVersionDescription($version_description);
		$version->setUpdateDate($fechaActual);
		$result = $version->insertVersion();

		if ($result['result']['success']) {
			$result['result']['datatable'] = $this->tableVersion();
		} else {
			$result['result']['datatable'] = '';
		}
		
		echo json_encode($result);
	}


	public function updateVersion($idversion = null){

		$version = $this->modelo('Mversion');
		$version->setIdVersion($idversion);
		$result = $version->updateVersion();

		if ($result['result']['success']) {
			$result['result']['datatable'] = $this->tableVersion();
		} else {
			$result['result']['datatable'] = '';
		}

		echo json_encode($result);
	}


	public function deleteVersion($idversion = null){

		$version = $this->modelo('Mversion');
		$version->setIdVersion($idversion);
		$result = $version->deleteVersion();

		if ($result['result']['success']) {
			$result['result']['datatable'] = $this->tableVersion();
		} else {
			$result['result']['datatable'] = '';
		}

		echo json_encode($result);
	}


	public function tableVersion(){

		$m_version = $this->modelo('Mversion');
		$result = $m_version->selectVersion();
		$arrayVersion = array();

		if ($result['result']['success']) {
			foreach ($result['result']['arrayVersion'] as $key => $versionData) {
				$data['idversion'] = $versionData->idversion;
				$data['version_description'] = $versionData->version_description;
				$data['version_order'] = $versionData->version_order;
				$data['registry_date'] = $versionData->registry_date;
				$data['state'] = $versionData->state;
				
				array_push($arrayVersion, $data);
			}
		}

		return printTableVersion($arrayVersion);
	}


	/********************  PRODUCT & VERSION  ********************/

	public function insertVersionProduct(){

		if(!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest'){

			if (isset($_POST)) {
				$m_version_product = $this->modelo('Mversion_product');
				
				if ($_POST['idproduct_bck'] != '' && $_POST['idversion_bck'] != '') {
					// Verificamos si ambos valores son iguales, por ende solo es una ACTUALIZACIÓN
					if ($_POST['idproduct_bck'] == $_POST['idproduct_pv'] && $_POST['idversion_bck'] == $_POST['idversion_pv']) {
						// Enviamos los datos para Actualizar
						$m_version_product->setIdProduct($_POST['idproduct_pv']);
						$m_version_product->setIdVersion($_POST['idversion_pv']);
						$m_version_product->setRegistryDescription(utf8_decode(addslashes($_POST['registry-description'])));
						$m_version_product->setState(0);
						$result = $m_version_product->insertVersionProduct();

						if ($result['result']['success']) {
							$result['result']['datatable'] = $this->tableVersionProduct();
						} else {
							$result['result']['datatable'] = '';
						}
					} else {
						// Enviamos los datos iniciales para VERIFICAR si no están vinculados a otros registros.
						$m_version_product->setIdProduct($_POST['idproduct_bck']);
						$m_version_product->setIdVersion($_POST['idversion_bck']);
						$result = $m_version_product->deleteVersionProduct();

						if ($result['result']['success']) {
							// Enviamos los datos cambiados para VERIFICAR si ya EXISTEN
							$m_version_product->setIdProduct($_POST['idproduct_pv']);
							$m_version_product->setIdVersion($_POST['idversion_pv']);
							$m_version_product->setRegistryDescription(utf8_decode(addslashes($_POST['registry-description'])));
							$m_version_product->setState(1);
							$result = $m_version_product->insertVersionProduct();

							if ($result['result']['success']) {
								$result['result']['datatable'] = $this->tableVersionProduct();
							} else {
								$result['result']['datatable'] = '';
							}
						} else {
							$result['result']['message'] = '<strong>Alerta!</strong> La relación inicial de la Versión & Producto está vinculado a algún Contenido o Archivo, por ende no puede cambiarlo.';
							$result['result']['nameboton'] = 'Guardar';
						}
					}
				} else {
					$m_version_product->setIdProduct($_POST['idproduct_pv']);
					$m_version_product->setIdVersion($_POST['idversion_pv']);
					$m_version_product->setRegistryDescription(utf8_decode(addslashes($_POST['registry-description'])));
					$m_version_product->setState(1);
					$result = $m_version_product->insertVersionProduct();

					if ($result['result']['success']) {
						$result['result']['datatable'] = $this->tableVersionProduct();
					} else {
						$result['result']['datatable'] = '';
					}
				}

				echo json_encode($result);
			}
		} else {
			throw new Exception("Error Processing Request", 1);   
		}
	}


	public function updateVersionProduct($idproduct = null, $idversion = null){

		$m_version_product = $this->modelo('Mversion_product');
		$m_version_product->setIdProduct($idproduct);
		$m_version_product->setIdVersion($idversion);
		$result = $m_version_product->updateVersionProduct();

		if ($result['result']['success']) {
			$result['result']['datatable'] = $this->tableVersionProduct();
		} else {
			$result['result']['datatable'] = '';
		}

		echo json_encode($result);
	}


	public function deleteVersionProduct($idproduct = null, $idversion = null){

		$m_version_product = $this->modelo('Mversion_product');
		$m_version_product->setIdProduct($idproduct);
		$m_version_product->setIdVersion($idversion);
		$result = $m_version_product->deleteVersionProduct();

		if ($result['result']['success']) {
			$result['result']['datatable'] = $this->tableVersionProduct();
		} else {
			$result['result']['datatable'] = '';
		}

		echo json_encode($result);
	}


	public function tableVersionProduct(){

		$m_product = $this->modelo('Mproduct');
		$m_version = $this->modelo('Mversion');
		$m_version_product = $this->modelo('Mversion_product');
		$result = $m_version_product->selectVersionProduct();
		$arrayVersionProduct = array();

		if ($result['result']['success']) {
			foreach ($result['result']['array_version_product'] as $key => $versionProductData) {
				$data['idproduct'] = $versionProductData->idproduct;
				$data['idversion'] = $versionProductData->idversion;
				$data['registry_description'] = $versionProductData->registry_description;
				$data['registry_date'] = $versionProductData->registry_date;
				$data['state'] = $versionProductData->state;

				$m_product->setIdProduct($versionProductData->idproduct);
				$p_result = $m_product->selectProductxIdProduct();

				if ($p_result['result']['success']) {
					$data['product_name'] = $p_result['result']['product']->product_name;
				}

				$m_version->setIdVersion($versionProductData->idversion);
				$v_result = $m_version->selectVersionxIdVersion();
				
				if ($v_result['result']['success']) {
					$data['version_description'] = $v_result['result']['object_version']->version_description;
				}

				array_push($arrayVersionProduct, $data);
			}
		}

		return printTableVersionProduct($arrayVersionProduct);
	}

}