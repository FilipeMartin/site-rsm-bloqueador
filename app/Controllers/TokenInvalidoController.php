<?php
namespace Controllers;

use Core\Controller;

class TokenInvalidoController extends Controller {

	public function __construct(){
		parent::__construct();
	}

	public function index(){

		if(!empty($_SESSION['invalidToken'])){

			if($this->statusLogin()){
				$aux = $_SESSION['invalidToken'];
				$this->sessionDestroy();
				$_SESSION['invalidToken'] = $aux;
			}
			
			$this->loadTemplate('tokenInvalido', array());

		} else{
			$this->loadView('404', array());
		}
	}
}