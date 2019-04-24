<?php
namespace Controllers;

use Core\Controller;
use DAO\PlatformDAO;
use DAO\RegistroVendaDAO;

class AreaClienteController extends Controller {

	public function __construct(){
		parent::__construct();

		if(!$this->statusLogin()){
			header('Location: '.BASE_URL);
			exit;
		}
	}

	public function index(){
		$platformDAO = new PlatformDAO();
		$registroVendaDAO = new RegistroVendaDAO();

		// Carregar Veículos
		if(!isset($_SESSION['platform']['vehicles'])){
			$vehicles = $platformDAO->getVehicles($this->user()->getIdPlatform());
			$_SESSION['platform']['vehicles'] = serialize($vehicles['vehicles']);
			$_SESSION['infoBox']['veiculo'] = $vehicles['infoBox'];
		}
		//------------------------------------------------------------------------
		
		// Verificar Serviço
		if(!isset($_SESSION['infoBox']['servicos'])){
			$servicos = (date('Y-m-d', strtotime($this->user()->getExpirationTime())) > date('Y-m-d')) ? 1 : 0;
			$_SESSION['infoBox']['servicos'] = $servicos;
		}
		//-----------------------------------------------------------------------------------------------------

		// Faturas em Aberto
		if(!isset($_SESSION['infoBox']['faturas'])){
			$_SESSION['infoBox']['faturas'] = $registroVendaDAO->getVendasAberta($this->user()->getId());
		}
		//-----------------------------------------------------------------------------------------------

		// InfoBox
		$infoBox = $_SESSION['infoBox'];
		//------------------------------

		$dados = array(
			'infoBox' => $infoBox
		);

		$this->loadTemplate('areaCliente', $dados);
	}

	public function veiculos(array $type){
		$platformDAO = new PlatformDAO();

		// Carregar Veículos
		if(!isset($_SESSION['platform']['vehicles'])){
			$vehicles = $platformDAO->getVehicles($this->user()->getIdPlatform());
			$_SESSION['platform']['vehicles'] = serialize($vehicles['vehicles']);
			$_SESSION['infoBox']['veiculo'] = $vehicles['infoBox'];
		}
		//------------------------------------------------------------------------

		// Título
		$title = "Veículos";
		//------------------

		// InfoBox
		$infoBox = $_SESSION['infoBox']['veiculo'];
		$infoBox['check'] = 0;
		//-----------------------------------------

		// InfoBox Check
		switch($type[0]){
			case 'ativo':
				$infoBox['check'] = 1; 
			break;	
			case 'desabilitado':
				$infoBox['check'] = 2; 
		}
		//----------------------------

		// Filtrar Veículo
		$vehiclesData = unserialize($_SESSION['platform']['vehicles']);
		$vehicles = array();

		if(count($vehiclesData) > 0){
			$cont = 1;
			foreach($vehiclesData as $vehicle){

				if(($infoBox['check'] == 0) || ($infoBox['check'] == 1 && $vehicle->getStatus() == 0) || ($infoBox['check'] == 2 && $vehicle->getStatus() == 1)){
					$vehicles[] = array(
						'id' => base64_encode($vehicle->getId()),
						'vehicle' => $cont++,
						'name' => $vehicle->getName(),
						'imei' => $vehicle->getImei(),
						'positionId' => $vehicle->getPositionId(),
						'phone' => $vehicle->getPhone(),
						'model' => $vehicle->getModel(),
						'category' => $vehicle->getCategoryId(),
						'expirationTime' => $vehicle->getExpirationTime('d/m/Y'),
						'status' => $vehicle->getStatus()
					);
				}
			}
		}
		//-----------------------------------------------------------------------
			
		// Definir Título
		if($infoBox['check'] == 1){
			if(count($vehicles) > 0){
				$title = "Veículos: Ativo";	
			} else{
				$title = "Não Existe Veículo Ativo";
			}

		} else if($infoBox['check'] == 2){
			if(count($vehicles) > 0){
				$title = "Veículos: Desabilitado";	
			} else{
				$title = "Não Existe Veículo Desabilitado";
			}

		} else if(count($vehicles) == 0){
			$title = "Não Existe Veículo Cadastrado";
		}
		//--------------------------------------------------

		$dados = array(
			'title' => $title,
			'vehicles' => $vehicles,
			'infoBox' => $infoBox
		);

		$this->loadTemplate('veiculos', $dados);
	}

	public function cadastrarVeiculo(){
		$platformDAO = new PlatformDAO();

		// Carregar Veículos
		if(!isset($_SESSION['platform']['vehicles'])){
			$vehicles = $platformDAO->getVehicles($this->user()->getIdPlatform());
			$_SESSION['platform']['vehicles'] = serialize($vehicles['vehicles']);
			$_SESSION['infoBox']['veiculo'] = $vehicles['infoBox'];
		}
		//------------------------------------------------------------------------

		// Título
		$title = "Cadastrar Veículo";
		//---------------------------

		// InfoBox
		$infoBox = $_SESSION['infoBox']['veiculo'];
		//-----------------------------------------

		// Definir Título
		if($infoBox['cadastrar'] == 0){
			$title = "Não Existe Veículo para Cadastrar";
		}
		//-----------------------------------------------

		$dados = array(
			'title' => $title,
			'infoBox' => $infoBox
		);

		$this->loadTemplate('cadastrarVeiculo', $dados);
	}

	public function faturas(array $type){
		$registroVendaDAO = new RegistroVendaDAO();

		// Carregar Faturas
		if(!isset($_SESSION['faturas'])){
			$_SESSION['faturas'] = serialize($registroVendaDAO->getVendas($this->user()->getId()));
		}
		//-----------------------------------------------------------------------------------------

		// Título
		$title = "Faturas";
		//-----------------
		
		// InfoBox
		$total = 0;
		$pago = 0;
		$emAberto = 0;
		$cancelado = 0;
		$reembolsado = 0;
		$check = 0;
		//---------------

		// InfoBox Check
		switch($type[0]){
			case 'em_aberto':
				$check = 1; 
			break;	
			case 'pago':
				$check = 3; 
			break;
			case 'cancelado':
				$check = 4; 
			break;
			case 'reembolsado':
				$check = 5;
		}
		//---------------------

		$faturasData = unserialize($_SESSION['faturas']);
		$faturas = array();

		if(count($faturasData) > 0){
			foreach($faturasData as $fatura){

				if($check == 0 || $fatura->getStatus() == $check){
					$faturas[] = array(
						'plano' => $fatura->getPlanoNome(),
						'valorTotal' => $fatura->getValorTotalMoeda(),
						'formaPagamento' => $fatura->getFormaPagamentoNome(),
						'dataVenda' => $fatura->getDataVenda('d/m/Y \à\s H:i:s'),
						'status' => $fatura->getStatusNome()
					);
				}

				// InfoBox
				$total++;
				switch($fatura->getStatus()){
					case 1: 
						$emAberto++; 
					break;
					case 3: 
						$pago++; 
					break;
					case 4: 
						$cancelado++; 
					break;
					case 5: 
						$reembolsado++;
				}
			}
		}

		// Definir Título
		if(count($faturas) > 0){
			switch ($check) {
				case 1:
					$title = "Faturas: Em Aberto";
				break;
				case 3:
					$title = "Faturas: Pago";
				break;
				case 4:
					$title = "Faturas: Cancelado";
				break;
				case 5:
					$title = "Faturas: Reembolsado";
			}
		} else{
			$title = "Não Existe Fatura";
		}
		//------------------------------------------

		$dados = array(
			'title' => $title,
			'faturas' => $faturas,

			'infoBox' => [
				'total' => $total,
				'pago' => $pago,
				'emAberto' => $emAberto,
				'cancelado' => $cancelado,
				'reembolsado' => $reembolsado,
				'check' => $check
			]
		);

		$this->loadTemplate('faturas', $dados);
	}

	public function minhaConta(array $type){

		// Título
		$title = "Minha Conta";
		//---------------------

		// InfoBox
		$check = 0;
		//---------

		// InfoBox Check
		switch($type[0]){
			case 'alterar_senha':
				$check = 1;
		}
		//-----------------------

		$dados = array(
			'title' => $title,
			'editUser' => $this->user()->getUserArray(),
			'states' => $this->user()->getAllStates(),

			'infoBox' => [
				'check' => $check
			]
		);

		$this->loadTemplate('minhaConta', $dados);
	}

	public function sair(){
		$this->sessionDestroy();
		header('Location: '.BASE_URL);
	}
}