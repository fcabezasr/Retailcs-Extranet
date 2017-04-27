<?php

class File extends Nucleo\Includes\Controlador{

	public $obj = null;

	function __construct(){
		parent::__construct();
	}

	// Método que se llama por defecto
	public function index(){	

	}


	public function insertFile(){

		if(!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest'){

			if (isset($_POST)) {
				$extension = '';
				$size = '';
				$url = $_POST['file-url'];

				//Tratamos el URL
				if (strpos($url, 'www.youtube.com')) {
					if (!strpos($url, 'embed')) {
						$array1 = explode('https://www.youtube.com/watch?v=', $url);
						$array2 = explode('&', $array1[1]);
						$url = 'https://www.youtube.com/embed/'.$array2[0];						
					}
				}

				if ($_FILES['file-upload']['name'] != ''){
					$dir_name = 'Files/';
					$file = $_FILES['file-upload'];
					$ext = array_reverse(explode(".", $file['name']));
					$extension = $ext[0];
					$size = round(($file['size'] / (1024*1024)), 2).'MB';
					//$url = 'http://www.retailcs.com/extranet/'.$dir_name.$file['name'];
					$url = 'http://'.$_SERVER["HTTP_HOST"].'/extranet/'.$dir_name.$file['name'];
				}
								
				$mfile = $this->modelo('Mfile');

				$mfile->setFileName(utf8_decode($_POST['file-name']));
				$mfile->setFileExt($extension);
				$mfile->setPublicationDate($_POST['registry-date']);
				$mfile->setFileSize($size);
				$mfile->setFileUrl($url);
				$mfile->setIdFileType($_POST['idfile-type']);
				$mfile->setIdProduct($_POST['idproduct']);
				$mfile->setIdVersion($_POST['idversion-product']);

				$result = $mfile->insertFile();

				if ($result['result']['success']) {
					if ($_FILES['file-upload']['name'] != ''){
						//comprobamos si existe un directorio para subir el archivo. Si no es así, lo creamos
						if(!is_dir($dir_name)) 
							mkdir($dir_name, 0777);

						//comprobamos si el archivo ha subido
						if ($file['name'] && move_uploaded_file($file['tmp_name'],$dir_name.$file['name'])){
							sleep(3);//retrasamos la petición 3 segundos
							//devolvemos el nombre del archivo para pintar la imagen
							$result['result']['file'] = 'El archivo: \''.$file['name'].'\' se ha guardado correctamente.';
						} else {
							$result['result']['file'] = 'El archivo no se ha guardado, ocurrió un error.';
						}
					} else {
						$result['result']['file'] = 'La URL se ha guardado correctamente.';
					}
				}
			}

			echo json_encode($result);

		} else {
			throw new Exception("Error Processing Request", 1);   
		}
		
	}

}
