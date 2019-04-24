<?php
namespace Controllers;

use Core\Controller;
use DAO\UserDAO;

class RecuperarSenhaController extends Controller {

	public function __construct(){
		parent::__construct();
	}

	public function index(){
		if(!$this->statusLogin()){
			$this->loadTemplate('recuperarSenha', array());
		} else{
			$this->loadView('404', array());
		}
	}

	public function cadastrar(){

		if(!empty($_SESSION['recoverPass']['session'])){

			if($this->statusLogin()){
				$aux = $_SESSION['recoverPass'];
				$this->sessionDestroy();
				$_SESSION['recoverPass'] = $aux;
			}

			$firstName = $_SESSION['recoverPass']['user']['firstName'];
			$token = $_SESSION['recoverPass']['token'];

			$data = array(
				'user' => array(
					'firstName' => $firstName,
					'token' => $token
				)
			);
			
			$this->loadTemplate('cadastrarSenha', $data);
			
		} else{
			$this->loadView('404', array());
		}
	}

	public function validate(){
		$userDAO = new UserDAO();

		if(filter_input(INPUT_GET, 'token', FILTER_SANITIZE_STRING)){
			$token = filter_input(INPUT_GET, 'token', FILTER_SANITIZE_STRING);

			if($userDAO->verifyTokenPassword($token)){
				// Redirecionar para a página de cadastro de senha
				$_SESSION['recoverPass']['session'] = true;
				header('Location: '.BASE_URL.'recuperar_senha/cadastrar/');
			} else{
				// Redirecionar para a página de token inválido
				$_SESSION['invalidToken'] = true;
				header('Location: '.BASE_URL.'token_invalido/');
			}

		} else{
			$this->loadView('404', array());
		}
	}
}