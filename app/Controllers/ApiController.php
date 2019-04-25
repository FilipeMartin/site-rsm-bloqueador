<?php
namespace Controllers;

use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;
use Core\Controller;
use Models\AppUser;
use Models\AppVehicle;
use Models\AppRegistered;
use DAO\UserDAO;
use DAO\AppUserDAO;
use DAO\AppVehicleDAO;
use DAO\AppRegisteredDAO;
use Exception;

class ApiController extends Controller {

	public function __construct(){
		parent::__construct();
	}

	public function run(){

		$session = function($request, $response, $next){

			if(!empty($_SERVER['PHP_AUTH_USER']) && !empty($_SERVER['PHP_AUTH_PW'])){
				
				$appUserDAO = new AppUserDAO();

				$authentication = $appUserDAO->authentication($_SERVER['PHP_AUTH_USER'], $_SERVER['PHP_AUTH_PW']);

				if($authentication['status']){
					$request = $request->withAttribute('token', $authentication['token']);
					$response = $next($request, $response);
					return $response;

				} else if($authentication['error'] == 3){
					
					header('WWW-Authenticate: Basic realm="My Realm"');
				    header('HTTP/1.0 400 Bad Request');
				    $data = array(
					    'error' => 2,
					    'message' => 'Account is expired.'
					);	
				    echo json_encode($data);
				    exit;

				} else if($authentication['error'] == 2){
					
					header('WWW-Authenticate: Basic realm="My Realm"');
				    header('HTTP/1.0 400 Bad Request');
				    $data = array(
					    'error' => 1,
					    'message' => 'Account is disabled.'
					);	
				    echo json_encode($data);
				    exit;

				} else if($authentication['error'] == 1){

					header('WWW-Authenticate: Basic realm="My Realm"');
				    header('HTTP/1.0 401 Unauthorized');
				    echo 'HTTP 401 Unauthorized - Acesso Negado.';
				    exit;
				}

			} else{
				header('WWW-Authenticate: Basic realm="My Realm"');
			    header('HTTP/1.0 401 Unauthorized');
			    echo 'HTTP 401 Unauthorized - Acesso Negado.';
			    exit;
			}
		};

		$sessionAdm = function($request, $response, $next){

			if(!empty($_SERVER['PHP_AUTH_USER']) && !empty($_SERVER['PHP_AUTH_PW'])){
				
				$appUserDAO = new AppUserDAO();

				$authentication = $appUserDAO->authentication($_SERVER['PHP_AUTH_USER'], $_SERVER['PHP_AUTH_PW']);

				if($authentication['status']){

					if($authentication['admin']){
						$request = $request->withAttribute('token', $authentication['token']);
						$response = $next($request, $response);	
						return $response;

					} else{
						header('WWW-Authenticate: Basic realm="My Realm"');
					    header('HTTP/1.0 400 Bad Request');
					    $data = array(
						    'error' => 3,
						    'message' => 'Not an admin account.'
						);	
					    echo json_encode($data);
					    exit;	
					}

				} else if($authentication['error'] == 3){
					
					header('WWW-Authenticate: Basic realm="My Realm"');
				    header('HTTP/1.0 400 Bad Request');
				    $data = array(
					    'error' => 2,
					    'message' => 'Account is expired.'
					);	
				    echo json_encode($data);
				    exit;

				} else if($authentication['error'] == 2){
					
					header('WWW-Authenticate: Basic realm="My Realm"');
				    header('HTTP/1.0 400 Bad Request');
				    $data = array(
					    'error' => 1,
					    'message' => 'Account is disabled.'
					);	
				    echo json_encode($data);
				    exit;

				} else if($authentication['error'] == 1){

					header('WWW-Authenticate: Basic realm="My Realm"');
				    header('HTTP/1.0 401 Unauthorized');
				    echo 'HTTP 401 Unauthorized - Acesso Negado.';
				    exit;
				}

			} else{
				header('WWW-Authenticate: Basic realm="My Realm"');
			    header('HTTP/1.0 401 Unauthorized');
			    echo 'HTTP 401 Unauthorized - Acesso Negado.';
			    exit;
			}
		};
		
		$authentication = function($request, $response, $next){

			if(!empty($_SERVER['PHP_AUTH_USER']) && !empty($_SERVER['PHP_AUTH_PW'])){
				
				$appUserDAO = new AppUserDAO();

				$verifyToken = $appUserDAO->verifyToken($_SERVER['PHP_AUTH_USER'], $_SERVER['PHP_AUTH_PW']);

				if($verifyToken['status']){
					$request = $request->withAttribute('idUser', intval($verifyToken['idUser']));
					$response = $next($request, $response);

				} else{
					header('WWW-Authenticate: Basic realm="My Realm"');
				    header('HTTP/1.0 401 Unauthorized');
				    echo 'HTTP 401 Unauthorized - Acesso Negado.';
				    exit;
				}

			} else{
				header('WWW-Authenticate: Basic realm="My Realm"');
			    header('HTTP/1.0 401 Unauthorized');
			    echo 'HTTP 401 Unauthorized - Acesso Negado.';
			    exit;
			}

			return $response;
		};

		$authenticationAdm = function($request, $response, $next){

			if(!empty($_SERVER['PHP_AUTH_USER']) && !empty($_SERVER['PHP_AUTH_PW'])){
				
				$appUserDAO = new AppUserDAO();

				$verifyToken = $appUserDAO->verifyToken($_SERVER['PHP_AUTH_USER'], $_SERVER['PHP_AUTH_PW']);

				if($verifyToken['status'] && $verifyToken['admin']){
					$request = $request->withAttribute('idUser', intval($verifyToken['idUser']));
					$response = $next($request, $response);

				} else{
					header('WWW-Authenticate: Basic realm="My Realm"');
				    header('HTTP/1.0 401 Unauthorized');
				    echo 'HTTP 401 Unauthorized - Acesso Negado.';
				    exit;
				}

			} else{
				header('WWW-Authenticate: Basic realm="My Realm"');
			    header('HTTP/1.0 401 Unauthorized');
			    echo 'HTTP 401 Unauthorized - Acesso Negado.';
			    exit;
			}

			return $response;
		};

		$checkPhone = function($request, $response, $next){

			if(!empty($_SERVER['PHP_AUTH_USER']) && !empty($_SERVER['PHP_AUTH_PW'])){

				$user = $_SERVER['PHP_AUTH_USER'];
				$password = $_SERVER['PHP_AUTH_PW'];

				if($user == 'rsm' && $password == '8av1dy1a3h'){
					$response = $next($request, $response);

				} else{
					header('WWW-Authenticate: Basic realm="My Realm"');
				    header('HTTP/1.0 401 Unauthorized');
				    echo 'HTTP 401 Unauthorized - Acesso Negado.';
				    exit;
				}

			} else{
				header('WWW-Authenticate: Basic realm="My Realm"');
			    header('HTTP/1.0 401 Unauthorized');
			    echo 'HTTP 401 Unauthorized - Acesso Negado.';
			    exit;
			}

			return $response;
		};
		
		$config = [
			'settings' => [
				'displayErrorDetails' => true
			]
		];

	    $app = new \Slim\App($config);

		$app->GET('/api/session/', function(Request $request, Response $response, array $args){
	
	    	$data = array(
	    		'token' => $request->getAttribute('token')
	    	);

	    	$response = $response->withJson(
		      		$data, 
		      		200, 
		      		JSON_UNESCAPED_UNICODE
		    );

	    	return $response;

		})->add($session);

		$app->GET('/api/adm/session/', function(Request $request, Response $response, array $args){

	    	$data = array(
	    		'token' => $request->getAttribute('token')
	    	);

	    	$response = $response->withJson(
		      		$data, 
		      		200, 
		      		JSON_UNESCAPED_UNICODE
		    );

	    	return $response;
	    	
		})->add($sessionAdm);

		$app->GET('/api/check/', function(Request $request, Response $response, array $args){
			
			$appUserDAO = new AppUserDAO();	

			$check = $appUserDAO->check($request->getAttribute('idUser'));
			
	    	$data = array(
	    		'lastUpdate' => $check['lastupdate'],
	    		'session' => $check['session'],	
	    	);
	    	
	    	$response = $response->withJson(
		      		$data, 
		      		200, 
		      		JSON_UNESCAPED_UNICODE
		    );

	    	return $response;

		})->add($authentication);

		$app->GET('/api/carga/', function(Request $request, Response $response, array $args){
			
			$appUserDAO = new AppUserDAO();	
			$appVehicleDAO = new appVehicleDAO();

			$user = $appUserDAO->getUser($request->getAttribute('idUser'));
			$vehicles = $appVehicleDAO->getVehicles($request->getAttribute('idUser'));

	    	$data = array();
	    	$data['user'][] = $user; 
	    	$data['vehicles'] = $vehicles; 

	    	$response = $response->withJson(
		      		$data, 
		      		200, 
		      		JSON_UNESCAPED_UNICODE
		    );

	    	return $response;

		})->add($authentication);

		$app->GET('/api/adm/', function(Request $request, Response $response, array $args){
			//ADM	
			$appUserDAO = new AppUserDAO();	

			$data = $appUserDAO->getUser($request->getAttribute('idUser'));
	    	
	    	$response = $response->withJson(
		      		$data, 
		      		200, 
		      		JSON_UNESCAPED_UNICODE
		    );

	    	return $response;

		})->add($authenticationAdm);

		$app->GET('/api/users/', function(Request $request, Response $response, array $args){
			//ADM
			$appUserDAO = new AppUserDAO();	

			$data['users'] = $appUserDAO->getAllUsers();
	    	
	    	$response = $response->withJson(
		      		$data, 
		      		200, 
		      		JSON_UNESCAPED_UNICODE
		    );

	    	return $response;

		})->add($authenticationAdm);

		$app->GET('/api/users/{idUser}', function(Request $request, Response $response, array $args){
			//ADM
			$appUserDAO = new AppUserDAO();
			$idUser = $args['idUser'] ?? 0;	

		    if(filter_var($idUser, FILTER_VALIDATE_INT)){

				$data = $appUserDAO->getUser(intval($idUser));
	    	
		    	$response = $response->withJson(
			      		$data, 
			      		200, 
			      		JSON_UNESCAPED_UNICODE
			    );	

			} else{
				$response->getBody()->write("Identificador inválido.");
				$response = $response->withStatus(400);
			}

	    	return $response;

		})->add($authenticationAdm);

		$app->POST('/api/users/', function(Request $request, Response $response, array $args){
			//ADM
			$appUser = new AppUser();
			$appUserDAO = new AppUserDAO();

			try{
				$appUser->setName($request->getParam('name') ?? '');
				$appUser->setCpf($request->getParam('cpf') ?? '');
				$appUser->setEmail($request->getParam('email') ?? '');
				$appUser->setCellPhone($request->getParam('cellPhone') ?? '');
				$appUser->setLogin($request->getParam('login') ?? '');
				$appUser->setPassword($request->getParam('password') ?? '');
				$appUser->setServiceTerms(1);
				$appUser->setExpirationTime($request->getParam('expirationTime') ?? '');
				$appUser->setAdmin($request->getParam('admin') ?? -1);
				$appUser->setStatus($request->getParam('status') ?? -1);
				$appUser->setPlatformToken($request->getParam('platformToken') ?? null);

				$addUser = $appUserDAO->addUser($appUser);

				if($addUser['status']){
					$data = $addUser['user'];
					$status = 200;

				} else{
					$data = array(
				    	'error' => 2,
				    	'message' => 'Erro ao cadastrar usuário.'
				    );
					$status = 400;	
				}

			} catch(Exception $e){

				$data = array(
				    'error' => 1,
				    'message' => $e->getMessage()
				);
				$status = 400;
			}	

			$response = $response->withJson(
				    $data, 
				    $status, 
				    JSON_UNESCAPED_UNICODE
			);

	    	return $response;

		})->add($authenticationAdm);

		$app->PUT('/api/users/{idUser}', function(Request $request, Response $response, array $args){
			//ADM
			$appUser = new AppUser();
			$appUserDAO = new AppUserDAO();

			$idUser = $args['idUser'] ?? 0;

			if(filter_var($idUser, FILTER_VALIDATE_INT)){

				try{
					$appUser->setId(intval($idUser));
					$appUser->setName($request->getParam('name') ?? '');
					$appUser->setCpf($request->getParam('cpf') ?? '');
					$appUser->setEmail($request->getParam('email') ?? '');
					$appUser->setCellPhone($request->getParam('cellPhone') ?? '');
					$appUser->setLogin($request->getParam('login') ?? '');
					$appUser->setExpirationTime($request->getParam('expirationTime') ?? '');
					$appUser->setAdmin($request->getParam('admin') ?? -1);
					$appUser->setStatus($request->getParam('status') ?? -1);
					$appUser->setPlatformToken($request->getParam('platformToken') ?? null);

					if(!empty($request->getParam('password'))){
						$appUser->setPassword($request->getParam('password') ?? '');
					}

					$editUser = $appUserDAO->editUser($appUser);

					if($editUser['status']){
						$data = $editUser['user'];
						$status = 200;

					} else if($editUser['error'] == 2){
						$data = array(
					    	'error' => 4,
					    	'message' => 'Não foi possível editar o usuário.'
					    );
						$status = 400;
							
					} else{
						$data = array(
					    	'error' => 3,
					    	'message' => 'Erro ao editar usuário.'
					    );
						$status = 400;
					}

				} catch(Exception $e){

					$data = array(
					    'error' => 2,
					    'message' => $e->getMessage()
					);
					$status = 400;
				}

			} else{
				$data = array(
					'error' => 1,
					'message' => 'Identificador inválido.'
				);
				$status = 400;
			}	

			$response = $response->withJson(
				    $data, 
				    $status, 
				    JSON_UNESCAPED_UNICODE
			);

	    	return $response;

		})->add($authenticationAdm);

		$app->DELETE('/api/users/{idUser}', function(Request $request, Response $response, array $args){
			//ADM	
			$appUserDAO = new AppUserDAO();
			$idUser = $args['idUser'] ?? 0;

			if(filter_var($idUser, FILTER_VALIDATE_INT)){
				
				$appUserDAO->deleteUser(intval($idUser));
				$response = $response->withStatus(204);	

			} else{
				$response->getBody()->write("Identificador inválido.");
				$response = $response->withStatus(400);
			}	   

	    	return $response;

		})->add($authenticationAdm);

		$app->GET('/api/users/check/{attribute}/{value}', function(Request $request, Response $response, array $args){
			//ADM
			$userDAO = new UserDAO();
			$appUserDAO = new AppUserDAO();
			$status = false;

			$attribute = filter_var($args['attribute'] ?? '', FILTER_SANITIZE_STRING);
			$value = filter_var($args['value'] ?? '', FILTER_SANITIZE_STRING);

			if($attribute == "cpf" || $attribute == "login" || $attribute == "email"){

				$status = $userDAO->verifyUserData($attribute, $value);	

			} else if($attribute == "platformtoken"){

				$status = $appUserDAO->verifyUserData($attribute, $value);		

			} else{
				$response->getBody()->write("Identificador inválido.");
				return $response->withStatus(400);	
			}

			if($status){
		    	$data = array(
					$attribute => $value,
					'status' => true
				);

				$response = $response->withJson(
				    	$data, 
				    	200, 
				    	JSON_UNESCAPED_UNICODE
				);
		    } else{
		    	$response->getBody()->write(ucfirst($attribute)." não cadastrado em nossa base de dados.");
				$response = $response->withStatus(404);
		    }

	    	return $response;

		})->add($authenticationAdm);

		$app->PUT('/api/users/session/{idUser}', function(Request $request, Response $response, array $args){
			//ADM
			$appUser = new AppUser();
			$appUserDAO = new AppUserDAO();

			$idUser = $args['idUser'] ?? 0;

			if(filter_var($idUser, FILTER_VALIDATE_INT)){

				try{
					$appUser->setId(intval($idUser));
					$appUser->setSession(md5(rand(99,999)));

					$editSession = $appUserDAO->editSession($appUser);

					if($editSession['status']){
						$data = array('session' => $editSession['session']);
						$status = 200;

					} else{
						$data = array(
						    'error' => 3,
						    'message' => 'Não foi possível editar a sessão.'
						);
						$status = 400;
								
					}

				} catch(Exception $e){

					$data = array(
						'error' => 2,
						'message' => $e->getMessage()
					);
					$status = 400;
				}	

			} else{
				$data = array(
					'error' => 1,
					'message' => 'Identificador inválido.'
				);
				$status = 400;
			}	

			$response = $response->withJson(
				    $data, 
				    $status, 
				    JSON_UNESCAPED_UNICODE
			);

	    	return $response;

		})->add($authenticationAdm);

		$app->PUT('/api/users/session/', function(Request $request, Response $response, array $args){

			$appUser = new AppUser();
			$appUserDAO = new AppUserDAO();

			try{
				$appUser->setId($request->getAttribute('idUser'));
				$appUser->setSession(md5(rand(99,999)));

				$editSession = $appUserDAO->editSession($appUser);

				if($editSession['status']){
					$data = array('session' => $editSession['session']);
					$status = 200;

				} else{
					$data = array(
					    'error' => 2,
					    'message' => 'Não foi possível editar a sessão.'
					);
					$status = 400;
							
				}

			} catch(Exception $e){

				$data = array(
					'error' => 1,
					'message' => $e->getMessage()
				);
				$status = 400;
			}	

			$response = $response->withJson(
				    $data, 
				    $status, 
				    JSON_UNESCAPED_UNICODE
			);

	    	return $response;

		})->add($authentication);

		$app->PUT('/api/users/platform_token/', function(Request $request, Response $response, array $args){

			$appUser = new AppUser();
			$appUserDAO = new AppUserDAO();

			try{
				$appUser->setId($request->getAttribute('idUser'));
				$appUser->setPlatformToken($request->getParam('platformToken') ?? null);

				$editPlatformToken = $appUserDAO->editPlatformToken($appUser);

				if($editPlatformToken['status']){
					$data = array('platformToken' => $editPlatformToken['platformToken']);
					$status = 200;

				} else if($editPlatformToken['error'] == 2){
					$data = array(
					    'error' => 3,
					    'message' => 'Nenhuma informação foi alterada.'
					);
					$status = 400;
							
				} else{
					$data = array(
					    'error' => 2,
					    'message' => 'Não foi possível alterar o token.'
					);
					$status = 400;
				}

			} catch(Exception $e){

				$data = array(
					'error' => 1,
					'message' => $e->getMessage()
				);
				$status = 400;
			}	

			$response = $response->withJson(
				    $data, 
				    $status, 
				    JSON_UNESCAPED_UNICODE
			);

	    	return $response;

		})->add($authentication);
		
		$app->GET('/api/vehicles/', function(Request $request, Response $response, array $args){
			
			$appVehicleDAO = new AppVehicleDAO();

			$vehicles = $appVehicleDAO->getVehicles($request->getAttribute('idUser'));
			
	    	$data = array(
	    		'vehicles' => $vehicles
	    	);
	    	
	    	$response = $response->withJson(
		      		$data, 
		      		200, 
		      		JSON_UNESCAPED_UNICODE
		    );

	    	return $response;

		})->add($authentication);

		$app->GET('/api/vehicles/{idVehicle}', function(Request $request, Response $response, array $args){

			$appVehicleDAO = new AppVehicleDAO();
			$idVehicle = $args['idVehicle'] ?? 0;

			if(filter_var($idVehicle, FILTER_VALIDATE_INT)){

				$data = $appVehicleDAO->getVehicle($request->getAttribute('idUser'), intval($idVehicle));

				if(count($data) > 0){
					$response = $response->withJson(
			      		$data, 
			      		200, 
			      		JSON_UNESCAPED_UNICODE
		    		);	
				} else{
					$response->getBody()->write("O registro do veículo não foi encontrado.");
					$response = $response->withStatus(404);	
				}

			} else{
				$response->getBody()->write("Identificador inválido.");
				$response = $response->withStatus(400);
			}
	    	
	    	return $response;

		})->add($authentication);

		$app->POST('/api/vehicles/', function(Request $request, Response $response, array $args){

			$appVehicle = new AppVehicle();
			$appVehicleDAO = new AppVehicleDAO();
			$appRegisteredDAO = new AppRegisteredDAO();

			try{
				$appVehicle->setIdUser($request->getAttribute('idUser'));
				$appVehicle->setName($request->getParam('name') ?? '');
				$appVehicle->setPhone($request->getParam('phone') ?? '');
				$appVehicle->setPassword($request->getParam('password') ?? '');
				$appVehicle->setModel($request->getParam('model') ?? '');
				$appVehicle->setCategory($request->getParam('category') ?? '');

				$appRegistered = $appRegisteredDAO->verifyPhone($appVehicle->getPhone());

				if($appRegistered['id'] > 0){

					$appVehicle->setIdRegistered($appRegistered['id']);
					$appVehicle->setImei($appRegistered['imei']);

					$addVehicle = $appVehicleDAO->addVehicle($appVehicle);

					if($addVehicle['status']){

						$data = $addVehicle['vehicle'];
						$status = 200;

					} else if($addVehicle['error'] == 2){

						$data = array(
				    		'error' => 4,
				    		'message' => 'Veículo já cadastrado em nossa base de dados.',
				    		'vehicle' => $addVehicle['vehicle']
				    	);
						$status = 400;

					} else{

						$data = array(
				    		'error' => 3,
				    		'message' => 'Erro ao cadastrar veículo.'
				    	);
						$status = 400;
					}		
				} else{

					$data = array(
				    	'error' => 2,
				    	'message' => 'Telefone não cadastrado em nossa base de dados.'
				    );
					$status = 400;
				}

			} catch(Exception $e){

				$data = array(
				    'error' => 1,
				    'message' => $e->getMessage()
				);
				$status = 400;
			}	

			$response = $response->withJson(
				    $data, 
				    $status, 
				    JSON_UNESCAPED_UNICODE
			);

	    	return $response;

		})->add($authentication);

		$app->PUT('/api/vehicles/{idVehicle}', function(Request $request, Response $response, array $args){

			$appVehicle = new AppVehicle();
			$appVehicleDAO = new AppVehicleDAO();
			$appRegisteredDAO = new AppRegisteredDAO();

			$idVehicle = $args['idVehicle'] ?? 0;

			if(filter_var($idVehicle, FILTER_VALIDATE_INT)){

				try{
					$appVehicle->setId(intval($idVehicle));
					$appVehicle->setIdUser($request->getAttribute('idUser'));
					$appVehicle->setName($request->getParam('name') ?? '');
					$appVehicle->setPhone($request->getParam('phone') ?? '');
					$appVehicle->setPassword($request->getParam('password') ?? '');
					$appVehicle->setModel($request->getParam('model') ?? '');
					$appVehicle->setCategory($request->getParam('category') ?? '');

					$appRegistered = $appRegisteredDAO->verifyPhone($appVehicle->getPhone());

					if($appRegistered['id'] > 0){

						$appVehicle->setIdRegistered($appRegistered['id']);
						$appVehicle->setImei($appRegistered['imei']);

						$editVehicle = $appVehicleDAO->editVehicle($appVehicle);

						if($editVehicle['status']){
					  
							$data = $editVehicle['vehicle'];
							$status = 200;

						} else if($editVehicle['error'] == 3){

							$data = array(
					    		'error' => 6,
					    		'message' => 'Não foi possível editar o veículo.'
					    	);
							$status = 400;

						} else if($editVehicle['error'] == 2){
							$data = array(
					    		'error' => 5,
					    		'message' => 'Veículo já cadastrado em nossa base de dados.'
					    	);
							$status = 400;

						} else{

							$data = array(
					    		'error' => 4,
					    		'message' => 'Erro ao editar veículo.'
					    	);
							$status = 400;
						}		
					} else{

						$data = array(
					    	'error' => 3,
					    	'message' => 'Telefone não cadastrado em nossa base de dados.'
					    );
						$status = 400;
					}

				} catch(Exception $e){

					$data = array(
					    'error' => 2,
					    'message' => $e->getMessage()
					);
					$status = 400;
				}

			} else{
				$data = array(
					'error' => 1,
					'message' => 'Identificador inválido.'
				);
				$status = 400;
			}	

			$response = $response->withJson(
				    $data, 
				    $status, 
				    JSON_UNESCAPED_UNICODE
			);

	    	return $response;

		})->add($authentication);

		$app->DELETE('/api/vehicles/{idVehicle}', function(Request $request, Response $response, array $args){
			
			$appVehicleDAO = new AppVehicleDAO();
			$idVehicle = $args['idVehicle'] ?? 0;

			if(filter_var($idVehicle, FILTER_VALIDATE_INT)){
				
				$appVehicleDAO->deleteVehicle($request->getAttribute('idUser'), intval($idVehicle));
				$response = $response->withStatus(204);	

			} else{
				$response->getBody()->write("Identificador inválido.");
				$response = $response->withStatus(400);
			}	   

	    	return $response;

		})->add($authentication);

		$app->GET('/api/registered/', function(Request $request, Response $response, array $args){
			//ADM
			$appRegisteredDAO = new AppRegisteredDAO();	

			$data['registered'] = $appRegisteredDAO->getAllRegistered();
	    	
	    	$response = $response->withJson(
		      		$data, 
		      		200, 
		      		JSON_UNESCAPED_UNICODE
		    );

	    	return $response;

		})->add($authenticationAdm);

		$app->GET('/api/registered/{idRegistered}', function(Request $request, Response $response, array $args){
			//ADM
			$appRegisteredDAO = new AppRegisteredDAO();
			$idRegistered = $args['idRegistered'] ?? 0;	

		    if(filter_var($idRegistered, FILTER_VALIDATE_INT)){

				$data = $appRegisteredDAO->getRegistered(intval($idRegistered));
	    	
		    	$response = $response->withJson(
			      		$data, 
			      		200, 
			      		JSON_UNESCAPED_UNICODE
			    );	

			} else{
				$response->getBody()->write("Identificador inválido.");
				$response = $response->withStatus(400);
			}

	    	return $response;

		})->add($authenticationAdm);

		$app->POST('/api/registered/', function(Request $request, Response $response, array $args){
			//ADM
			$appRegistered = new AppRegistered();
			$appRegisteredDAO = new AppRegisteredDAO();

			try{
				$appRegistered->setPhone($request->getParam('phone') ?? '');
				$appRegistered->setImei($request->getParam('imei') ?? '');

				$addRegistered = $appRegisteredDAO->addRegistered($appRegistered);

				if($addRegistered['status']){
					$data = $addRegistered['registered'];
					$status = 200;

				} else if($addRegistered['error'] == 1){
					$data = array(
				    	'error' => 4,
				    	'message' => 'Telefone já cadastrado em nossa base de dados.'
				    );
					$status = 400;	

				} else if($addRegistered['error'] == 2){
					$data = array(
				    	'error' => 3,
				    	'message' => 'Imei já cadastrado em nossa base de dados.'
				    );
					$status = 400;	

				} else{
					$data = array(
				    	'error' => 2,
				    	'message' => 'Erro ao cadastrar registro.'
				    );
					$status = 400;	
				}

			} catch(Exception $e){

				$data = array(
				    'error' => 1,
				    'message' => $e->getMessage()
				);
				$status = 400;
			}	

			$response = $response->withJson(
				    $data, 
				    $status, 
				    JSON_UNESCAPED_UNICODE
			);

	    	return $response;

		})->add($authenticationAdm);

		$app->PUT('/api/registered/{idRegistered}', function(Request $request, Response $response, array $args){
			//ADM
			$appRegistered = new AppRegistered();
			$appRegisteredDAO = new AppRegisteredDAO();

			$idRegistered = $args['idRegistered'] ?? 0;

			if(filter_var($idRegistered, FILTER_VALIDATE_INT)){

				try{
					$appRegistered->setId(intval($idRegistered));
					$appRegistered->setPhone($request->getParam('phone') ?? '');
					$appRegistered->setImei($request->getParam('imei') ?? '');

					$editRegistered = $appRegisteredDAO->editRegistered($appRegistered);

					if($editRegistered['status']){
						$data = $editRegistered['registered'];
						$status = 200;

					} else if($editRegistered['error'] == 1){
						$data = array(
					    	'error' => 5,
					    	'message' => 'Telefone já cadastrado em nossa base de dados.'
					    );
						$status = 400;
							
					} else if($editRegistered['error'] == 2){
						$data = array(
					    	'error' => 4,
					    	'message' => 'Imei já cadastrado em nossa base de dados.'
					    );
						$status = 400;
							
					} else{
						$data = array(
					    	'error' => 3,
					    	'message' => 'Erro ao editar registro.'
					    );
						$status = 400;
					}

				} catch(Exception $e){

					$data = array(
					    'error' => 2,
					    'message' => $e->getMessage()
					);
					$status = 400;
				}

			} else{
				$data = array(
					'error' => 1,
					'message' => 'Identificador inválido.'
				);
				$status = 400;
			}	

			$response = $response->withJson(
				    $data, 
				    $status, 
				    JSON_UNESCAPED_UNICODE
			);

	    	return $response;

		})->add($authenticationAdm);

		$app->DELETE('/api/registered/{idRegistered}', function(Request $request, Response $response, array $args){
			//ADM	
			$appRegisteredDAO = new AppRegisteredDAO();
			$idRegistered = $args['idRegistered'] ?? 0;

			if(filter_var($idRegistered, FILTER_VALIDATE_INT)){
				
				$deleteRegistered = $appRegisteredDAO->deleteRegistered(intval($idRegistered));

				if(!$deleteRegistered['error'] == 1){				
					$response = $response->withStatus(204);
					return $response;

				} else{
					$data = array(
						'error' => 2,
						'message' => 'Registro não pode ser excluído, pois encontra-se vinculado a um veículo.'
					);
					$status = 400;
				}

			} else{
				$data = array(
					'error' => 1,
					'message' => 'Identificador inválido.'
				);
				$status = 400;
			}

			$response = $response->withJson(
				    $data, 
				    $status, 
				    JSON_UNESCAPED_UNICODE
			);	   

	    	return $response;

		})->add($authenticationAdm);
		
		$app->GET('/api/app_version/', function(Request $request, Response $response, array $args){

	      	$data = array(
	    		'version' => '1.9'
	    	);

	    	$response = $response->withJson(
		      		$data, 
		      		200, 
		      		JSON_UNESCAPED_UNICODE
		    );

	    	return $response;
		});

		$app->GET('/api/check_phone/{phone}', function(Request $request, Response $response, array $args){

			$appRegisteredDAO = new AppRegisteredDAO();
			$phone = filter_var($args['phone'] ?? '', FILTER_SANITIZE_STRING);

			if(strlen($phone) > 9){

				if($appRegisteredDAO->checkPhone($phone)){
					
					$data = array(
						'phone'=> $phone,
						'status'=> true
					);

					$response = $response->withJson(
				    		$data, 
				    		200, 
				    		JSON_UNESCAPED_UNICODE
					);

				} else{
					$response = $response->withStatus(404);
					$response->getBody()->write("Telefone não cadastrado em nossa base de dados.");
				}
				
			} else{
				$response->getBody()->write("Telefone inválido.");
				$response = $response->withStatus(400);	
			}
	    	
	    	return $response;

		})->add($checkPhone);

		$app->run();
	}
}