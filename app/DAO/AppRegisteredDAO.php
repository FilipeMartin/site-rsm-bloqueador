<?php
namespace DAO;

use PDO;
use PDOException;
use Models\AppRegistered;

class AppRegisteredDAO {

	private $db;

	public function __construct(){
		$dataBase = new ConnectionDB();
		$this->db = $dataBase->connect('rsm');
	}

	public function addRegistered(AppRegistered $appRegistered): array {
		$response = array('status' => false);

		try{
			//Iniciar Transação
			$this->db->beginTransaction();

			$query = "SELECT `phone` FROM `app_registered` 
						WHERE `phone` = :phone;";

			$query = $this->db->prepare($query);
			$query->bindValue(":phone", $appRegistered->getPhone());
			$query->execute();

			if($query->rowCount() > 0){
				$response['error'] = 1;
				return $response;	
			}

			$query = "SELECT `imei` FROM `app_registered` 
						WHERE `imei` = :imei;";

			$query = $this->db->prepare($query);
			$query->bindValue(":imei", $appRegistered->getImei());
			$query->execute();

			if($query->rowCount() > 0){
				$response['error'] = 2;
				return $response;	
			}		

			$query = "INSERT INTO `app_registered` 
						SET `phone` = :phone, 
						`imei` = :imei;";

			$query = $this->db->prepare($query);	
			$query->bindValue(":phone", $appRegistered->getPhone());
			$query->bindValue(":imei", $appRegistered->getImei());
			$query->execute();

			if($query->rowCount() > 0){
				$appRegistered->setId($this->db->lastInsertId());
				$response['registered'] = $appRegistered->getRegisteredArray();
				$response['status'] = true;
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

	public function getRegistered(int $id): array {
		$registered = array();

		try{
			$query = "SELECT * FROM `app_registered` 
						WHERE `id` = :id;";

			$query = $this->db->prepare($query);
			$query->bindValue(":id", $id);
			$query->execute();

			if($query->rowCount() > 0){
				$registered = $query->fetch(PDO::FETCH_ASSOC);
			}

		} catch(PDOException $e){
			echo "ERROR: ".$e->getMessage();
		}
		return $registered;
	}

	public function getAllRegistered(): array {
		$registered = array();

		try{
			$query = "SELECT * FROM `app_registered` ORDER BY `id` DESC;";
			$query = $this->db->prepare($query);
			$query->execute();

			if($query->rowCount() > 0){
				$registered = $query->fetchAll(PDO::FETCH_ASSOC);
			}

		} catch(PDOException $e){
			echo "ERROR: ".$e->getMessage();
		}
		return $registered;
	}

	public function editRegistered(AppRegistered $appRegistered): array {
		$response = array('status' => false);

		try{
			//Iniciar Transação
			$this->db->beginTransaction();

			$query = "SELECT `phone` FROM `app_registered` 
						WHERE `id` != :id AND `phone` = :phone;";

			$query = $this->db->prepare($query);
			$query->bindValue(":id", $appRegistered->getId());
			$query->bindValue(":phone", $appRegistered->getPhone());
			$query->execute();

			if($query->rowCount() > 0){
				$response['error'] = 1;
				return $response;	
			}

			$query = "SELECT `imei` FROM `app_registered` 
						WHERE `id` != :id AND `imei` = :imei;";

			$query = $this->db->prepare($query);
			$query->bindValue(":id", $appRegistered->getId());
			$query->bindValue(":imei", $appRegistered->getImei());
			$query->execute();

			if($query->rowCount() > 0){
				$response['error'] = 2;
				return $response;	
			}

			$query = "UPDATE `app_registered` 
						SET `phone` = :phone, 
						`imei` = :imei 
						WHERE `id` = :id;";

			$query = $this->db->prepare($query);
			$query->bindValue(":id", $appRegistered->getId());	
			$query->bindValue(":phone", $appRegistered->getPhone());	
			$query->bindValue(":imei", $appRegistered->getImei());		
			$query->execute();

			if($query->rowCount() > 0){
				$response['registered'] = $appRegistered->getRegisteredArray();
				$response['status'] = true;
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

	public function deleteRegistered(int $id): array {
		$status = array('status' => false);

		try{
			$query = "SELECT * FROM `app_vehicles` 
						WHERE `idregistered` = :id;";

			$query = $this->db->prepare($query);
			$query->bindValue(":id", $id);
			$query->execute();

			if($query->rowCount() == 0){

				$query = "DELETE FROM `app_registered` 
							WHERE `id` = :id;";

				$query = $this->db->prepare($query);
				$query->bindValue(":id", $id);
				$query->execute();

				if($query->rowCount() > 0){	
					$status['status'] = true;
				}

			} else{
				$status['error'] = 1;	
			}			

		} catch(PDOException $e){
			echo "ERROR: ".$e->getMessage();
		}
		return $status;
	}

	public function verifyPhone(string $phone): array {
		$appRegistered = array('id' => 0);

		try{
			$query = "SELECT * FROM `app_registered` WHERE `phone` = :phone;";
			$query = $this->db->prepare($query);
			$query->bindValue(":phone", $phone);
			$query->execute();

			if($query->rowCount() > 0){
				$appRegistered = $query->fetch(PDO::FETCH_ASSOC);
			}

		} catch(PDOException $e){
			echo "ERROR: ".$e->getMessage();
		}
		return $appRegistered;
	}

	public function checkPhone(string $phone): bool {
		$status = false;

		try{
			$query = "SELECT * FROM `app_registered` WHERE `phone` = :phone;";
			$query = $this->db->prepare($query);
			$query->bindValue(":phone", $phone);
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