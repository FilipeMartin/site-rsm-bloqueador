<?php
namespace Controllers;

use Core\Controller;
use Models\User;
use Models\RegistroVenda;
use DAO\PlatformDAO;
use DAO\RegistroVendaDAO;
use DAO\ValorPlanoDAO;
use Exception;

class RegistrarController extends Controller {
	
	private $configPagseguro;

	public function __construct(){
		parent::__construct();
		global $configPagseguro;
		$this->configPagseguro = $configPagseguro;
	}

	public function index(){
		$this->loadView('404', array());
	}

	public function servico(){
		$user = new User();
		$registroVenda = new RegistroVenda();
		$platformDAO = new PlatformDAO();
		$vehiclesArray = '';

		// Gerar token
		$tokenPurchase = $this->newToken();
		$_SESSION['token']['Purchase'] = $tokenPurchase;
		//----------------------------------------------

		// Receber dados da venda
		if(!empty($_SESSION['registerService']['purchase'])){
			$registroVenda = unserialize($_SESSION['registerService']['purchase']);
			$etapaRegistro = $_SESSION['registerService']['etapaRegistro'];
		} else{
			$registroVenda->setPlano(1);
			$registroVenda->setQuantidade(1);
			$etapaRegistro = ($this->statusLogin() ? 2:1);
		}
		//--------------------------------------------------------------------------

		// Receber dados do usuário
		if(!empty($_SESSION['registerService']['client'])){
			$user = unserialize($_SESSION['registerService']['client']);
		}
		//--------------------------------------------------------------

		// Carregar Veículos
		if($this->statusLogin()){

			if(!isset($_SESSION['platform']['vehicles'])){
				$vehicles = $platformDAO->getVehicles($this->user()->getIdPlatform());
				$_SESSION['platform']['vehicles'] = serialize($vehicles['vehicles']);
				$_SESSION['infoBox']['veiculo'] = $vehicles['infoBox'];
			}

			$vehicles = unserialize($_SESSION['platform']['vehicles']);
			if(count($vehicles) > 0){
				foreach ($vehicles as $vehicle) {
					$vehiclesArray[] = $vehicle->getVehicleArray();
				}
			}
		}
		//-----------------------------------------------------------------------------

		$dados = array(
			'statusLogin' => $this->statusLogin(),
			'tokenPurchase' => $tokenPurchase,
			'etapaRegistro' => $etapaRegistro,
			'dadosVenda' => $registroVenda->getRegistroVendaArray(),
			'user' => $user->getUserArray(),
			'states' => $user->getAllStates(),
			'vehicles' => $vehiclesArray
		);

		$this->loadTemplate('registrarServico', $dados);
	}

	public function finalizarVenda(){
		$user = new User();
		$registroVenda = new RegistroVenda();
		$registroVendaDAO = new RegistroVendaDAO();
		$valorPlanosDAO = new ValorPlanoDAO();
		$resposta = array('status' => false);

		if(!empty($_SERVER['HTTP_REFERER']) && strstr($_SERVER['HTTP_REFERER'], BASE_URL) && !empty($_SESSION['registerService'])){

			$tokenPurchase = $_SESSION['token']['Purchase'] ?? '';
			$token = filter_input(INPUT_POST, 'token_purchase', FILTER_SANITIZE_STRING);

			if($tokenPurchase != $token){
				echo json_encode($resposta);
				exit;
			}

			// Receber dados da venda
			$registroVenda = unserialize($_SESSION['registerService']['purchase']);
			$etapaRegistro = $_SESSION['registerService']['etapaRegistro'];
			//---------------------------------------------------------------------

			// Receber dados do usuário
			if(!$this->statusLogin()){
				$user = unserialize($_SESSION['registerService']['client']);
			} else{
				$user = $this->user();
			}
			//--------------------------------------------------------------

			// Manipular Sessão
			if(!$this->statusLogin()){
				$this->sessionDestroy();
			} else{
				unset($_SESSION['registerService']);
				unset($_SESSION['pagseguro']);
			}
			$_SESSION['pagseguro']['user'] = serialize($user);
			//------------------------------------------------

			// Cadastrar Token
			$token = array(
				'type' => 1,
				'token' => $this->newToken()
			);
			//------------------------------

			// Processar valores da Venda
			$registroVenda->processarValores($valorPlanosDAO->getValores());
			//--------------------------------------------------------------

			// Registro da Venda
			$infoRegistroVenda = array();
			
			if(!$this->statusLogin()){
				$infoRegistroVenda = $registroVendaDAO->adicionar($user, $registroVenda, $token, true);
			} else{
				$infoRegistroVenda = $registroVendaDAO->adicionar($user, $registroVenda, $token, false);
			}
			//------------------------------------------------------------------------------------------

			if($infoRegistroVenda['status']){

				// Criar um Teamplete em html para o E-mail
				if(!$this->statusLogin()){
					$urlActivateAccount = BASE_URL.'activate/account/?token='.$token['token'];

					$emailUser = array(
		          		'nome' => $user->getName(),
		            	'email' => $user->getEmail(),
		            	'assunto' => 'Confirmar Cadastro',
		            	'conteudoHtml' => '<h1>Seja Bem-Vindo a RSM Bloqueador</h1><br/>
											<a href="'.$urlActivateAccount.'">Click aqui</a> para ativar sua conta !',
		            	'conteudoTxt' => 'Teste de envio de E-mail.'
			    	);
			    	
			    	// Enviar um e-mail para o usuário ativar a conta
					if(!$this->email($emailUser)){
						// Log - Erro no envio do E-mail
					}
				}
				//----------------------------------------------------------------------------------------------------
				
				// Forma de pagamento
				switch($registroVenda->getFormaPagamento()){
					case 1:
						// Boleto Bancário
						//$resposta['status'] = true;	
						break;
					case 2:
						$data = array();
						$data["email"] = $this->configPagseguro['email'];
						$data["token"] = (($this->configPagseguro['environment']) ? $this->configPagseguro['token'] : $this->configPagseguro['tokenSandbox']);
						$data["currency"] = "BRL";
						$data["itemId1"] = "1";
						$data["itemDescription1"] = "Plano ".$registroVenda->getPlanoNome();
						$data["itemAmount1"] = number_format($registroVenda->getValorUnitario(), 2, '.', '');
						$data["itemQuantity1"] = $registroVenda->getQuantidade();
						$data["itemWeight1"] = "1";
						$data["reference"] = $infoRegistroVenda['idVenda'];
						$data["senderName"] = $user->getName();
						$data["senderAreaCode"] = "21"; //===================================================================> EDITARRRRRRRRRRRRRRRRRRRRRRRRRRRRRRRRRRRRRRRRR
						$data["senderPhone"] = "963256252"; //===============================================================> EDITARRRRRRRRRRRRRRRRRRRRRRRRRRRRRRRRRRRRRRRRR
						$data["senderEmail"] = (($this->configPagseguro['environment']) ? $user->getEmail() : $this->configPagseguro['emailUserSandbox']);
						$data["senderCPF"] = $user->getCpf();
						$data["shippingType"] = "1";
						$data["shippingAddressStreet"] = $user->getAddress();
						$data["shippingAddressNumber"] = $user->getAddressNumber();
						$data["shippingAddressComplement"] = $user->getComplement();
						$data["shippingAddressDistrict"] = $user->getNeighborhood();
						$data["shippingAddressPostalCode"] = str_replace(array(".", "-"), "", $user->getZipCode());
						$data["shippingAddressCity"] = $user->getCity();
						$data["shippingAddressState"] = $user->getState();
						$data["shippingAddressCountry"] = "BRA";
						$data = http_build_query($data);

						$url = (($this->configPagseguro['environment']) ? 'https://ws.' : 'https://ws.sandbox.').'pagseguro.uol.com.br/v2/checkout';

						$curl = curl_init($url);
						curl_setopt($curl, CURLOPT_HTTPHEADER, array("Content-Type: application/x-www-form-urlencoded; charset=ISO-8859-1"));
						curl_setopt($curl, CURLOPT_POST, true);
						curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
						curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
						curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
						$xml = curl_exec($curl);
						$httpCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
						curl_close($curl);

						if($httpCode == 200 && !empty($xml)){
							$xml = simplexml_load_string($xml);
							$resposta['code'] = strval($xml->code);
							$resposta['status'] = true;
						}
				}
			}	

		    echo json_encode($resposta);
    
		} else{
			$this->loadView('404', array());
		}
	}

	public function consultarTransacao(){
		$resposta = array('status' => false);

		if(!empty($_SERVER['HTTP_REFERER']) && strstr($_SERVER['HTTP_REFERER'], BASE_URL)){

			$transactionCode = filter_input(INPUT_POST, 'transactionCode', FILTER_SANITIZE_STRING);
			
			$data = array();
			$data['email'] = $this->configPagseguro['email'];
			$data['token'] = (($this->configPagseguro['environment']) ? $this->configPagseguro['token'] : $this->configPagseguro['tokenSandbox']);
			$data = http_build_query($data);

			$url = (($this->configPagseguro['environment']) ? 'https://ws.' : 'https://ws.sandbox.').'pagseguro.uol.com.br/v2/transactions/'.$transactionCode."?".$data;

			$curl = curl_init($url);
			curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
			curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
			$xml = curl_exec($curl);
			$httpCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
			curl_close($curl);

			if($httpCode == 200 && !empty($xml)){
				$_SESSION['pagseguro']["transactionXML"] = $xml;
				$resposta['status'] = true;
			}

			echo json_encode($resposta);

		} else{
			$this->loadView('404', array());
		}	
	}

	public function sucesso(){
		$user = unserialize($_SESSION['pagseguro']["user"] ?? null);
		$transactionXML = $_SESSION['pagseguro']["transactionXML"] ?? null;

		if(!empty($user)){

			$dados = array(
				'user' => $user->getUserArray(),
				'statusLogin' => $this->statusLogin()
			);

			if(!empty($transactionXML)){
				$transaction = simplexml_load_string($transactionXML);
				
				$dados['transaction']['status'] = $transaction->status;
				$dados['transaction']['code'] = $transaction->code;
				$dados['transaction']['statusBoleto'] = (($transaction->paymentMethod->type == 2) ? true : false);
				$dados['transaction']['linkBoleto'] = $transaction->paymentLink ?? '';
			}

			$this->loadTemplate('registrarSucesso', $dados);

		} else{
			$this->loadView('404', array());
		}
	}
}