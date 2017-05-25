<?php
	
class Mcontent_detail {

	private $padre;
	private $db;
	private $session;
	private $result;

	/** VARIABLES **/

	private $IdContentDetail;
	private $DetailDescription;
	private $DetailDescriptionEn;
	private $RegistryDate;
	private $UpdateDate;
	private $State;
	private $IdContent;


	function __construct($el){
		
		$this->padre = $el;
		$this->db = $this->padre->lib('DB');
		$this->session = $this->padre->lib('Session');
		$this->result = array('result' => array('success' => 0, 'message' => '', 'id' => null));
	}


	/********************* MÉTODOS *********************/


	public function selectContentDetailxIdContent(){

		$this->session->start();

		$sql = $this->db->_query("SELECT idcontent_detail, detail_description, detail_description_en, registry_date FROM tbl_content_detail WHERE idcontent = '".$this->getIdContent()."' AND state = 1");
		$array_content_detail = array();
	
		while ($obj = $sql->fetch_object()) {
			array_push($array_content_detail, $obj);
		}

		if($array_content_detail){
			$this->result['result']['success'] = 1;
			$this->result['result']['array_content_detail'] = $array_content_detail;

			if ($_SESSION['Business']['Language']=='en') {
				$this->result['result']['message'] = 'The query was successful.';
			} else {
				$this->result['result']['message'] = 'La consulta se realizó satisfactoriamente.';
			}
		}else{
			$this->result['result']['success'] = 0;
			$this->result['result']['array_content_detail'] = null;

			if ($_SESSION['Business']['Language']=='en') {
				$this->result['result']['message'] = 'An error occurred while performing the query.';
			} else {
				$this->result['result']['message'] = 'Ocurrió un error al realizar la consulta.';
			}
		}

		return $this->result;
	}


	public function countContentDetailxIdContent(){

		$this->session->start();

		$sql = $this->db->_query("SELECT idcontent_detail FROM tbl_content_detail WHERE idcontent = '".$this->getIdContent()."' AND state = 1");

		if($sql->num_rows > 0){
			$this->result['result']['success'] = 1;
			$this->result['result']['countContent'] = $sql->num_rows;

			if ($_SESSION['Business']['Language']=='en') {
				$this->result['result']['message'] = 'The query was successful.';
			} else {
				$this->result['result']['message'] = 'La consulta se realizó satisfactoriamente.';
			}
		}else{
			$this->result['result']['success'] = 0;
			$this->result['result']['countContent'] = 0;

			if ($_SESSION['Business']['Language']=='en') {
				$this->result['result']['message'] = 'An error occurred while performing the query.';
			} else {
				$this->result['result']['message'] = 'Ocurrió un error al realizar la consulta.';
			}
		}

		return $this->result;
	}


	public function countContentDetailxIdContentxRegistryDate(){

		$this->session->start();

		$fechaHoy = $this->getRegistryDate();
		$fechaAnterior = date('Y/m/d', strtotime('-1 month'));

		$sql = $this->db->_query("SELECT idcontent_detail FROM tbl_content_detail WHERE idcontent = '".$this->getIdContent()."' AND (registry_date BETWEEN '".$fechaAnterior."' AND '".$fechaHoy."') AND state = 1");

		if($sql->num_rows > 0){
			$this->result['result']['success'] = 1;
			$this->result['result']['countContent'] = $sql->num_rows;

			if ($_SESSION['Business']['Language']=='en') {
				$this->result['result']['message'] = 'The query was successful.';
			} else {
				$this->result['result']['message'] = 'La consulta se realizó satisfactoriamente.';
			}
		}else{
			$this->result['result']['success'] = 0;
			$this->result['result']['countContent'] = 0;

			if ($_SESSION['Business']['Language']=='en') {
				$this->result['result']['message'] = 'An error occurred while performing the query.';
			} else {
				$this->result['result']['message'] = 'Ocurrió un error al realizar la consulta.';
			}
		}

		return $this->result;
	}


	public function insertContentDetail(){

		$this->session->start();

		$sql = $this->db->_query("INSERT INTO tbl_content_detail (detail_description, detail_description_en, registry_date, update_date, idcontent) VALUES ('".$this->getDetailDescription()."', '".$this->getDetailDescriptionEn()."', '".$this->getRegistryDate()."', '".$this->getUpdateDate()."', ".$this->getIdContent().") ");

		if($sql){
			$this->result['result']['success'] = 1;
			$this->result['result']['id'] = $this->db->mysql()->insert_id;

			if ($_SESSION['Business']['Language']=='en') {
				$this->result['result']['message'] = 'Data has been successfully registered.';
			} else {
				$this->result['result']['message'] = 'Los datos se han registrado satisfactoriamente.';
			}
		}else{
			$this->result['result']['success'] = 0;

			if ($_SESSION['Business']['Language']=='en') {
				$this->result['result']['message'] = 'The data has not been registered, an error occurred.';
			} else {
				$this->result['result']['message'] = 'Los datos no se han registrado, ocurrió un error.';
			}
		}

		return $this->result;
	}

	/********************* MÉTODOS SET & GET *********************/

	public function setIdContentDetail($IdContentDetail = null){

		$this->IdContentDetail = $IdContentDetail;
	}

	public function getIdContentDetail(){
		
		return $this->IdContentDetail;
	}

	public function setDetailDescription($DetailDescription = null){

		$this->DetailDescription = $DetailDescription;
	}

	public function getDetailDescription(){
		
		return $this->DetailDescription;
	}

	public function setDetailDescriptionEn($DetailDescriptionEn = null){

		$this->DetailDescriptionEn = $DetailDescriptionEn;
	}

	public function getDetailDescriptionEn(){
		
		return $this->DetailDescriptionEn;
	}

	public function setRegistryDate($RegistryDate = null){

		$this->RegistryDate = $RegistryDate;
	}

	public function getRegistryDate(){
		
		return $this->RegistryDate;
	}

	public function setUpdateDate($UpdateDate = null){

		$this->UpdateDate = $UpdateDate;
	}

	public function getUpdateDate(){
		
		return $this->UpdateDate;
	}

	public function setState($State = null){

		$this->State = $State;
	}

	public function getState(){
		
		return $this->State;
	}

	public function setIdContent($IdContent = null){

		$this->IdContent = $IdContent;
	}

	public function getIdContent(){
		
		return $this->IdContent;
	}

}