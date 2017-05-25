<?php
	
class Mfile {

	private $padre;
	private $db;
	private $session;
	private $result;

	/** VARIABLES **/

	private $IdFile;
	private $FileName;
	private $FileExt;
	private $PublicationDate;
	private $FileSize;
	private $FileUrl;
	private $RegistryDate;
	private $UpdateDate;
	private $State;
	private $IdFileType;
	private $IdProduct;
	private $IdVersion;


	function __construct($el){
		
		$this->padre = $el;
		$this->db = $this->padre->lib('DB');
		$this->session = $this->padre->lib('Session');
		$this->result = array('result' => array('success' => 0, 'message' => '', 'id' => null));
	}


	/********************* MÉTODOS *********************/


    public function selectFilexIdProductMenu(){

    	$this->session->start();

    	$sql = $this->db->_query("SELECT idfile, idfile_type, idproduct, idversion FROM tbl_file WHERE idproduct = '".$this->getIdProduct()."' AND state = 1 ORDER BY idfile_type");
		$array_file = array();
		
		while($datos = $sql->fetch_object()){
			array_push($array_file, $datos);
		}

		if($array_file){
			$this->result['result']['success'] = 1;
			$this->result['result']['array_file'] = $array_file;

			if ($_SESSION['Business']['Language']=='en') {
				$this->result['result']['message'] = 'The query was successful.';
			} else {
				$this->result['result']['message'] = 'La consulta se realizó satisfactoriamente.';
			}
		}else{
			$this->result['result']['success'] = 0;
			$this->result['result']['array_file'] = null;

			if ($_SESSION['Business']['Language']=='en') {
				$this->result['result']['message'] = 'An error occurred while performing the query.';
			} else {
				$this->result['result']['message'] = 'Ocurrió un error al realizar la consulta.';
			}
		}

		return $this->result;
    }


    public function selectFilexIdProductxIdFileTypeMenu(){

    	$this->session->start();

    	$sql = $this->db->_query("SELECT idfile, idfile_type, idproduct, idversion FROM tbl_file WHERE idproduct = '".$this->getIdProduct()."' AND idfile_type = '".$this->getIdFileType()."' AND state = 1");
		$array_file = array();
		
		while($datos = $sql->fetch_object()){
			array_push($array_file, $datos);
		}

		if($array_file){
			$this->result['result']['success'] = 1;
			$this->result['result']['array_file'] = $array_file;

			if ($_SESSION['Business']['Language']=='en') {
				$this->result['result']['message'] = 'The query was successful.';
			} else {
				$this->result['result']['message'] = 'La consulta se realizó satisfactoriamente.';
			}
		}else{
			$this->result['result']['success'] = 0;
			$this->result['result']['array_file'] = null;

			if ($_SESSION['Business']['Language']=='en') {
				$this->result['result']['message'] = 'An error occurred while performing the query.';
			} else {
				$this->result['result']['message'] = 'Ocurrió un error al realizar la consulta.';
			}
		}

		return $this->result;
    }


    public function selectFilexIdProductxIdVersionMenu(){

    	$this->session->start();

    	$sql = $this->db->_query("SELECT idfile, idfile_type, idproduct, idversion FROM tbl_file WHERE idproduct = '".$this->getIdProduct()."' AND idversion = '".$this->getIdVersion()."' AND state = 1");
		$array_file = array();
		
		while($datos = $sql->fetch_object()){
			array_push($array_file, $datos);
		}

		if($array_file){
			$this->result['result']['success'] = 1;
			$this->result['result']['array_file'] = $array_file;

			if ($_SESSION['Business']['Language']=='en') {
				$this->result['result']['message'] = 'The query was successful.';
			} else {
				$this->result['result']['message'] = 'La consulta se realizó satisfactoriamente.';
			}
		}else{
			$this->result['result']['success'] = 0;
			$this->result['result']['array_file'] = null;

			if ($_SESSION['Business']['Language']=='en') {
				$this->result['result']['message'] = 'An error occurred while performing the query.';
			} else {
				$this->result['result']['message'] = 'Ocurrió un error al realizar la consulta.';
			}
		}

		return $this->result;
    }

    
    public function selectFilexIdProductIdContentTypeIdVersion(){

    	$this->session->start();

    	$file = $this->db->_query("SELECT idfile, file_name, publication_date, file_size, file_url FROM tbl_file WHERE idfile_type = '".$this->getIdFileType()."' AND idproduct = '".$this->getIdProduct()."' AND idversion = '".$this->getIdVersion()."' AND state = 1");

    	$array_file = array();
		while ($obj = $file->fetch_object()) {
			array_push($array_file, $obj);
		}

		if($array_file){
			$this->result['result']['success'] = 1;
			$this->result['result']['array_file'] = $array_file;

			if ($_SESSION['Business']['Language']=='en') {
				$this->result['result']['message'] = 'The query was successful.';
			} else {
				$this->result['result']['message'] = 'La consulta se realizó satisfactoriamente.';
			}
		}else{
			$this->result['result']['success'] = 0;
			$this->result['result']['array_file'] = null;

			if ($_SESSION['Business']['Language']=='en') {
				$this->result['result']['message'] = 'An error occurred while performing the query.';
			} else {
				$this->result['result']['message'] = 'Ocurrió un error al realizar la consulta.';
			}
		}

		return $this->result;
    }


    public function countFilexIdProductIdContentTypeIdVersion(){

    	$this->session->start();

    	$sql = $this->db->_query("SELECT idfile FROM tbl_file WHERE idfile_type = '".$this->getIdFileType()."' AND idproduct = '".$this->getIdProduct()."' AND idversion = '".$this->getIdVersion()."' AND state = 1");

		if($sql->num_rows > 0){
			$this->result['result']['success'] = 1;
			$this->result['result']['countFile'] = $sql->num_rows;

			if ($_SESSION['Business']['Language']=='en') {
				$this->result['result']['message'] = 'The query was successful.';
			} else {
				$this->result['result']['message'] = 'La consulta se realizó satisfactoriamente.';
			}
		}else{
			$this->result['result']['success'] = 0;
			$this->result['result']['countFile'] = 0;

			if ($_SESSION['Business']['Language']=='en') {
				$this->result['result']['message'] = 'An error occurred while performing the query.';
			} else {
				$this->result['result']['message'] = 'Ocurrió un error al realizar la consulta.';
			}
		}

		return $this->result;
    }


    public function countFilexIdProductIdContentTypeIdVersionxRegistryDate(){

    	$this->session->start();

		$fechaHoy = $this->getRegistryDate();
		$fechaAnterior = date('Y/m/d', strtotime('-1 month'));

    	$sql = $this->db->_query("SELECT idfile FROM tbl_file WHERE idfile_type = '".$this->getIdFileType()."' AND idproduct = '".$this->getIdProduct()."' AND idversion = '".$this->getIdVersion()."' AND (publication_date BETWEEN '".$fechaAnterior."' AND '".$fechaHoy."') AND state = 1");

		if($sql->num_rows > 0){
			$this->result['result']['success'] = 1;
			$this->result['result']['countFile'] = $sql->num_rows;

			if ($_SESSION['Business']['Language']=='en') {
				$this->result['result']['message'] = 'The query was successful.';
			} else {
				$this->result['result']['message'] = 'La consulta se realizó satisfactoriamente.';
			}
		}else{
			$this->result['result']['success'] = 0;
			$this->result['result']['countFile'] = 0;

			if ($_SESSION['Business']['Language']=='en') {
				$this->result['result']['message'] = 'An error occurred while performing the query.';
			} else {
				$this->result['result']['message'] = 'Ocurrió un error al realizar la consulta.';
			}
		}

		return $this->result;
    }


    public function insertFile(){

    	$this->session->start();

    	$file = $this->db->_query("INSERT INTO tbl_file (file_name, file_ext, publication_date, file_size, file_url, update_date, idfile_type, idproduct, idversion) VALUES ('".$this->getFileName()."', '".$this->getFileExt()."', '".$this->getPublicationDate()."', '".$this->getFileSize()."', '".$this->getFileUrl()."', '".$this->getUpdateDate()."', ".$this->getIdFileType().", ".$this->getIdProduct().", ".$this->getIdVersion().") ");
		$idfile = $this->db->mysql()->insert_id; //ID del registro insertado.
    	
    	if($idfile){
			$this->result['result']['success'] = 1;
			$this->result['result']['id'] = $idfile;

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

	public function setIdFile($IdFile = null){

		$this->IdFile = $IdFile;
	}

	public function getIdFile(){
		
		return $this->IdFile;
	}

	public function setFileName($FileName = null){

		$this->FileName = $FileName;
	}

	public function getFileName(){
		
		return $this->FileName;
	}

	public function setFileExt($FileExt = null){

		$this->FileExt = $FileExt;
	}

	public function getFileExt(){
		
		return $this->FileExt;
	}

	public function setPublicationDate($PublicationDate = null){

		$this->PublicationDate = $PublicationDate;
	}

	public function getPublicationDate(){
		
		return $this->PublicationDate;
	}

	public function setFileSize($FileSize = null){

		$this->FileSize = $FileSize;
	}

	public function getFileSize(){
		
		return $this->FileSize;
	}

	public function setFileUrl($FileUrl = null){

		$this->FileUrl = $FileUrl;
	}

	public function getFileUrl(){
		
		return $this->FileUrl;
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

	public function setIdFileType($IdFileType = null){

		$this->IdFileType = $IdFileType;
	}

	public function getIdFileType(){
		
		return $this->IdFileType;
	}

	public function setIdProduct($IdProduct = null){

		$this->IdProduct = $IdProduct;
	}

	public function getIdProduct(){
		
		return $this->IdProduct;
	}

	public function setIdVersion($IdVersion = null){

		$this->IdVersion = $IdVersion;
	}

	public function getIdVersion(){
		
		return $this->IdVersion;
	}

}