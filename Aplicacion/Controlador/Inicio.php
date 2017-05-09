<?php

class Inicio extends Nucleo\Includes\Controlador{

	function __construct(){

		parent::__construct();
	}

	// Método que se llama por defecto
	public function index($name = null){

		$user = $this->modelo('Muser');
		$result = $user->validarSession();

		if ($result['result']['success']) {
			if (isset($name)) $name = $name;
			else $name = 'index';

			// Para obtener la INFO RECENT: $is_menu = false
			$is_menu = false;
			$info_recent = $this->menuProduct($is_menu);
			$params_index = array("user" => $result['result']['name'], "info_recent" => $info_recent);
			$inc = parent::vista(DIR_COMPONENTES.$name, $params_index, true);
			
			// Para obtener el MENU PRODUCT: $is_menu = true
			$is_menu = true;
			$menu_product = $this->menuProduct($is_menu);
			$params = array("page" => $inc, "menu_product" => $menu_product);

			// Activamos esta VIEW cuando está en PRODUCCIÓN
			parent::vista("contenedor", $params);

			// Activamos esta VIEW cuando está en CONSTRUCCIÓN
			//parent::vista("construction");
		} else {
			header('Location: ./login/');
		}
	}

	// Método de Prueba
	public function index2($name = null){

		$user = $this->modelo('Muser');
		$result = $user->validarSession();

		if ($result['result']['success']) {
			if (isset($name)) $name = $name;
			else $name = 'index';

			$inc = parent::vista(DIR_COMPONENTES.$name, '', true);
			$menu_product = $this->menuProduct();
			$params =  array("page" => $inc, "menu_product" => $menu_product);

			parent::vista("contenedor", $params);
		} else {
			header('Location: ./login/');
		}
	}

/*
	public function menuProduct(){

		$m_product = $this->modelo('Mproduct');
		$m_content = $this->modelo('Mcontent');
		$m_file = $this->modelo('Mfile');
		$m_content_type = $this->modelo('Mcontent_type');
		$m_content_detail = $this->modelo('Mcontent_detail');
		$m_file_type = $this->modelo('Mfile_type');
		$m_version = $this->modelo('Mversion');

		$p_result = $m_product->selectProductMenu();
		if ($p_result['result']['success']) {
			$array_product = $p_result['result']['array_product'];
			$array_menu = array();

			foreach ($array_product as $key => $product) {				
				$array_producto['Product']['Id'] = $product->idproduct;
				$array_producto['Product']['Name'] = $product->product_name;
				$array_producto['Product']['Icon'] = $product->product_icono;
				$array_producto['Product']['Order'] = $product->product_order;
				$array_producto['Product']['ArrayContentType'] = array();
				$array_producto['Product']['ArrayFileType'] = array();

				// Obtenemos un ARRAY de CONTENT - Where: idproduct
				$m_content->setIdProduct($product->idproduct);
				$c_result = $m_content->selectContentxIdProductMenu();

				if ($c_result['result']['success']) {
					$array_content = $c_result['result']['array_content'];
					$array_idcontent_type = array();

					foreach ($array_content as $key => $content) {
						// Obtenemos un array de "idcontent_type"
						array_push($array_idcontent_type, $content->idcontent_type);
					}

					// Obtenemos un array con valores UNIQUE
					$array_idcontent_type = array_unique($array_idcontent_type);
					$array_object_content_type = array();

					foreach ($array_idcontent_type as $key => $idcontent_type) {
						// Obtenemos un OBJECT de CONTENT_TYPE - Where: idcontent_type
						$m_content_type->setIdContentType($idcontent_type);
						$ct_result = $m_content_type->selectContentTypexIdContentTypeMenu();

						if ($ct_result['result']['success']) {
							$object_content_type = $ct_result['result']['object_content_type'];
							$array_content_type['ContentType']['Id'] = $object_content_type->idcontent_type;
							$array_content_type['ContentType']['Description'] = $object_content_type->content_description;
							$array_content_type['ContentType']['Short'] = $object_content_type->name_short;
							$array_content_type['ContentType']['ArrayVersion'] = array();

							// Obtenemos un ARRAY de CONTENT - Where: idproduct, idcontent_type
							$m_content->setIdProduct($product->idproduct);
							$m_content->setIdContentType($idcontent_type);
							$c_result2 = $m_content->selectContentxIdProductxIdContentTypeMenu();

							if ($c_result2['result']['success']) {
								$array_content2 = $c_result2['result']['array_content'];
								$array_idversion = array();

								foreach ($array_content2 as $key => $content) {
									// Obtenemos un array de "idversion"
									array_push($array_idversion, $content->idversion);
								}

								// Obtenemos un array con valores UNIQUE
								$array_idversion = array_unique($array_idversion);
								$array_object_version = array();

								foreach ($array_idversion as $key => $idversion) {
									// Obtenemos un OBJECT de VERSION - Where: idversion
									$m_version->setIdVersion($idversion);
									$v_result = $m_version->selectVersionxIdVersionMenu();

									if ($v_result['result']['success']) {
										$object_version = $v_result['result']['object_version'];
										$array_version['Version']['Id'] = $object_version->idversion;
										$array_version['Version']['Description'] = $object_version->version_description;
										$array_version['Version']['Order'] = $object_version->version_order;
										$array_version['Version']['Count'] = 0;

										// Obtenemos la cantidad de registros por IdProduct & IdVersion
										$m_content->setIdProduct($product->idproduct);
										$m_content->setIdContentType($idcontent_type);
										$m_content->setIdVersion($idversion);
										$r_object_content = $m_content->selectContentxIdProductIdContentTypeIdVersion();

										if ($r_object_content['result']['success']) {
											$o_content = $r_object_content['result']['object_content'];
											$m_content_detail->setIdContent($o_content->idcontent);
											$r_count_content = $m_content_detail->countContentDetailxIdContent();

											if ($r_count_content['result']['success']) {
												$array_version['Version']['Count'] = $r_count_content['result']['countContent'];
											}
										}
									}

									array_push($array_object_version, $array_version);
								}

								$array_content_type['ContentType']['ArrayVersion'] = $array_object_version;
							}							
						
							array_push($array_object_content_type, $array_content_type);
						}
					}

					$array_producto['Product']['ArrayContentType'] = $array_object_content_type;	
				}

				// Obtenemos un ARRAY de FILE - Where: idproduct
				$m_file->setIdProduct($product->idproduct);
				$f_result = $m_file->selectFilexIdProductMenu();

				if ($f_result['result']['success']) {
					$array_file = $f_result['result']['array_file'];
					$array_idfile_type = array();

					foreach ($array_file as $key => $file) {
						// Obtenemos un array de "idfile_type"
						array_push($array_idfile_type, $file->idfile_type);
					}

					// Obtenemos un array con valores UNIQUE
					$array_idfile_type = array_unique($array_idfile_type);
					$array_object_file_type = array();

					foreach ($array_idfile_type as $key => $idfile_type) {
						// Obtenemos un OBJECT de FILE_TYPE - Where: idfile_type
						$m_file_type->setIdFileType($idfile_type);
						$ft_result = $m_file_type->selectFileTypexIdFileTypeMenu();

						if ($ft_result['result']['success']) {
							$object_file_type = $ft_result['result']['object_file_type'];
							$array_file_type['FileType']['Id'] = $object_file_type->idfile_type;
							$array_file_type['FileType']['Description'] = $object_file_type->file_description;
							$array_file_type['FileType']['Short'] = $object_file_type->name_short;
							$array_file_type['FileType']['ArrayVersion'] = array();
							
							// Obtenemos un ARRAY de FILE - Where: idproduct, idfile_type
							$m_file->setIdProduct($product->idproduct);
							$m_file->setIdFileType($idfile_type);
							$f_result2 = $m_file->selectFilexIdProductxIdFileTypeMenu();

							if ($f_result2['result']['success']) {
								$array_file2 = $f_result2['result']['array_file'];
								$array_idversion = array();

								foreach ($array_file2 as $key => $file) {
									// Obtenemos un array de "idversion"
									array_push($array_idversion, $file->idversion);
								}

								// Obtenemos un array con valores UNIQUE
								$array_idversion = array_unique($array_idversion);
								$array_object_version = array();

								foreach ($array_idversion as $key => $idversion) {
									// Obtenemos un OBJECT de VERSION - Where: idversion
									$m_version->setIdVersion($idversion);
									$v_result = $m_version->selectVersionxIdVersionMenu();

									if ($v_result['result']['success']) {
										$object_version = $v_result['result']['object_version'];
										$array_version['Version']['Id'] = $object_version->idversion;
										$array_version['Version']['Description'] = $object_version->version_description;
										$array_version['Version']['Order'] = $object_version->version_order;
										$array_version['Version']['Count'] = 0;

										// Obtenemos la cantidad de registros por IdProduct & IdVersion
										$m_file->setIdProduct($product->idproduct);
										$m_file->setIdFileType($idfile_type);
										$m_file->setIdVersion($idversion);
										$r_count_file = $m_file->countFilexIdProductIdContentTypeIdVersion();

										if ($r_count_file['result']['success']) {
											$array_version['Version']['Count'] = $r_count_file['result']['countFile'];
										}
									}

									array_push($array_object_version, $array_version);
								}
								$array_file_type['FileType']['ArrayVersion'] = $array_object_version;
							}							
						
							array_push($array_object_file_type, $array_file_type);
						}
					}

					$array_producto['Product']['ArrayFileType'] = $array_object_file_type;	
				}

				array_push($array_menu, $array_producto);
			}
		} else {
			$array_menu = array();
		}

		return printMenuProduct($array_menu);
	}
*/

	public function menuProduct($is_menu){

		$m_product = $this->modelo('Mproduct');
		$m_content = $this->modelo('Mcontent');
		$m_file = $this->modelo('Mfile');
		$m_content_type = $this->modelo('Mcontent_type');
		$m_content_detail = $this->modelo('Mcontent_detail');
		$m_file_type = $this->modelo('Mfile_type');
		$m_version = $this->modelo('Mversion');

		$p_result = $m_product->selectProductMenu();
		if ($p_result['result']['success']) {

			// Obtenemos un ARRAY de todos los PRODUCT existentes con STATE = 1
			$array_product = $p_result['result']['array_product'];
			$array_menu = array();

			foreach ($array_product as $key => $product) {

				// Guardamos cada OBJECT Product en un nuevo ARRAY
				$array_producto['Product']['Id'] = $product->idproduct;
				$array_producto['Product']['Name'] = $product->product_name;
				$array_producto['Product']['Icon'] = $product->product_icono;
				$array_producto['Product']['Order'] = $product->product_order;
				$array_producto['Product']['ArrayContentType'] = array();
				$array_producto['Product']['ArrayFileType'] = array();

				// Obtenemos un ARRAY de CONTENT - Where: idproduct
				$m_content->setIdProduct($product->idproduct);
				$c_result = $m_content->selectContentxIdProductMenu();

				if ($c_result['result']['success']) {
					$array_content = $c_result['result']['array_content'];
					$array_idcontent_type = array();

					foreach ($array_content as $key => $content) {
						// Obtenemos un array de "idcontent_type"
						array_push($array_idcontent_type, $content->idcontent_type);
					}

					// Obtenemos un array con valores UNIQUE
					$array_idcontent_type = array_unique($array_idcontent_type);
					$array_object_content_type = array();

					foreach ($array_idcontent_type as $key => $idcontent_type) {

						// Obtenemos un OBJECT de CONTENT_TYPE - Where: idcontent_type
						$m_content_type->setIdContentType($idcontent_type);
						$ct_result = $m_content_type->selectContentTypexIdContentTypeMenu();

						if ($ct_result['result']['success']) {
							$object_content_type = $ct_result['result']['object_content_type'];
							$array_content_type['ContentType']['Id'] = $object_content_type->idcontent_type;
							$array_content_type['ContentType']['Description'] = $object_content_type->content_description;
							$array_content_type['ContentType']['Short'] = $object_content_type->name_short;
							$array_content_type['ContentType']['ArrayVersion'] = array();

							// Obtenemos un ARRAY de CONTENT - Where: idproduct, idcontent_type
							$m_content->setIdProduct($product->idproduct);
							$m_content->setIdContentType($idcontent_type);
							$c_result2 = $m_content->selectContentxIdProductxIdContentTypeMenu();

							if ($c_result2['result']['success']) {
								$array_content2 = $c_result2['result']['array_content'];
								$array_idversion = array();

								foreach ($array_content2 as $key => $content) {
									// Obtenemos un array de "idversion"
									array_push($array_idversion, $content->idversion);
								}

								// Obtenemos un array con valores UNIQUE de IdVersion
								$array_idversion = array_unique($array_idversion);
								$array_object_version = array();

								foreach ($array_idversion as $key => $idversion) {

									// Obtenemos un OBJECT de VERSION - Where: idversion
									$m_version->setIdVersion($idversion);
									$v_result = $m_version->selectVersionxIdVersionMenu();

									if ($v_result['result']['success']) {
										$object_version = $v_result['result']['object_version'];
										$array_version['Version']['Id'] = $object_version->idversion;
										$array_version['Version']['Description'] = $object_version->version_description;
										$array_version['Version']['Order'] = $object_version->version_order;
										$array_version['Version']['Count'] = 0;

										// Obtenemos un OBJECT CONTENT mediante el IdProduct, IdContentType, IdVersion
										$m_content->setIdProduct($product->idproduct);
										$m_content->setIdContentType($idcontent_type);
										$m_content->setIdVersion($idversion);
										$r_object_content = $m_content->selectContentxIdProductIdContentTypeIdVersion();

										if ($r_object_content['result']['success']) {
											$o_content = $r_object_content['result']['object_content'];

											// Obtenemos la cantidad de registros por IdContent en CONTENT DETAIL
											$m_content_detail->setIdContent($o_content->idcontent);

											// Valida si se requiere el MENU DE PRODUCT: true o INFO RECENT: false
											if ($is_menu == true) {
												$r_count_content = $m_content_detail->countContentDetailxIdContent();	
											} else {
												// INICIO - Fecha que me permitirá realizar una busqueda de CONTENT DETAIL recientes.
												$fechaActual = date('Y/m/d');
												$m_content_detail->setRegistryDate($fechaActual);
												$r_count_content = $m_content_detail->countContentDetailxIdContentxRegistryDate();
												// FIN
											}

											if ($r_count_content['result']['success']) {
												$array_version['Version']['Count'] = $r_count_content['result']['countContent'];
											}
										}
									}

									array_push($array_object_version, $array_version);
								}

								$array_content_type['ContentType']['ArrayVersion'] = $array_object_version;
							}							
						
							array_push($array_object_content_type, $array_content_type);
						}
					}

					$array_producto['Product']['ArrayContentType'] = $array_object_content_type;
				}

				// Obtenemos un ARRAY de FILE - Where: idproduct
				$m_file->setIdProduct($product->idproduct);
				$f_result = $m_file->selectFilexIdProductMenu();

				if ($f_result['result']['success']) {
					$array_file = $f_result['result']['array_file'];
					$array_idfile_type = array();

					foreach ($array_file as $key => $file) {
						// Obtenemos un array de "idfile_type"
						array_push($array_idfile_type, $file->idfile_type);
					}

					// Obtenemos un array con valores UNIQUE
					$array_idfile_type = array_unique($array_idfile_type);
					$array_object_file_type = array();

					foreach ($array_idfile_type as $key => $idfile_type) {
						// Obtenemos un OBJECT de FILE_TYPE - Where: idfile_type
						$m_file_type->setIdFileType($idfile_type);
						$ft_result = $m_file_type->selectFileTypexIdFileTypeMenu();

						if ($ft_result['result']['success']) {
							$object_file_type = $ft_result['result']['object_file_type'];
							$array_file_type['FileType']['Id'] = $object_file_type->idfile_type;
							$array_file_type['FileType']['Description'] = $object_file_type->file_description;
							$array_file_type['FileType']['Short'] = $object_file_type->name_short;
							$array_file_type['FileType']['ArrayVersion'] = array();
							
							// Obtenemos un ARRAY de FILE - Where: idproduct, idfile_type
							$m_file->setIdProduct($product->idproduct);
							$m_file->setIdFileType($idfile_type);
							$f_result2 = $m_file->selectFilexIdProductxIdFileTypeMenu();

							if ($f_result2['result']['success']) {
								$array_file2 = $f_result2['result']['array_file'];
								$array_idversion = array();

								foreach ($array_file2 as $key => $file) {
									// Obtenemos un array de "idversion"
									array_push($array_idversion, $file->idversion);
								}

								// Obtenemos un array con valores UNIQUE
								$array_idversion = array_unique($array_idversion);
								$array_object_version = array();

								foreach ($array_idversion as $key => $idversion) {
									// Obtenemos un OBJECT de VERSION - Where: idversion
									$m_version->setIdVersion($idversion);
									$v_result = $m_version->selectVersionxIdVersionMenu();

									if ($v_result['result']['success']) {
										$object_version = $v_result['result']['object_version'];
										$array_version['Version']['Id'] = $object_version->idversion;
										$array_version['Version']['Description'] = $object_version->version_description;
										$array_version['Version']['Order'] = $object_version->version_order;
										$array_version['Version']['Count'] = 0;

										// Obtenemos la cantidad de registros por IdProduct & IdVersion
										$m_file->setIdProduct($product->idproduct);
										$m_file->setIdFileType($idfile_type);
										$m_file->setIdVersion($idversion);
										
										// Valida si se requiere el MENU DE PRODUCT: true o INFO RECENT: false
										if ($is_menu == true) {
											$r_count_file = $m_file->countFilexIdProductIdContentTypeIdVersion();
										} else {
											// INICIO - Fecha que me permitirá realizar una busqueda de CONTENT DETAIL recientes.
											$fechaActual = date('Y/m/d');
											$m_file->setRegistryDate($fechaActual);
											$r_count_file = $m_file->countFilexIdProductIdContentTypeIdVersionxRegistryDate();
											// FIN
										}

										if ($r_count_file['result']['success']) {
											$array_version['Version']['Count'] = $r_count_file['result']['countFile'];
										}
									}

									array_push($array_object_version, $array_version);
								}
								$array_file_type['FileType']['ArrayVersion'] = $array_object_version;
							}							
						
							array_push($array_object_file_type, $array_file_type);
						}
					}

					$array_producto['Product']['ArrayFileType'] = $array_object_file_type;	
				}

				array_push($array_menu, $array_producto);
			}
		} else {
			$array_menu = array();
		}

		// Valida si se requiere el MENU DE PRODUCT: true o INFO RECENT: false
		if ($is_menu == true) {
			return printMenuProduct($array_menu);	
		} else {
			return printInformationRecent($array_menu);
		}
	}


	/********************         PRODUCT     ********************/

	public function insertProduct($product_id = null, $product_name = null, $product_icono = null){

		$fechaActual = date('Y/m/d');
		$product = $this->modelo('Mproduct');
		$product->setIdProduct($product_id);
		$product->setProductName(urldecode($product_name));
		$product->setProductIcono(urldecode($product_icono));
		$product->setUpdateDate($fechaActual);
		$result = $product->insertProduct();
		
		if ($result['result']['success']) {
			$result['result']['datatable'] = $this->tableProduct();
			$result['result']['menuproduct'] = $this->menuProduct();
		} else {
			$result['result']['datatable'] = '';
			$result['result']['menuproduct'] = '';
		}		

		echo json_encode($result);
	}


	public function updateProduct($idproduct = null){

		$product = $this->modelo('Mproduct');
		$product->setIdProduct($idproduct);
		$result = $product->updateProduct();

		if ($result['result']['success']) {
			$result['result']['datatable'] = $this->tableProduct();
			$result['result']['menuproduct'] = $this->menuProduct();
		} else {
			$result['result']['datatable'] = '';
			$result['result']['menuproduct'] = '';
		}

		echo json_encode($result);
	}


	public function deleteProduct($idproduct = null){

		$product = $this->modelo('Mproduct');
		$product->setIdProduct($idproduct);
		$result = $product->deleteProduct();

		if ($result['result']['success']) {
			$result['result']['datatable'] = $this->tableProduct();
			$result['result']['menuproduct'] = $this->menuProduct();
		} else {
			$result['result']['datatable'] = '';
			$result['result']['menuproduct'] = '';
		}

		echo json_encode($result);
	}


	public function tableProduct(){

		$m_product = $this->modelo('Mproduct');
		$result = $m_product->selectProduct();

		if ($result['result']['success']) {
			$arrayProduct = array();

			foreach ($result['result']['arrayProduct'] as $key => $productData) {
				$data['idproduct'] = $productData->idproduct;
				$data['product_name'] = $productData->product_name;
				$data['product_icono'] = $productData->product_icono;
				$data['product_order'] = $productData->product_order;
				$data['registry_date'] = $productData->registry_date;
				
				if ($productData->state) {
					$data['state'] = 'Habilitado';
				} else {
					$data['state'] = 'Deshabilitado';
				}

				array_push($arrayProduct, $data);
			}
		}

		return printTableProduct($arrayProduct);
	}

}