<?php
namespace DAO;

use PDO;
use PDOException;
use Models\AppVehicle;

class AppVehicleDAO {

	private $db;

	public function __construct(){
		$dataBase = new ConnectionDB();
		$this->db = $dataBase->connect('rsm');
	}

	public function addVehicle(AppVehicle $appVehicle): array {
		$response = array('status' => false, 'error' => 1);

		try{
			//Iniciar Transação
			$this->db->beginTransaction();

			$query = "SELECT * FROM `app_vehicles` 
						WHERE iduser = :idUser AND `idregistered` = :idRegistered;";

			$query = $this->db->prepare($query);
			$query->bindValue(":idUser", $appVehicle->getIdUser());
			$query->bindValue(":idRegistered", $appVehicle->getIdRegistered());
			$query->execute();

			if($query->rowCount() == 0){

				$query = "INSERT INTO `app_vehicles` SET 
							`iduser` = :idUser, 
							`idregistered` = :idRegistered, 
							`name` = :name, 
							`password` = :password, 
							`model` = :model, 
							`category` = :category;";

				$query = $this->db->prepare($query);
				$query->bindValue(":idUser", $appVehicle->getIdUser());
				$query->bindValue(":idRegistered", $appVehicle->getIdRegistered());
				$query->bindValue(":name", $appVehicle->getName());
				$query->bindValue(":password", $appVehicle->getPassword());
				$query->bindValue(":model", $appVehicle->getModel());
				$query->bindValue(":category", $appVehicle->getCategory());
				$query->execute();	

				if($query->rowCount() > 0){

					// ID do veículo
					$idVehicle = $this->db->lastInsertId();
					//-------------------------------------

					// LastUpdate
					$lastUpdate = time();
					//-------------------

					$query = "UPDATE `app_users` SET 
								`lastupdate` = :lastUpdate 
								WHERE `iduser` = :idUser;";	

					$query = $this->db->prepare($query);

					$query->bindValue(":idUser", $appVehicle->getIdUser());
					$query->bindValue(":lastUpdate", $lastUpdate);
					$query->execute();	

					if($query->rowCount() > 0){
						
						$response['vehicle'] = array(
							'id' => $idVehicle,
							'imei' => $appVehicle->getImei(),
							'name' => $appVehicle->getName(),
							'phone' => $appVehicle->getPhone(),
							'password' => $appVehicle->getPassword(),
							'model' => $appVehicle->getModel(),
							'category' => $appVehicle->getCategory(),
							'date' => date('Y-m-d H:i:s'),
							'status' => "1"
						);

						$response['error'] = 0;
						$response['status'] = true;
					}		
				}

			} else{
				$vehicle = $query->fetch(PDO::FETCH_ASSOC);

				$response['vehicle'] = array(
					'id' => $vehicle['id'],
					'imei' => $appVehicle->getImei(),
					'name' => $vehicle['name'],
					'phone' => $appVehicle->getPhone(),
					'password' => $vehicle['password'],
					'model' => $vehicle['model'],
					'category' => $vehicle['category'],
					'date' => $vehicle['date'],
					'status' => $vehicle['status']
				);

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

	public function getVehicles(int $idUser): array {
		$vehicles = array();

		try{
			$query = "SELECT vehicle.id, registered.imei, vehicle.name, registered.phone, 
						vehicle.password, vehicle.model, vehicle.category, vehicle.date, vehicle.status
						FROM app_vehicles as vehicle INNER JOIN app_registered as registered
						ON vehicle.idregistered = registered.id
						WHERE vehicle.iduser = :idUser;";

			$query = $this->db->prepare($query);
			$query->bindValue(":idUser", $idUser);	
			$query->execute();

			if($query->rowCount() > 0){
				$vehicles = $query->fetchAll(PDO::FETCH_ASSOC);
			}	

		} catch(PDOException $e){
			echo "ERROR: ".$e->getMessage();
		}
		return $vehicles;
	}

	public function getVehicle(int $idUser, int $idVehicle): array {
		$vehicle = array();

		try{
			$query = "SELECT vehicle.id, registered.imei, vehicle.name, registered.phone, 
						vehicle.password, vehicle.model, vehicle.category, vehicle.date, vehicle.status
						FROM app_vehicles as vehicle INNER JOIN app_registered as registered
						ON vehicle.idregistered = registered.id
						WHERE vehicle.iduser = :idUser AND vehicle.id = :idVehicle;";

			$query = $this->db->prepare($query);
			$query->bindValue(":idUser", $idUser);
			$query->bindValue(":idVehicle", $idVehicle);		
			$query->execute();

			if($query->rowCount() > 0){
				$vehicle = $query->fetch(PDO::FETCH_ASSOC);
			}		

		} catch(PDOException $e){
			echo "ERROR: ".$e->getMessage();
		}
		return $vehicle;
	}

	public function editVehicle(AppVehicle $appVehicle): array {
		$response = array('status' => false, 'error' => 1);

		try{
			//Iniciar Transação
			$this->db->beginTransaction();

			$query = "SELECT * FROM `app_vehicles` 
						WHERE iduser = :idUser AND `idregistered` = :idRegistered;";

			$query = $this->db->prepare($query);
			$query->bindValue(":idUser", $appVehicle->getIdUser());
			$query->bindValue(":idRegistered", $appVehicle->getIdRegistered());
			$query->execute();

			$rowCount = $query->rowCount();
			$idVehicle = 0;

			if($rowCount > 0){
				$query = $query->fetch(PDO::FETCH_ASSOC);
				$idVehicle = $query['id'];
			}

			if($rowCount == 0 || $idVehicle == $appVehicle->getId()){

				$query = "UPDATE `app_vehicles` SET 
							`idregistered` = :idRegistered, 
							`name` = :name, 
							`password` = :password, 
							`model` = :model, 
							`category` = :category 
							WHERE id = :id;";

				$query = $this->db->prepare($query);
				$query->bindValue(":id", $appVehicle->getId());
				$query->bindValue(":idRegistered", $appVehicle->getIdRegistered());
				$query->bindValue(":name", $appVehicle->getName());
				$query->bindValue(":password", $appVehicle->getPassword());
				$query->bindValue(":model", $appVehicle->getModel());
				$query->bindValue(":category", $appVehicle->getCategory());
				$query->execute();	

				if($query->rowCount() > 0){

					// LastUpdate
					$lastUpdate = time();
					//-------------------

					$query = "UPDATE `app_users` SET 
								`lastupdate` = :lastUpdate 
								WHERE `iduser` = :idUser;";	

					$query = $this->db->prepare($query);
					$query->bindValue(":idUser", $appVehicle->getIdUser());
					$query->bindValue(":lastUpdate", $lastUpdate);
					$query->execute();	

					if($query->rowCount() > 0){
						
						$response['vehicle'] = array(
							'id' => $appVehicle->getId(),
							'imei' => $appVehicle->getImei(),
							'name' => $appVehicle->getName(),
							'phone' => $appVehicle->getPhone(),
							'password' => $appVehicle->getPassword(),
							'model' => $appVehicle->getModel(),
							'category' => $appVehicle->getCategory()
						);

						$response['error'] = 0;
						$response['status'] = true;
					}	

				} else{
					$response['error'] = 3;
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

	public function deleteVehicle(int $idUser, int $idVehicle): bool {
		$status = false;

		try{
			//Iniciar Transação
			$this->db->beginTransaction();

			$query = "DELETE FROM `app_vehicles` 
						WHERE `iduser` = :idUser AND `id` = :idVehicle;";

			$query = $this->db->prepare($query);
			$query->bindValue(":idUser", $idUser);		
			$query->bindValue(":idVehicle", $idVehicle);
			$query->execute();

			if($query->rowCount() > 0){
				
				// LastUpdate
				$lastUpdate = time();
				//-------------------

				$query = "UPDATE `app_users` SET 
							`lastupdate` = :lastUpdate 
							WHERE `iduser` = :idUser;";	

				$query = $this->db->prepare($query);
				$query->bindValue(":idUser", $idUser);
				$query->bindValue(":lastUpdate", $lastUpdate);
				$query->execute();	

				if($query->rowCount() > 0){
					$status = true;
				}
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
}