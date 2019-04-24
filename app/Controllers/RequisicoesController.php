<?php
namespace Controllers;

use Core\Controller;
use Models\User;
use Models\Vehicle;
use Models\RegistroVenda;
use DAO\UserDAO;
use DAO\PlatformDAO;
use DAO\ValorPlanoDAO;
use Exception;

class RequisicoesController extends Controller {

	public function __construct(){
		parent::__construct();

		if(empty($_SERVER['HTTP_REFERER']) || (!strstr($_SERVER['HTTP_REFERER'], BASE_URL))){
			$this->loadView('404', array());
			exit;
		}
	}

	public function index(){
		$this->loadView('404', array());
	}

	public function valorPlanos(){
		$status = filter_input(INPUT_POST, 'status', FILTER_SANITIZE_NUMBER_INT);

		if($status){
    		$valorPlanoDAO = new ValorPlanoDAO();
		    echo json_encode($valorPlanoDAO->getValores());
		}
	}

	public function dadosVenda(){
		$registroVenda = new RegistroVenda();
		$resposta = array('status' => false);

		try{
			// Receber dados da venda
			$registroVenda->setIdVeiculo(base64_decode(filter_input(INPUT_POST, 'veiculo', FILTER_SANITIZE_STRING)));
			$registroVenda->setFormaPagamento(filter_input(INPUT_POST, 'formaPagamento', FILTER_SANITIZE_NUMBER_INT));
			$registroVenda->setPlano(filter_input(INPUT_POST, 'tipoPlano', FILTER_SANITIZE_NUMBER_INT));
			$registroVenda->setQuantidade(filter_input(INPUT_POST, 'qtdVeiculos', FILTER_SANITIZE_NUMBER_INT));
			$etapaRegistro = filter_input(INPUT_POST, 'etapaRegistro', FILTER_SANITIZE_NUMBER_INT);
			//--------------------------------------------------------------------------------------------------------
			
			// Armazenar dados da venda em sessão
			$_SESSION['registerService']['purchase'] = serialize($registroVenda);
			$_SESSION['registerService']['etapaRegistro'] = $etapaRegistro;
			//-------------------------------------------------------------------

			$resposta['status'] = true;

		} catch(Exception $e){
			$resposta['message'] = $e->getMessage();
		}

		echo json_encode($resposta);
	}

	public function dadosCliente(){
		$user = new User();
		$resposta = array('status' => false);

		try{
			// Dados Pessoais
			$user->setName(filter_input(INPUT_POST, 'nome', FILTER_SANITIZE_STRING));
			$user->setDateBirth(filter_input(INPUT_POST, 'dataNasc', FILTER_SANITIZE_STRING));
			$user->setCpf(filter_input(INPUT_POST, 'cpf', FILTER_SANITIZE_STRING));
			//--------------------------------------------------------------------------------

			// Endereço
			$user->setZipCode(filter_input(INPUT_POST, 'cep', FILTER_SANITIZE_STRING));
			$user->setAddress(filter_input(INPUT_POST, 'endereco', FILTER_SANITIZE_STRING));
			$user->setAddressNumber(filter_input(INPUT_POST, 'numero', FILTER_SANITIZE_STRING));
			$user->setComplement(filter_input(INPUT_POST, 'complemento', FILTER_SANITIZE_STRING));
			$user->setNeighborhood(filter_input(INPUT_POST, 'bairro', FILTER_SANITIZE_STRING));
			$user->setCity(filter_input(INPUT_POST, 'cidade', FILTER_SANITIZE_STRING));
			$user->setState(filter_input(INPUT_POST, 'estado', FILTER_SANITIZE_STRING));
			//------------------------------------------------------------------------------------

			// Contato
			$user->setEmail(filter_input(INPUT_POST, 'email', FILTER_SANITIZE_STRING));
			$user->setCellPhone(filter_input(INPUT_POST, 'celular', FILTER_SANITIZE_STRING));
			$user->setPhone(filter_input(INPUT_POST, 'telefone', FILTER_SANITIZE_STRING));
			//-------------------------------------------------------------------------------

			// Dados de Acesso
			$user->setLogin(filter_input(INPUT_POST, 'usuario', FILTER_SANITIZE_STRING));
			$user->setPassword(filter_input(INPUT_POST, 'senha', FILTER_SANITIZE_STRING));
			//----------------------------------------------------------------------------

			// Termos de Serviço
			$termosServico = filter_input(INPUT_POST, 'termosServicoCheck', FILTER_SANITIZE_STRING);
			$user->setServiceTerms(($termosServico == 'on') ? 1:0);
			//--------------------------------------------------------------------------------------

			// Armazenar dados do usuário em sessão
			$_SESSION['registerService']['client'] = serialize($user);
			//--------------------------------------------------------

			$resposta['status'] = true;

		} catch(Exception $e){
			$resposta['message'] = $e->getMessage();
		}
		
		echo json_encode($resposta);
	}

	public function userAltentification(){
		$user = new User();
		$userDAO = new UserDAO();
		$resposta = array('status' => false, 'error' => 1);

		try{
			$user->setLogin(filter_input(INPUT_POST, 'login', FILTER_SANITIZE_STRING));
			$user->setPassword(filter_input(INPUT_POST, 'password', FILTER_SANITIZE_STRING));

			// Altentificar Usuário
			$resposta = $userDAO->userAltentification($user->getLogin(), $user->getPassword());
			//---------------------------------------------------------------------------------

		} catch(Exception $e){
			$resposta['message'] = $e->getMessage();
		}

		echo json_encode($resposta);
	}

	public function registerVehicle(){
		$vehicle = new Vehicle();
		$platformDAO = new PlatformDAO();
		$resposta = array('status' => false);

		if($this->statusLogin() && $platformDAO->numberRegister($this->user()->getIdPlatform()) > 0){
			
			try{
				$vehicle->setName(filter_input(INPUT_POST, 'nome', FILTER_SANITIZE_STRING));
				$vehicle->setImei(filter_input(INPUT_POST, 'imei', FILTER_SANITIZE_NUMBER_INT));
				$vehicle->setPhone(filter_input(INPUT_POST, 'telefone', FILTER_SANITIZE_STRING));
				$vehicle->setModel(filter_input(INPUT_POST, 'modelo', FILTER_SANITIZE_STRING));
				$vehicle->setCategory(filter_input(INPUT_POST, 'categoria', FILTER_SANITIZE_STRING));
				$vehicle->setContact($this->user()->getName());

				// Cadastrar veículo na Plataforma					
				$vehicleAPI = $platformDAO->addVehicleAPI($vehicle);
				//--------------------------------------------------

				if($vehicleAPI != false){

					// Atualizar cadastro do veículo	
					if($platformDAO->updateVehicle($this->user()->getIdPlatform(), $vehicleAPI->id)){

						// Relacionar usuário com veículo na Plataforma				
						$permissionAPI = $platformDAO->addPermissionAPI($this->user()->getIdPlatform(), $vehicleAPI->id);
						//-----------------------------------------------------------------------------------------------

						if($permissionAPI != false){
							
							// Data de expiração do veículo
							$expirationTime = $platformDAO->getExpirationTime($vehicleAPI->id);				        
							if(!empty($expirationTime)){
								$resposta['expirationTime'] = $expirationTime;
							}
							//-----------------------------------------------------------------

							// Atualizar InfoBox
							$_SESSION['infoBox']['veiculo']['total']++;
							$_SESSION['infoBox']['veiculo']['ativo']++;
							$_SESSION['infoBox']['veiculo']['cadastrar']--;
							//---------------------------------------------

							// Resposta da Requisição 
							$resposta['qtdCadastrar'] = $_SESSION['infoBox']['veiculo']['cadastrar'];
							$resposta['status'] = true;
							//-----------------------------------------------------------------------

						} else{
							// LOG e E-mail para o suporte
							// Não foi possível relacionar usuário com veículo
						}

					} else{
						// LOG e E-mail para o suporte
						// Não foi possível atualizar cadastro do veículo
					}

				} else{
					// LOG e E-mail para o suporte
					// Não foi possível cadastrar veículo
				}

			} catch(Exception $e){
				$resposta['message'] = $e->getMessage();
			}
		}

		echo json_encode($resposta);
	}

	public function updateVehicle(){
		$platformDAO = new PlatformDAO();
		$resposta = array('status' => false);

		if($this->statusLogin()){

			try{
				$vehicle = $platformDAO->getVehicle($this->user()->getIdPlatform(), base64_decode(filter_input(INPUT_POST, 'veiculo', FILTER_SANITIZE_STRING)));

				if($vehicle == null){
					throw new Exception("Veículo não encontrado.");
				}	

				$vehicle->setName(filter_input(INPUT_POST, 'nome', FILTER_SANITIZE_STRING));
				$vehicle->setImei(filter_input(INPUT_POST, 'imei', FILTER_SANITIZE_NUMBER_INT));
				$vehicle->setPhone(filter_input(INPUT_POST, 'telefone', FILTER_SANITIZE_STRING));
				$vehicle->setModel(filter_input(INPUT_POST, 'modelo', FILTER_SANITIZE_STRING));
				$vehicle->setCategory(filter_input(INPUT_POST, 'categoria', FILTER_SANITIZE_STRING));
				
				// Editar veículo na Plataforma
				$vehicleAPI = $platformDAO->updateVehicleAPI($vehicle);
				//-----------------------------------------------------
				
				if($vehicleAPI != false){
					$resposta['status'] = true;
				}

			} catch(Exception $e){
				$resposta['message'] = $e->getMessage();
			}
		}	

		echo json_encode($resposta);
	}

	public function editUser(){
		$userDAO = new UserDAO();
		$resposta = array('status' => false);

		if($this->statusLogin()){
			try{
				// Dados Pessoais
				$user = $this->user();
				$user->setName(filter_input(INPUT_POST, 'nome', FILTER_SANITIZE_STRING));
				$user->setDateBirth(filter_input(INPUT_POST, 'dataNasc', FILTER_SANITIZE_STRING));
				$user->setCpf(filter_input(INPUT_POST, 'cpf', FILTER_SANITIZE_STRING));
				//--------------------------------------------------------------------------------

				// Endereço
				$user->setZipCode(filter_input(INPUT_POST, 'cep', FILTER_SANITIZE_STRING));
				$user->setAddress(filter_input(INPUT_POST, 'endereco', FILTER_SANITIZE_STRING));
				$user->setAddressNumber(filter_input(INPUT_POST, 'numero', FILTER_SANITIZE_STRING));
				$user->setComplement(filter_input(INPUT_POST, 'complemento', FILTER_SANITIZE_STRING));
				$user->setNeighborhood(filter_input(INPUT_POST, 'bairro', FILTER_SANITIZE_STRING));
				$user->setCity(filter_input(INPUT_POST, 'cidade', FILTER_SANITIZE_STRING));
				$user->setState(filter_input(INPUT_POST, 'estado', FILTER_SANITIZE_STRING));
				//------------------------------------------------------------------------------------

				// Contato
				$user->setEmail(filter_input(INPUT_POST, 'email', FILTER_SANITIZE_STRING));
				$user->setCellPhone(filter_input(INPUT_POST, 'celular', FILTER_SANITIZE_STRING));
				$user->setPhone(filter_input(INPUT_POST, 'telefone', FILTER_SANITIZE_STRING));
				//-------------------------------------------------------------------------------

				// Dados de Acesso
				$user->setLogin(filter_input(INPUT_POST, 'usuario', FILTER_SANITIZE_STRING));
				//---------------------------------------------------------------------------

				// Editar Usuário
				if($userDAO->editUser($user)){

					// Atualizar Sessão do Usuário
					$_SESSION['user']['data'] = serialize($user);
					//-------------------------------------------

					$resposta['status'] = true;
				}

			} catch(Exception $e){
				$resposta['message'] = $e->getMessage();
			}
		}	

		echo json_encode($resposta);
	}

	public function editPassword(){
		$userDAO = new UserDAO();
		$resposta = array('status' => false, 'error' => 1);

		if($this->statusLogin()){
			$currentPassword = filter_input(INPUT_POST, 'senha_atual', FILTER_SANITIZE_STRING);
			$newPassword = filter_input(INPUT_POST, 'nova_senha', FILTER_SANITIZE_STRING);

			// Verificar Senha
			if($userDAO->verifyPassword($this->user()->getId(), $currentPassword)){

				// Editar Senha
				if($userDAO->editPassword($this->user()->getId(), $newPassword)){
					$resposta['status'] = true;
					$resposta['error'] = 0;
				}

			} else{
				$resposta['error'] = 2;
			}
		}

		echo json_encode($resposta);
	}

	public function getPosition(){
		$vehicle = new Vehicle();
		$platformDAO = new PlatformDAO();
		$resposta = array('status' => false);

		if($this->statusLogin()){
			try{
				$vehicle->setPositionId(filter_input(INPUT_POST, 'idPosition', FILTER_SANITIZE_NUMBER_INT));
				$position = $platformDAO->getPosition($vehicle->getPositionId());

				if(!empty($position)){
					$resposta['devicetime'] = date('d/m/Y \à\s H:i:s', strtotime($position['devicetime']));
					$resposta['latitude'] = $position['latitude'];
					$resposta['longitude'] = $position['longitude'];
					$resposta['status'] = true;
				}

			} catch(Exception $e){
				$resposta['message'] = $e->getMessage();
			}
		}

		echo json_encode($resposta);	
	}

	public function recoverPassword(){
		$userDAO = new UserDAO();
		$resposta = array();

		if(!$this->statusLogin()){
			$emailLogin = filter_input(INPUT_POST, 'email_login', FILTER_SANITIZE_STRING);

			// Criar Token
			$token = $this->newToken();
			//-------------------------

			// Cadastrar um token para a recuperação da senha
			$resposta = $userDAO->addTokenPassword($emailLogin, $token);
			//----------------------------------------------------------

			if($resposta['status']){
				// Enviar E-mail
				$url = BASE_URL.'recuperar_senha/validate/?token='.$token;
				$name = $_SESSION['recoverPass']['user']['name'];
				$firstName = $_SESSION['recoverPass']['user']['firstName']; 
				$email = $resposta['email'];

				$emailUser = array(
					  'nome' => $name,
					'email' => $email,
					'assunto' => 'Cadastre uma nova senha!',
					'conteudoHtml' => '<h1>'.$firstName.', cadastre uma nova senha!</h1><br/>
										<a href="'.$url.'">Click aqui</a> para cadastrar uma nova senha!',
					'conteudoTxt' => 'Teste de envio de E-mail.'
				);
				
				if(!$this->email($emailUser)){
					$resposta['status'] = false;
					$resposta['error'] = 3;
				}
			}
		}

		echo json_encode($resposta);
	}

	public function registerPassword(){
		$user = new User();
		$userDAO = new UserDAO();
		$resposta = array('status' => false);

		if(!$this->statusLogin()){
			try{
				$user->setPassword(filter_input(INPUT_POST, 'senha', FILTER_SANITIZE_STRING));
				$token = filter_input(INPUT_POST, 'token', FILTER_SANITIZE_STRING);

				if(!empty($_SESSION['recoverPass']['token']) && $_SESSION['recoverPass']['token'] == $token){
					if($userDAO->editPassword($_SESSION['recoverPass']['user']['id'], $user->getPassword())){
						$this->sessionDestroy();
						$resposta['status'] = true;
					}
				}

			} catch(Exception $e){
				$resposta['message'] = $e->getMessage();
			}
		}

		echo json_encode($resposta);
	}

	public function verifyEmail(){
		$userDAO = new UserDAO();
		$resposta = false;

		$email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_STRING);
		$emailCurrent = filter_input(INPUT_POST, 'emailCurrent', FILTER_SANITIZE_STRING);

		if(filter_var($email, FILTER_VALIDATE_EMAIL)){
			if(($email == $emailCurrent) || (!$userDAO->verifyUserData("email", $email))){
				$resposta = true;	
			}
		} else{
			$resposta = "Por favor, forneça um endereço de e-mail válido.";
		}
					
		echo json_encode($resposta);
	}

	public function verifyLogin(){
		$user = new User();	
		$userDAO = new UserDAO();
		$resposta = false;

		try{
			$user->setLogin(filter_input(INPUT_POST, 'usuario', FILTER_SANITIZE_STRING));
			$loginCurrent = filter_input(INPUT_POST, 'usuarioCurrent', FILTER_SANITIZE_STRING);

		} catch(Exception $e){
			echo json_encode($resposta);
			exit;
		}

		if(($user->getLogin() == $loginCurrent) || (!$userDAO->verifyUserData("login", $user->getLogin()))){
			$resposta = true;	
		}

		echo json_encode($resposta);
	}

	public function verifyCpf(){
		$user = new User();
		$userDAO = new UserDAO();
		$resposta = false;

		try{
			$user->setCpf(filter_input(INPUT_POST, 'cpf', FILTER_SANITIZE_STRING));
			$cpfCurrent = filter_input(INPUT_POST, 'cpfCurrent', FILTER_SANITIZE_STRING);

		} catch(Exception $e){
			echo json_encode($resposta);
			exit;
		}

		if(($user->getCpf() == $cpfCurrent) || (!$userDAO->verifyUserData("cpf", $user->getCpf()))){
			$resposta = true;	
		}

		echo json_encode($resposta);
	}

	public function verifyImei(){
		$vehicle = new Vehicle();
		$platformDAO = new PlatformDAO();
		$resposta = false;

		try{
			$vehicle->setImei(filter_input(INPUT_POST, 'imei', FILTER_SANITIZE_NUMBER_INT));
			$imeiCurrent = filter_input(INPUT_POST, 'imeiCurrent', FILTER_SANITIZE_NUMBER_INT);

		} catch(Exception $e){
			echo json_encode($resposta);
			exit;
		}

		if(($vehicle->getImei() == $imeiCurrent) || (!$platformDAO->verifyImei($vehicle->getImei()))){
			$resposta = true;
		}

		echo json_encode($resposta);
	}
}