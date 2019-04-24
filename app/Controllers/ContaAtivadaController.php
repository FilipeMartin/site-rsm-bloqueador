<?php
namespace Controllers;

use Core\Controller;

class ContaAtivadaController extends Controller {

	public function __construct(){
		parent::__construct();
	}

	public function index(){

		if(!empty($_SESSION['newAccount'])){

			if($this->statusLogin()){
				$aux = $_SESSION['newAccount'];
				$this->sessionDestroy();
				$_SESSION['newAccount'] = $aux;
			}
			
			$this->loadTemplate('contaAtivada', array());
			
		} else{
			$this->loadView('404', array());
		}
	}
}