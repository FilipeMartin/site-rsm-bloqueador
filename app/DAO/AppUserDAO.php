<?php
namespace DAO;

use PDO;
use PDOException;
use Models\AppUser;

class AppUserDAO {

	private $db;

	public function __construct(){
		$dataBase = new ConnectionDB();
		$this->db = $dataBase->connect('rsm');
	}

	public function addUser(AppUser $appUser): array {
		$response = array('status' => false);

		// Criptografar Senha
		$appUser->setPassword(password_hash($appUser->getPassword(), PASSWORD_BCRYPT));
		//-----------------------------------------------------------------------------

		try{
			//Iniciar Transação
			$this->db->beginTransaction();

			$query = "INSERT INTO `users` SET 
						`name` = :name, 
						`datebirth` = :dateBirth, 
						`cpf` = :cpf, 
						`email` = :email, 
						`login` = :login, 
						`password` = :password, 
						`cellphone` = :cellPhone, 
						`phone` = :phone, 
						`zipcode` = :zipCode, 
						`state` = :state, 
						`city` = :city, 
						`neighborhood` = :neighborhood, 
						`address` = :address, 
						`addressnumber` = :addressNumber, 
						`complement` = :complement, 
						`serviceterms` = :serviceTerms,
						`expirationtime` = :expirationTime,
						`admin` = :admin,
						`status` = :status;";

			$query = $this->db->prepare($query);
			$query->bindValue(":name", $appUser->getName());
			$query->bindValue(":dateBirth", $appUser->getDateBirth());
			$query->bindValue(":cpf", $appUser->getCpf());
			$query->bindValue(":email", $appUser->getEmail());
			$query->bindValue(":login", $appUser->getLogin());
			$query->bindValue(":password", $appUser->getPassword());
			$query->bindValue(":cellPhone", $appUser->getCellPhone());
			$query->bindValue(":phone", $appUser->getPhone());
			$query->bindValue(":zipCode", $appUser->getZipCode());
			$query->bindValue(":state", $appUser->getState());
			$query->bindValue(":city", $appUser->getCity());
			$query->bindValue(":neighborhood", $appUser->getNeighborhood());
			$query->bindValue(":address", $appUser->getAddress());
			$query->bindValue(":addressNumber", $appUser->getAddressNumber());
			$query->bindValue(":complement", $appUser->getComplement());
			$query->bindValue(":serviceTerms", $appUser->getServiceTerms());
			$query->bindValue(":expirationTime", $appUser->getExpirationTime());
			$query->bindValue(":admin", $appUser->getAdmin());
			$query->bindValue(":status", $appUser->getStatus());
			$query->execute();

			if($query->rowCount() > 0){

				$appUser->setId($this->db->lastInsertId());
				$appUser->setLastUpdate(time());
				$appUser->setToken(md5($appUser->getEmail().$appUser->getCpf().rand(99,999)));	
				$appUser->setSession(md5(rand(99,999)));

				$query = "INSERT INTO `app_users` SET 
							`iduser` = :idUser, 
							`lastupdate` = :lastUpdate, 
							`token` = :token, 
							`session` = :session, 
							`platformtoken` = :platformToken;";

				$query = $this->db->prepare($query);
				$query->bindValue(":idUser", $appUser->getId());
				$query->bindValue(":lastUpdate", $appUser->getLastUpdate());
				$query->bindValue(":token", $appUser->getToken());
				$query->bindValue(":session", $appUser->getSession());
				$query->bindValue(":platformToken", $appUser->getPlatformToken());
				$query->execute();

				if($query->rowCount() > 0){
					$response['user'] = $appUser->getUserArray();
					$response['user']['password'] = null;
					$response['user']['date'] = date('Y-m-d H:i:s');
					$response['status'] = true;
				}
			}			

			// Finalizar Transação
			$this->db->commit();

		} catch(PDOException $e){
			// Cancelar Transação
			$this->db->rollBack();
			echo "ERROR: ".$e->getMessage();
		}
		return $response;
	}

	public function getUser(int $idUser): array {
		$user = array();

		try{
			$query = "SELECT users.*, app_users.lastupdate, app_users.token, app_users.session, app_users.platformtoken 
						FROM app_users INNER JOIN users 
						ON app_users.iduser = users.id 
						WHERE app_users.iduser = :idUser;";

			$query = $this->db->prepare($query);
			$query->bindValue(":idUser", $idUser);
			$query->execute();

			if($query->rowCount() > 0){
				$user = $query->fetch(PDO::FETCH_ASSOC);
				$user['password'] = null;
			}

		} catch(PDOException $e){
			echo "ERROR: ".$e->getMessage();
		}
		return $user;
	}

	public function getAllUsers(): array {
		$users = array();

		try{
			$query = "SELECT users.*, app_users.lastupdate, app_users.token, app_users.session, app_users.platformtoken  
						FROM app_users INNER JOIN users 
						ON app_users.iduser = users.id
						ORDER BY app_users.iduser DESC;";

			$query = $this->db->prepare($query);
			$query->execute();

			if($query->rowCount() > 0){
				$users = $query->fetchAll(PDO::FETCH_ASSOC);

				foreach($users as $key => $user){
					$users[$key]['password'] = null;
				}

			}

		} catch(PDOException $e){
			echo "ERROR: ".$e->getMessage();
		}
		return $users;
	}

	public function editUser(AppUser $appUser): array {
		$response = array('status' => false, 'error' => 1);

		// Criptografar Senha
		if(!empty($appUser->getPassword())){
			$appUser->setPassword(password_hash($appUser->getPassword(), PASSWORD_BCRYPT));
			$appUser->setSession(md5(rand(99,999)));
		}
		//---------------------------------------------------------------------------------

		try{
			//Iniciar Transação
			$this->db->beginTransaction();

			$query = "UPDATE users INNER JOIN app_users
						ON users.id = app_users.iduser
						SET users.name = :name, 
						users.cpf = :cpf, 
						users.email = :email, 
						users.cellphone = :cellPhone, 
						users.login = :login,  
						users.expirationtime = :expirationTime,
						users.admin = :admin,
						users.status = :status,   
						app_users.platformtoken = :platformToken";

			if(!empty($appUser->getPassword())){
				$query .= ", users.password = :password";
				$query .= ", app_users.session = :session";
			}		

			$query .= " WHERE users.id = :id;";			

			$query = $this->db->prepare($query);
			$query->bindValue(":id", $appUser->getId());
			$query->bindValue(":name", $appUser->getName());
			$query->bindValue(":cpf", $appUser->getCpf());
			$query->bindValue(":email", $appUser->getEmail());
			$query->bindValue(":cellPhone", $appUser->getCellPhone());
			$query->bindValue(":login", $appUser->getLogin());
			$query->bindValue(":expirationTime", $appUser->getExpirationTime());
			$query->bindValue(":admin", $appUser->getAdmin());
			$query->bindValue(":status", $appUser->getStatus());
			$query->bindValue(":platformToken", $appUser->getPlatformToken());

			if(!empty($appUser->getPassword())){
				$query->bindValue(":password", $appUser->getPassword());
				$query->bindValue(":session", $appUser->getSession());
			}

			$query->execute();

			if($query->rowCount() > 0){

				// LastUpdate
				$appUser->setLastUpdate(time());
				//------------------------------

				$query = "UPDATE `app_users` SET 
							`lastupdate` = :lastUpdate 
							WHERE `iduser` = :idUser;";	

				$query = $this->db->prepare($query);
				$query->bindValue(":idUser", $appUser->getId());
				$query->bindValue(":lastUpdate", $appUser->getLastUpdate());
				$query->execute();	

				if($query->rowCount() > 0){
					$response['user'] = $appUser->getUserArray();
					$response['user']['password'] = null;
					$response['error'] = 0;
					$response['status'] = true;
				}

			} else{
				$response['error'] = 2;
			}

			// Finalizar Transação
			$this->db->commit();

		} catch(PDOException $e){
			// Cancelar Transação
			$this->db->rollBack();
			echo "ERROR: ".$e->getMessage();
		}
		return $response;
	}

	public function deleteUser(int $idUser): bool {
		$status = false;

		try{
			//Iniciar Transação
			$this->db->beginTransaction();

			$query = "DELETE FROM `app_vehicles` 
						WHERE `iduser` = :idUser;";

			$query = $this->db->prepare($query);
			$query->bindValue(":idUser", $idUser);	
			$query->execute();

			$query = "DELETE FROM `app_users` 
						WHERE `iduser` = :idUser;";

			$query = $this->db->prepare($query);
			$query->bindValue(":idUser", $idUser);	
			$query->execute();

			$query = "DELETE FROM `users` 
						WHERE `id` = :idUser;";

			$query = $this->db->prepare($query);
			$query->bindValue(":idUser", $idUser);	
			$query->execute();

			if($query->rowCount() > 0){
				$status = true;
			}

			// Finalizar Transação
			$this->db->commit();

		} catch(PDOException $e){
			// Cancelar Transação
			$this->db->rollBack();
			echo "ERROR: ".$e->getMessage();
		}
		return $status;
	}

	public function editSession(AppUser $appUser): array {
		$response = array('status' => false);

		try{
			$query = "UPDATE `app_users` 
						SET `session` = :session 
						WHERE `iduser` = :idUser;";

			$query = $this->db->prepare($query);
			$query->bindValue(":idUser", $appUser->getId());
			$query->bindValue(":session",  $appUser->getSession());	
			$query->execute();

			if($query->rowCount() > 0){
				$response['session'] = $appUser->getSession();
				$response['status'] = true;
			}			

		} catch(PDOException $e){
			echo "ERROR: ".$e->getMessage();
		}
		return $response;
	}

	public function editPlatformToken(AppUser $appUser): array {
		$response = array('status' => false, 'error' => 1);

		try{
			//Iniciar Transação
			$this->db->beginTransaction();

			$status = true;
			if(!empty($appUser->getPlatformToken())){
				$query = "SELECT `iduser` FROM `app_users` 
							WHERE `platformtoken` = :platformToken;"; 

				$query = $this->db->prepare($query);
				$query->bindValue(":platformToken", $appUser->getPlatformToken());	
				$query->execute();

				if($query->rowCount() > 0){
					$user = $query->fetch(PDO::FETCH_ASSOC);

					if($user['iduser'] == $appUser->getId()){
						$response['error'] = 2;	
					}
					$status = false;
				}
				
			} else{
				$response['error'] = 2;	
			}

			if($status){
				$query = "UPDATE `app_users` 
							SET `platformtoken` = :platformToken 
							WHERE `iduser` = :idUser;";

				$query = $this->db->prepare($query);
				$query->bindValue(":idUser", $appUser->getId());
				$query->bindValue(":platformToken", $appUser->getPlatformToken());	
				$query->execute();

				if($query->rowCount() > 0){

					// LastUpdate
					$appUser->setLastUpdate(time());
					//------------------------------

					$query = "UPDATE `app_users` 
								SET `lastupdate` = :lastUpdate 
								WHERE `iduser` = :idUser;";	

					$query = $this->db->prepare($query);
					$query->bindValue(":idUser", $appUser->getId());
					$query->bindValue(":lastUpdate", $appUser->getLastUpdate());
					$query->execute();	

					if($query->rowCount() > 0){
						$response['platformToken'] = $appUser->getPlatformToken();
						$response['error'] = 0;
						$response['status'] = true;
					}
				}
			}			

			// Finalizar Transação
			$this->db->commit();		

		} catch(PDOException $e){
			// Cancelar Transação
			$this->db->rollBack();
			echo "ERROR: ".$e->getMessage();
		}
		return $response;
	}

	public function authentication(string $login, string $password): array {
		$response = array('status' => false, 'error' => 1);

		try{
			$query = "SELECT app_users.token, users.password, users.expirationtime, users.admin, users.status
						FROM app_users INNER JOIN users 
						ON app_users.iduser = users.id 
						WHERE users.login = :login;";

			$query = $this->db->prepare($query);
			$query->bindValue(":login", $login);
			$query->execute();

			if($query->rowCount() > 0){

				$appUser = $query->fetch(PDO::FETCH_ASSOC);

				if(password_verify($password, $appUser['password'])){

					if($appUser['status']){

						if(date('Y-m-d', strtotime($appUser['expirationtime'])) > date('Y-m-d')){
							$response['admin'] = $appUser['admin'];
							$response['token'] = $appUser['token'];
							$response['error'] = 0;
							$response['status'] = true;	

						} else{
							$response['error'] = 3;
						}

					} else{
						$response['error'] = 2;
					}
				}  
			}		

		} catch(PDOException $e){
			echo "ERROR: ".$e->getMessage();
		}
		return $response;
	}

	public function verifyToken(string $login, string $token): array {
		$response = array('status' => false);

		try{
			if($login == "rsm"){

				$query = "SELECT app_users.iduser, users.admin 
							FROM app_users INNER JOIN users 
							ON app_users.iduser = users.id
							WHERE app_users.token = :token AND date(users.expirationtime) > date(NOW()) AND users.status = 1;";

				$query = $this->db->prepare($query);
				$query->bindValue(":token", $token);
				$query->execute();

				if($query->rowCount() > 0){
					$user = $query->fetch(PDO::FETCH_ASSOC);
					$response['idUser'] = $user['iduser'];
					$response['admin'] = $user['admin'];
					$response['status'] = true;
				}
			}			

		} catch(PDOException $e){
			echo "ERROR: ".$e->getMessage();
		}	
		return $response;
	}

	public function check(int $idUser): array {
		$check = array();
		
		try{
			$query = "SELECT `lastupdate`, `session` FROM `app_users` 
						WHERE `iduser` = :idUser;";

			$query = $this->db->prepare($query);
			$query->bindValue(":idUser", $idUser);
			$query->execute();

			if($query->rowCount() > 0){
				$check = $query->fetch(PDO::FETCH_ASSOC);
			}

		} catch(PDOException $e){
			echo "ERROR: ".$e->getMessage();
		}
		return $check;
	}

	public function verifyUserData(string $attribute, string $value): bool {
		$status = false;

		try{
			$query = "SELECT `$attribute` FROM `app_users` WHERE `$attribute` = :value;";
			$query = $this->db->prepare($query);
			$query->bindValue(":value", $value);
			$query->execute();	

			if($query->rowCount() > 0){
				$status = true;
			}

		} catch(PDOException $e){
			echo "ERROR: ".$e->getMessage();
		}
		return $status;
	}
}