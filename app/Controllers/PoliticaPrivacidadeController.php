<?php
namespace Controllers;

use Core\Controller;

class PoliticaPrivacidadeController extends Controller{

	public function __construct(){
		parent::__construct();
	}

	public function index(){
		$this->loadTemplate('politicaPrivacidade', array());
	}

}