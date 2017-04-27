<?php

class User extends Nucleo\Includes\Controlador{

	public $obj = null;

	function __construct(){
		parent::__construct();
	}

	// Método que se llama por defecto
	public function index(){

	}


	public function insertUser($iduser = null, $user_name = null, $password = null, $business_name = null, $type_user = null){

		$user = $this->modelo('Muser');
		$user->setIdUser($iduser);
		$user->setUserName($user_name);
		$user->setUserPass($password);
		$user->setIdBusiness($business_name);
		$user->setIdTypeUser($type_user);		
		$result = $user->insertUser();
		
		if ($result['result']['success']) {
			$result['result']['tableuser'] = $this->tableUser();
		} else {
			$result['result']['tableuser'] = '';
		}
		
		echo json_encode($result);
	}


	public function insertTypeUser($idtype_user = null, $description_type = null){

		$type_user = $this->modelo('Mtype_user');
		$type_user->setIdTypeUser($idtype_user);
		$type_user->setDescription(urldecode($description_type));
		$result = $type_user->insertTypeUser();

		if ($result['result']['success']) {
			$result['result']['tabletypeuser'] = $this->tableTypeUser();
		} else {
			$result['result']['tabletypeuser'] = '';
		}
				
		echo json_encode($result);
	}


	public function updateUser($iduser = null){

		$user = $this->modelo('Muser');
		$user->setIdUser($iduser);
		$result = $user->updateUser();

		echo json_encode($result);
	}


	public function updateTypeUser($idtype_user = null){

		$type_user = $this->modelo('Mtype_user');
		$type_user->setIdTypeUser($idtype_user);
		$result = $type_user->updateTypeUser();

		echo json_encode($result);
	}


	public function deleteUser($iduser = null){

		$user = $this->modelo('Muser');
		$user->setIdUser($iduser);
		$result = $user->deleteUser();

		if ($result['result']['success']) {
			$result['result']['tableuser'] = $this->tableUser();
		} else {
			$result['result']['tableuser'] = '';
		}

		echo json_encode($result);
	}


	public function deleteTypeUser($idtype_user = null){

		$type_user = $this->modelo('Mtype_user');
		$type_user->setIdTypeUser($idtype_user);
		$result = $type_user->deleteTypeUser();

		if ($result['result']['success']) {
			$result['result']['tabletypeuser'] = $this->tableTypeUser();
		} else {
			$result['result']['tabletypeuser'] = '';
		}

		echo json_encode($result);
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

