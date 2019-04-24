<?php
namespace Controllers;

use Core\Controller;
use DAO\UserDAO;

class ActivateController extends Controller {

	public function __construct(){
		parent::__construct();
	}

	public function index(){
		$this->loadView('404', array());
	}

	public function account(){
		$userDAO = new UserDAO();

		if(filter_input(INPUT_GET, 'token', FILTER_SANITIZE_STRING)){
			$token = filter_input(INPUT_GET, 'token', FILTER_SANITIZE_STRING);

			if($userDAO->activateUser($token)){
				// Redirecionar para a página de login
				$_SESSION['newAccount'] = true;
				header('Location: '.BASE_URL.'conta_ativada/');
			} else{
				// Redirecionar para a página de token inválido
				$_SESSION['invalidToken'] = true;
				header('Location: '.BASE_URL.'token_invalido/');
			}

		}else{
			$this->loadView('404', array());
		}
	}
}