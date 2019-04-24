<?php
namespace DAO;

use PDO;
use PDOException;
use Models\User;

class UserDAO {

	private $db;

	public function __construct(){
		$dataBase = new ConnectionDB();
		$this->db = $dataBase->connect('rsm');
	}

	public function addUser(User $user): bool {
		$status = false;

		// Criptografar Senha
		$user->setPassword(password_hash($user->getPassword(), PASSWORD_BCRYPT));
		//-----------------------------------------------------------------------
		
		try{
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
						`serviceterms` = :serviceTerms;";

			$query = $this->db->prepare($query);
			$query->bindValue(":name", $user->getName());
			$query->bindValue(":dateBirth", $user->getDateBirth());
			$query->bindValue(":cpf", $user->getCpf());
			$query->bindValue(":email", $user->getEmail());
			$query->bindValue(":login", $user->getLogin());
			$query->bindValue(":password", $user->getPassword());
			$query->bindValue(":cellPhone", $user->getCellPhone());
			$query->bindValue(":phone", $user->getPhone());
			$query->bindValue(":zipCode", $user->getZipCode());
			$query->bindValue(":state", $user->getState());
			$query->bindValue(":city", $user->getCity());
			$query->bindValue(":neighborhood", $user->getNeighborhood());
			$query->bindValue(":address", $user->getAddress());
			$query->bindValue(":addressNumber", $user->getAddressNumber());
			$query->bindValue(":complement", $user->getComplement());
			$query->bindValue(":serviceTerms", $user->getServiceTerms());
			$query->execute();

			if($query->rowCount() > 0){
				$status = true;
			}

		} catch(PDOException $e){
			echo "ERROR: ".$e->getMessage();
		}
		return $status;
	}

	public function editUser(User $user): bool {
		$status = false;

		try{
			$query = "UPDATE `users` SET 
						`name` = :name, 
						`datebirth` = :dateBirth, 
						`cpf` = :cpf, 
						`email` = :email,
						`login` = :login, 
						`cellphone` = :cellPhone, 
						`phone` = :phone, 
						`zipcode` = :zipCode, 
						`state` = :state, 
						`city` = :city, 
						`neighborhood` = :neighborhood, 
						`address` = :address, 
						`addressnumber` = :addressNumber, 
						`complement` = :complement 
						WHERE `id` = :id;";

			$query = $this->db->prepare($query);
			$query->bindValue(":id", $user->getId());
			$query->bindValue(":name", $user->getName());
			$query->bindValue(":dateBirth", $user->getDateBirth());
			$query->bindValue(":cpf", $user->getCpf());
			$query->bindValue(":email", $user->getEmail());
			$query->bindValue(":login", $user->getLogin());
			$query->bindValue(":cellPhone", $user->getCellPhone());
			$query->bindValue(":phone", $user->getPhone());
			$query->bindValue(":zipCode", $user->getZipCode());
			$query->bindValue(":state", $user->getState());
			$query->bindValue(":city", $user->getCity());
			$query->bindValue(":neighborhood", $user->getNeighborhood());
			$query->bindValue(":address", $user->getAddress());
			$query->bindValue(":addressNumber", $user->getAddressNumber());
			$query->bindValue(":complement", $user->getComplement());
			$query->execute();

			if($query->rowCount() > 0){
				$status = true;
			}

		} catch(PDOException $e){
			echo "ERROR: ".$e->getMessage();
		}
		return $status;
	}

	public function getUser(int $idUser): User {
		$user = new User();

		try{
			$query = "SELECT * FROM `users` WHERE `id` = :id;";
			$query = $this->db->prepare($query);
			$query->bindValue(":id", $idUser);
			$query->execute();

			if($query->rowCount() > 0){
				$user = new User($query->fetch(PDO::FETCH_ASSOC));
			}

		} catch(PDOException $e){
			echo "ERROR: ".$e->getMessage();
		}	
		return $user;
	}

	public function editPassword(int $idUser, string $password): bool {
		$status = false;

		// Criptografar Senha
		$password = password_hash($password, PASSWORD_BCRYPT);
		//----------------------------------------------------

		try{
			// Query para editar a senha
			$query = "UPDATE `users` SET `password` = :password WHERE `id` = :id;";
			//---------------------------------------------------------------------
			
			// Query para recuperar a senha
			if(!empty($_SESSION['recoverPass']['session'])){
				$query = "UPDATE users INNER JOIN tokens 
							ON users.id = tokens.iduser 
							SET users.password = :password, tokens.status = 0 
							WHERE users.id = :id AND tokens.type = 2 AND tokens.status = 1;";
			}
			//-------------------------------------------------------------------------------

			$query = $this->db->prepare($query);
			$query->bindValue(":id", $idUser);
			$query->bindValue(":password", $password);
			$query->execute();

			if($query->rowCount() > 0){
				$status = true;		
			}

		} catch(PDOException $e){
			echo "ERROR: ".$e->getMessage();
		}
		return $status;
	}

	public function verifyPassword(int $idUser, string $password): bool {
		$status = false;

		try{
			$query = "SELECT `password` FROM `users` WHERE `id` = :id;";
			$query = $this->db->prepare($query);
			$query->bindValue(":id", $idUser);
			$query->execute();

			if($query->rowCount() > 0){
				$user = $query->fetch(PDO::FETCH_ASSOC);
				if(password_verify($password, $user['password'])){
					$status = true;
				}	
			}

		} catch(PDOException $e){
			echo "ERROR: ".$e->getMessage();
		}
		return $status;
	}

	public function activateUser(string $token): bool {
		$status = false;

		try{
			$query = "UPDATE users INNER JOIN tokens 
						ON users.id = tokens.iduser 
					 	SET users.status = 1, tokens.status = 0 
					 	WHERE tokens.token = :token AND tokens.type = 1 AND tokens.status = 1;";

			$query = $this->db->prepare($query);
			$query->bindValue(":token", $token);
			$query->execute();

			if($query->rowCount() > 0){
				$status = true;
			}			 	

		} catch(PDOException $e){
			echo "ERROR: ".$e->getMessage();
		}
		return $status;
	}

	public function userAltentification(string $login, string $password): array {
		$status = array('status' => false, 'error' => 1);

 		try{
 			$query = "SELECT user_platform.idplatform, users.* 
 						FROM users LEFT JOIN user_platform 
 						ON users.id = user_platform.iduser 
 						WHERE users.login = :login;";

 			$query = $this->db->prepare($query);
 			$query->bindValue(":login", $login);
 			$query->execute();

 			if($query->rowCount() > 0){

 				$user = $query->fetch(PDO::FETCH_ASSOC);

 				if(password_verify($password, $user['password'])){

 					if($user['status']){
 						session_destroy();
						unset($_SESSION);
						session_start();	
									
						$user['password'] = null;	
						$_SESSION['user']['data'] = serialize(new User($user));
						$_SESSION['user']['session'] = true;

 						$status['status'] = true;
 						$status['email'] = $user['email'];
 						$status['error'] = 0;
 					} else{
 						$status['error'] = 2;
 					}
 				} 
 			}

 		} catch(PDOException $e){
			echo "ERROR: ".$e->getMessage();
		}
		return $status;
	}

	public function addTokenPassword(string $emailLogin, string $token): array {
		$resposta = array('status' => false, 'error' => 1);

		try{
			//Iniciar Transação
			$this->db->beginTransaction();

			$query = "SELECT * FROM `users` WHERE (`email` = :emailLogin OR `login` = :emailLogin) AND (`status` = 1);";
			$query = $this->db->prepare($query);
			$query->bindValue("emailLogin", $emailLogin);
			$query->execute();

			if($query->rowCount() > 0){

				$user = $query->fetch(PDO::FETCH_ASSOC);

				$query = "SELECT * FROM `tokens` WHERE `iduser` = :idUser AND `type` = 2 AND date(`date`) = date(NOW());";
				$query = $this->db->prepare($query);
				$query->bindValue("idUser", $user['id']);
				$query->execute();

				if($query->rowCount() < 5){
					$query = "INSERT INTO `tokens` SET `iduser` = :idUser, `type` = 2, `token` = :token;";
					$query = $this->db->prepare($query);
					$query->bindValue("idUser", $user['id']);
					$query->bindValue("token", $token);
					$query->execute();

					if($query->rowCount() > 0){
						$firstName = explode(' ', $user['name']);
						$_SESSION['recoverPass']['user']['name'] = $user['name'];
						$_SESSION['recoverPass']['user']['firstName'] = array_shift($firstName);
						$resposta['email'] = $user['email'];
						$resposta['status'] = true;
						$resposta['error'] = 0;
					}

				} else{
					$resposta['error'] = 2;
				}
			}

			// Finalizar Transação	
			$this->db->commit();

		} catch(PDOException $e){
			// Cancelar Transação
			$this->db->rollBack();
			echo "ERROR: ".$e->getMessage();
		}
		return $resposta;
	}

	public function verifyTokenPassword(string $token): bool {
		$status = false;

		try{
			$query = "SELECT users.id, users.name 
						FROM users INNER JOIN tokens 
						ON users.id = tokens.iduser 
						WHERE tokens.token = :token AND tokens.type = 2 AND tokens.status = 1;";

			$query = $this->db->prepare($query);
			$query->bindValue("token", $token);
			$query->execute();	

			if($query->rowCount() > 0){
				$user = $query->fetch(PDO::FETCH_ASSOC);

				$firstName = explode(' ', $user['name']);
				$_SESSION['recoverPass']['user']['id'] = $user['id'];
				$_SESSION['recoverPass']['user']['firstName'] = array_shift($firstName);
				$_SESSION['recoverPass']['token'] = $token;

				$status = true;
			}

		} catch(PDOException $e){
			echo "ERROR: ".$e->getMessage();
		}
		return $status;
	}

	public function verifyUserData(string $attribute, string $value): bool {
		$status = false;

		try{
			$query = "SELECT `$attribute` FROM `users` WHERE `$attribute` = :value;";
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