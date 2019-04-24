<?php
namespace Controllers;

use Core\Controller;
use DAO\PlatformDAO;

class SchedulesController extends Controller {

	private $password;
	private $ipServer;

	public function __construct(){
		parent::__construct();
		global $configPlatform;
		$this->password = $configPlatform['password'];
		$this->ipServer = $configPlatform['ipServer'];
	}

	public function index(){
		$this->loadView('404', array());
	}

	public function clearDbPlatform(){
		$platformDAO = new PlatformDAO();
		
		if($this->validation()){
			
			$TablePositions = $platformDAO->clearTablePositions();
			$TableEvents = $platformDAO->clearTableEvents();

			if($TablePositions['status'] == 1){
				$this->serverEmail('Plataforma - Banco de Dados', 'A Tabela <b>Positions</b> foi Limpa com Sucesso!');
			} 
			else if($TablePositions['status'] == 2){
				$this->serverEmail('Plataforma - Banco de Dados', 'A Tabela <b>Positions</b> não teve Registros para Limpar!');
			}
			else{
				$this->serverEmail('Plataforma - Banco de Dados', 'Erro ao Limpar a Tabela <b>Positions</b>!<br/><br/>Erro: '.$TablePositions['error']);
			}

			if($TableEvents['status'] == 1){
				$this->serverEmail('Plataforma - Banco de Dados', 'A Tabela <b>Events</b> foi Limpa com Sucesso!');
			} 
			else if($TableEvents['status'] == 2){
				$this->serverEmail('Plataforma - Banco de Dados', 'A Tabela <b>Events</b> não teve Registros para Limpar!');
			}
			else{
				$this->serverEmail('Plataforma - Banco de Dados', 'Erro ao Limpar a Tabela <b>Events</b>!<br/><br/>Erro: '.$TableEvents['error']);
			}

		} else{
			$this->loadView('404', array());
		}
	}

	private function validation(){
		$password = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_STRING);

		if($password == $this->password && $_SERVER['REMOTE_ADDR'] == $this->ipServer){
			return true;
		}
		return false;
	}

}