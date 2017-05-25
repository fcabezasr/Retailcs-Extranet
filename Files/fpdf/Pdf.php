<?php

	if ($_GET) {
		$idcontent = $_GET['idcontent'];
		$description = ucfirst($_GET['description']);
		$product = strtoupper($_GET['product']);
		$language = $_GET['language'];

		if ($language=='en'){
			$version = 'Version '.$_GET['version'];
		} else {
			$version = 'Versión '.$_GET['version'];
		}
		
		require('conexion.php');
		require('morepagestable.php');

		$conexion = new Conexion();
	    $sql = "SELECT idcontent_detail, detail_description, detail_description_en, DATE_FORMAT(registry_date, '%d-%m-%Y') AS registry_date FROM tbl_content_detail WHERE idcontent = ".$idcontent." AND state = 1 ORDER BY registry_date";
	    $link = $conexion->Conectarse();
		$result = $link->query($sql);
		$conexion->Desconectarse($link);

		$titulo = utf8_decode($product.' '.$description.' - '.$version);

		$pdf = new PDF('P','pt');
		$pdf->AliasNbPages();
		$pdf->AddPage();
		$pdf->SetFont('Arial','B',12);
		$pdf->MultiCell(0,25,$titulo,0,'C');
		$pdf->Ln(25);
		$pdf->SetFont('Arial','',10);
		$pdf->SetDrawColor(221,221,221);
		$pdf->tablewidths = array(40, 150, 350);

		$i = 0;
		if ($language=='en') {
			$data[] = array('N°', 'Registration Date', 'Description');
		} else {
			$data[] = array('N°', 'Fecha Registro', 'Descripción');	
		}

		while($row = $result->fetch_object()){
			$i++;
			if ($language=='en') {
				$data[] = array($i, $row->registry_date, $row->detail_description_en);
			} else {
				$data[] = array($i, $row->registry_date, $row->detail_description);
			}			
		}

		$pdf->morepagestable($data);
		//$pdf->Output();
		$pdf->Output($titulo.'.pdf', 'D');
	}

?>




   