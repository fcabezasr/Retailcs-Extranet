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

		$tableUser = '<table id="table-user" class="table table-striped table-bordered" cellspacing="0" width="100%">
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
			<tbody>';

		foreach ($arrayUser as $key => $user) {
			$tableUser.= '<tr>
				<td class="td-center">'.($key+1).'</td>
				<td class="td-center">'.$user['user_name'].'</td>
				<td class="td-center">'.$user['type_user'].'</td>
				<td class="td-center">'.$user['business'].'</td>
				<td class="td-center">'.$user['registry_date'].'</td>
				<td class="td-center">'.$user['state'].'</td>
				<td class="td-center">
				<button class="btn btn-default btn-user-edit" iduser="'.$user['iduser'].'" type="button"><i class="glyphicon glyphicon-pencil"></i></button>
				<button class="btn btn-default btn-user-remove" iduser="'.$user['iduser'].'" type="button"><i class="glyphicon glyphicon-remove"></i></button>
				</td>
				</tr>';
		}

		$tableUser.= '</tbody>
			</table>
			<script>
			$(document).ready(function() {
			$("#table-user").DataTable();
			});
			</script>';

		return $tableUser;
	}


	function printTableTypeUser($arrayTypeUser){

		$tableTypeUser = '<table id="table-type-user" class="table table-striped table-bordered" cellspacing="0" width="100%">
			<thead>
			<tr>
			<th>N°</th>
			<th>Descripción</th>
			<th>Fecha Registro</th>
			<th>Estado</th>
			<th>Acciones</th>
			</tr>
			</thead>
			<tbody>';

		foreach ($arrayTypeUser as $key => $typeUser) {
			$tableTypeUser.= '<tr>
				<td class="td-center">'.($key+1).'</td>
				<td class="td-center">'.$typeUser['description'].'</td>
				<td class="td-center">'.$typeUser['registry_date'].'</td>
				<td class="td-center">'.$typeUser['state'].'</td>
				<td class="td-center">
				<button class="btn btn-default btn-user-type-edit" idtypeuser="'.$typeUser['idtype_user'].'" type="button"><i class="glyphicon glyphicon-pencil"></i></button>
				<button class="btn btn-default btn-user-type-remove" idtypeuser="'.$typeUser['idtype_user'].'" type="button"><i class="glyphicon glyphicon-remove"></i></button>
				</td>
				</tr>';
		}

		$tableTypeUser.= '</tbody>
			</table>
			<script>
			$(document).ready(function() {
			$("#table-type-user").DataTable();
			});
			</script>';

		return $tableTypeUser;
	}