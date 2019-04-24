<?php
namespace Controllers;

use Core\Controller;
use DAO\ValorPlanoDAO;

class HomeController extends Controller {

	public function __construct(){
		parent::__construct();
	}

	public function index(){
		$valorPlanoDAO = new ValorPlanoDAO();

		$dados = array();
		$dados = $valorPlanoDAO->getValores();

		$this->loadTemplate('home', $dados);
	}
}