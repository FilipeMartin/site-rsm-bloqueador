<?php
namespace Controllers;

use Core\Controller;
use Models\User;
use Models\UserPlatform;
use DAO\UserDAO;
use DAO\UserPlatformDAO;
use DAO\PlatformDAO;
use DAO\RegistroVendaDAO;

class NotificationsController extends Controller {

	private $configPagseguro;

	public function __construct(){
		parent::__construct();
		global $configPagseguro;
		$this->configPagseguro = $configPagseguro;
	}

	public function index(){
		$this->loadView('404', array());
	}

	public function payments(){
		$userDAO = new UserDAO();
		$userPlatformDAO = new UserPlatformDAO();
		$platformDAO = new PlatformDAO();
		$registroVendaDAO = new RegistroVendaDAO();

		if(!empty(filter_input(INPUT_POST, 'notificationCode', FILTER_SANITIZE_STRING))){
			
			$notificationCode = filter_input(INPUT_POST, 'notificationCode', FILTER_SANITIZE_STRING);
			
			$data = array();
			$data['email'] = $this->configPagseguro['email'];
			$data['token'] = (($this->configPagseguro['environment']) ? $this->configPagseguro['token'] : $this->configPagseguro['tokenSandbox']);
			$data = http_build_query($data);

			$url = (($this->configPagseguro['environment']) ? 'https://ws.' : 'https://ws.sandbox.').'pagseguro.uol.com.br/v3/transactions/notifications/'.$notificationCode.'?'.$data;

			$curl = curl_init($url);
			curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
			curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
			$xml = curl_exec($curl);
			$httpCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
			curl_close($curl);

			if(!($httpCode == 200 && !empty($xml))){
				// LOG e E-mail para o suporte
				// Erro ao receber status da transação
				echo "Erro ao receber status da transação";
				exit;
			}
			
			$transaction = simplexml_load_string($xml);
			$registroVenda = $registroVendaDAO->getVenda(intval($transaction->reference));

			if($registroVenda == null){
				// LOG e E-mail para o suporte
				// Venda não encontrada
				echo "Venda não encontrada";
				exit;	
			}

			$registroVenda->setStatus(intval($transaction->status));

			if(!$registroVendaDAO->editarStatus($registroVenda)){
				// LOG e E-mail para o suporte
				// Erro ao atualizar status da venda
				echo "Erro ao atualizar status da venda";
				exit;
			}

			// Status da venda
			if($registroVenda->getStatus() === 3){

				$user = $userDAO->getUser($registroVenda->getIdUsuario());

				// Verificar se o usuário está cadastro na Plataforma
				$userPlatform = $userPlatformDAO->getUserPlatform($user);
				if($userPlatform == null){

					// Cadastrar usuário na Plataforma					
			        $userAPI = $platformDAO->addUserAPI($user, $registroVenda->getPlano());
					//---------------------------------------------------------------------
					
			        if($userAPI != false){

						// Relacionar usuário a plataforma
						$userPlatform = new UserPlatform();
						$userPlatform->setIdUser($user->getId());
						$userPlatform->setIdPlatform($userAPI->id);

			        	if($userPlatformDAO->addUserPlatform($userPlatform)){

			        		// Cadastrar veículo
			        		if($platformDAO->addVehicle($userAPI->id, $registroVenda->getQuantidade(), $registroVenda->getPlano(), true)){
			        			
			        			// Enviar E-mail para o Usuário
			        			echo"Usuário e veículo foram cadastrado na plataforma com sucesso!";
			        			
			        		} else{
			        			// LOG e E-mail para o suporte
			        			// Não foi possível cadastrar o veículo
			        			echo"Não foi possível cadastrar o veículo";
								exit;
			        		}

			        	} else{
			        		// LOG e E-mail para o suporte
			        		// Não foi possível criar relação do usuário com a Plataforma
			        		echo"Não foi possível criar relação do usuário com a Plataforma";
							exit;
			        	}

			        } else{
			        	// LOG e E-mail para o suporte
			        	// Não foi possível cadastrar usuário na Plataforma
			        	echo"Não foi possível cadastrar usuário na Plataforma";
						exit;
			        }

				} else{

					// Verificar se o veículo está cadastrado na Plataforma
					if($registroVenda->getIdVeiculo() === 0){

						// Cadastrar um novo veículo
						if($platformDAO->addVehicle($userPlatform->getIdPlatform(), $registroVenda->getQuantidade(), $registroVenda->getPlano(), false)){
							// Enviar E-mail para o Usuário
			        		echo"Veículo cadastrado na plataforma com sucesso!";
						} else{
							// LOG e E-mail para o suporte
			        		// Não foi possível cadastrar um novo veículo
			        		echo"Não foi possível cadastrar um novo veículo";
							exit;
						}

					} else{
						// Renovar a data de expiração do veículo
						if($platformDAO->updateDateVehicle($userPlatform->getIdPlatform(), $registroVenda->getIdVeiculo(), $registroVenda->getPlano())){
							// Enviar E-mail para o Usuário
			        		echo"Data de expiração do veículo renovada com sucesso!";
						} else{
							// LOG e E-mail para o suporte
			        		// Não foi possível renovar a data de expiração do veículo
			        		echo"Não foi possível renovar a data de expiração do veículo";
							exit;
						}
					}
				}
				
			} else{
				// E-mail para o cliente
				// Pagamento da compra não foi confirmado
				echo"Pagamento da compra não foi confirmado";
				exit;
			}

		} else{
			$this->loadView('404', array());
		}
	}
}