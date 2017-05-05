<?php

	function _isset(&$v ){return isset($v) ? $v : NULL;}


	function token($token){return md5($token);}


	function utf8($texto){return trim(utf8_encode($texto)); }


	function limpiar($var){
		$var = htmlspecialchars(trim(addslashes(stripslashes($var))), ENT_QUOTES, 'ISO-8859-1' );
		$var = str_replace(chr(160),'',$var);

		return $var;
	}


	function isDominio($d) {
	    if(!preg_match("/^([-a-z0-9]{2,100})\.([a-z\.]{2,8})$/i", $d)) {
		    return false;
	    }
	
	    return $d;
	}


	function not_html_script($text){
	   $text = preg_replace('#<script(.*?)>(.*?)</script>#is', '', $text);

	   $ps1 = strpos($text, '>');
	   $ps2 = strpos($text, '<');
	   if ($ps1 !== false or $ps2 !== false) {
	     $text = '';
	   }

	   $text = strip_tags($text, '<b><strong>');
	   $text = str_replace("alert(document.cookie)","",$text);
	   $text = str_replace('alert("document.cookie")','',$text);
	   $text = str_replace("document.cookie","",$text);

	   return($text);
	}


	function formatDate($date){

		return implode('-', array_reverse(explode('-', $date)));
	}


	function formatDayDate($date){

		$days = array('Mon' => 'Lunes', 'Tue' => 'Martes', 'Wed' => 'Miércoles', 'Thu' => 'Jueves', 'Fri' => 'Viernes', 'Sat' => 'Sábado', 'Sun' => 'Domingo');
		$months = array('01' => 'Enero', '02' => 'Febrero', '03' => 'Marzo', '04' => 'Abril', '05' => 'Mayo', '06' => 'Junio', '07' => 'Julio', '08' => 'Agosto', '09' => 'Septiembre', '10' => 'Octubre', '11' => 'Noviembre', '12' => 'Diciembre');
		$array_date = explode('-', $date);
		$date = date_create($date);
		$day = $days[date_format($date,"D")];
		
		return $day.' '.$array_date[2].', '.$months[$array_date[1]].' de '.$array_date[0];
	}


	function printList($id, $name){

		return '<option value="'.$id.'">'.strtoupper($name).'</option>';
	}


	function printTableUser($arrayUser){

		$tbody = '';
		foreach ($arrayUser as $key => $user) {
			$tbody.= 
			'<tr>
				<td class="td-center">'.($key+1).'</td>
				<td class="td-center">'.$user['user_name'].'</td>
				<td class="td-center">'.$user['type_user'].'</td>
				<td class="td-center">'.$user['business'].'</td>
				<td class="td-center">'.$user['registry_date'].'</td>
				<td class="td-center">'.$user['state'].'</td>
				<td class="td-center">
					<button class="btn btn-xs btn-info btn-user-edit" iduser="'.$user['iduser'].'" type="button"><i class="fa fa-pencil"></i> Editar </button>
					<button class="btn btn-xs btn-danger btn-user-remove" iduser="'.$user['iduser'].'" type="button"><i class="fa fa-trash-o"></i> Eliminar </button>
				</td>
			</tr>';
		}

		$tableUser = 
		'<table id="table-user" class="table table-striped table-bordered" cellspacing="0" width="100%">
			<thead>
				<tr>
					<th>N°</th>
					<th>Usuario</th>
					<th>Tipo</th>
					<th>Empresa</th>
					<th>Fecha Registro</th>
					<th>Estado</th>
					<th>Acciones</th>
				</tr>
			</thead>
			<tbody>'.$tbody.'</tbody>
		</table>
		<script>
			$(document).ready(function() { 
				$("#table-user").DataTable();
			});
		</script>';

		return $tableUser;
	}


	function printTableTypeUser($arrayTypeUser){

		$tbody = '';
		foreach ($arrayTypeUser as $key => $typeUser) {
			$tbody.= 
			'<tr>
				<td class="td-center">'.($key+1).'</td>
				<td class="td-center">'.$typeUser['description'].'</td>
				<td class="td-center">'.$typeUser['registry_date'].'</td>
				<td class="td-center">'.$typeUser['state'].'</td>
				<td class="td-center">
					<button class="btn btn-xs btn-info btn-user-type-edit" idtypeuser="'.$typeUser['idtype_user'].'" type="button"><i class="fa fa-pencil"></i> Editar </button>
					<button class="btn btn-xs btn-danger btn-user-type-remove" idtypeuser="'.$typeUser['idtype_user'].'" type="button"><i class="fa fa-trash-o"></i> Eliminar </button>			
				</td>
			</tr>';
		}

		$tableTypeUser = 
		'<table id="table-type-user" class="table table-striped table-bordered" cellspacing="0" width="100%">
			<thead>
				<tr>
					<th>N°</th>
					<th>Descripción</th>
					<th>Fecha Registro</th>
					<th>Estado</th>
					<th>Acciones</th>
				</tr>
			</thead>
			<tbody>'.$tbody.'</tbody>
		</table>
		<script>
			$(document).ready(function() {
				$("#table-type-user").DataTable();
			});
		</script>';

		return $tableTypeUser;
	}


	function printTableProduct($arrayProduct){

		$tbody = '';
		foreach ($arrayProduct as $key => $product) {
			$tbody.= 
			'<tr>
				<td class="td-center">'.($key+1).'</td>
				<td class="td-center"><label><i class="fa '.$product['product_icono'].' fa-icono"></i></label></td>
				<td class="td-center">'.strtoupper($product['product_name']).'</td>
				<td class="td-center">'.$product['registry_date'].'</td>
				<td class="td-center">'.$product['state'].'</td>
				<td class="td-center">
					<button class="btn btn-xs btn-info btn-product-edit" idproduct="'.$product['idproduct'].'" type="button"><i class="fa fa-pencil"></i> Editar </button>
					<button class="btn btn-xs btn-danger btn-product-remove" idproduct="'.$product['idproduct'].'" type="button"><i class="fa fa-trash-o"></i> Eliminar </button>			
				</td>
			</tr>';
		}

		$tableProduct = 
		'<table id="table-product" class="table table-striped table-bordered" cellspacing="0" width="100%">
			<thead>
				<tr>
					<th>N°</th>
					<th>Icono</th>
					<th>Nombre</th>
					<th>Fecha Registro</th>
					<th>Estado</th>
					<th>Acciones</th>
				</tr>
			</thead>
			<tbody>'.$tbody.'</tbody>
		</table>
		<script>
			$(document).ready(function() {
				$("#table-product").DataTable();
			});
		</script>';

		return $tableProduct;
	}


	function printTableVersion($arrayVersion){

		$tbody = '';
		foreach ($arrayVersion as $key => $version) {
			$tbody.= 
			'<tr>
				<td class="td-center">'.($key+1).'</td>
				<td class="td-center">'.strtoupper($version['version_description']).'</td>
				<td class="td-center">'.$version['registry_date'].'</td>
				<td class="td-center">'.$version['state'].'</td>
				<td class="td-center">
					<button class="btn btn-xs btn-info btn-version-edit" idversion="'.$version['idversion'].'" type="button"><i class="fa fa-pencil"></i> Editar </button>
					<button class="btn btn-xs btn-danger btn-version-remove" idversion="'.$version['idversion'].'" type="button"><i class="fa fa-trash-o"></i> Eliminar </button>
				</td>
			</tr>';
		}

		$tableVersion = 
		'<table id="table-version" class="table table-striped table-bordered" cellspacing="0" width="100%">
			<thead>
				<tr>
					<th>N°</th>
					<th>Versión</th>
					<th>Fecha Registro</th>
					<th>Estado</th>
					<th>Acciones</th>
				</tr>
			</thead>
			<tbody>'.$tbody.'</tbody>
		</table>
		<script>
			$(document).ready(function() {
				$("#table-version").DataTable();
			});
		</script>';

		return $tableVersion;
	}


	function printTableVersionProduct($arrayVersionProduct){

		$tbody = '';
		foreach ($arrayVersionProduct as $key => $version_product) {
			$tbody.= 
			'<tr>
				<td class="td-center">'.($key+1).'</td>
				<td class="td-center">'.strtoupper($version_product['product_name']).'</td>
				<td class="td-center">'.strtoupper($version_product['version_description']).'</td>
				<td class="td-center">'.$version_product['registry_date'].'</td>
				<td class="td-center">'.$version_product['state'].'</td>
				<td class="td-center">
					<!--<button class="btn btn-xs btn-info btn-version-product-edit" idproduct="'.$version_product['idproduct'].'" idversion="'.$version_product['idversion'].'" type="button"><i class="fa fa-pencil"></i> Editar </button>-->
					<button class="btn btn-xs btn-danger btn-version-product-remove" idproduct="'.$version_product['idproduct'].'" idversion="'.$version_product['idversion'].'" type="button"><i class="fa fa-trash-o"></i> Eliminar </button>
				</td>
			</tr>';
		}

		$tableVersionProduct = 
		'<table id="table-version-product" class="table table-striped table-bordered" cellspacing="0" width="100%">
			<thead>
				<tr>
					<th>N°</th>
					<th>Producto</th>
					<th>Versión</th>
					<th>Fecha Registro</th>
					<th>Estado</th>
					<th>Acciones</th>
				</tr>
			</thead>
			<tbody>'.$tbody.'</tbody>
		</table>
		<script>
			$(document).ready(function() {
				$("#table-version-product").DataTable();
			});
		</script>';

		return $tableVersionProduct;
	}


	function printMenuProduct($array_menu){

		$menuProduct = '';

		if (count($array_menu) > 0) {

			foreach ($array_menu as $key => $array_product) {
				$Product = $array_product['Product'];
				$menuProduct.= '<li class="'.(($key==0)?'active':'').'"><a><i class="fa '.$Product['Icon'].'"></i> '.$Product['Name'].' <span class="fa fa-chevron-down"></span></a><ul class="nav child_menu menu-sup" ser="'.$Product['Id'].'" order="'.$Product['Order'].'" '.(($key==0)?'style="display: block;"':'').'>';

				if (count($Product['ArrayContentType']) > 0) {
					foreach ($Product['ArrayContentType'] as $key => $array_content_type) {
						$ContentType = $array_content_type['ContentType'];
						$menuProduct.= '<li><a href="javascript:void(0)" class="sub_menu">'.$ContentType['Description'].'<span class="fa fa-chevron-down"></span></a><ul class="nav child_menu menu-inf" page="'.$ContentType['Short'].'" id="'.$ContentType['Id'].'">';

						if (count($ContentType['ArrayVersion']) > 0) {
							foreach ($ContentType['ArrayVersion'] as $key => $array_version) {
								$Version = $array_version['Version'];
								$menuProduct.= '<li><a href="javascript:void(0)" class="net-servicio" ver="'.$Version['Id'].'" order="'.$Version['Order'].'"> Versión '.$Version['Description'].' <span class="badge badge-success">'.$Version['Count'].'</span> </a></li>';
							}
						}

						$menuProduct.= '</ul></li>';
					}
				}

				if (count($Product['ArrayFileType']) > 0) {

					foreach ($Product['ArrayFileType'] as $key => $array_file_type) {
						$FileType = $array_file_type['FileType'];
						$menuProduct.= '<li><a href="javascript:void(0)" class="sub_menu">'.$FileType['Description'].'<span class="fa fa-chevron-down"></span></a><ul class="nav child_menu menu-inf" page="'.$FileType['Short'].'" id="'.$FileType['Id'].'">';

							if (count($FileType['ArrayVersion']) > 0) {
								foreach ($FileType['ArrayVersion'] as $key => $array_version) {
									$Version = $array_version['Version'];
									$menuProduct.= '<li><a href="javascript:void(0)" class="net-servicio" ver="'.$Version['Id'].'" order="'.$Version['Order'].'"> Versión '.$Version['Description'].' <span class="badge badge-success">'.$Version['Count'].'</span> </a></li>';
								}
							}

						$menuProduct.= '</ul></li>';
					}
				}

				$menuProduct.= '</ul></li>';
			}
		}

		return $menuProduct;
	}
