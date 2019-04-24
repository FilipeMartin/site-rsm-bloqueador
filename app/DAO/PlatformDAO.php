<?php
namespace DAO;

use PDO;
use PDOException;
use Core\Curl;
use Models\User;
use Models\Vehicle;

class PlatformDAO {

	private $db;
	private $data;
	private $dateFormat;

	public function __construct(){
		$dataBase = new ConnectionDB();
		$this->db = $dataBase->connect('platform');

		global $configPlatform;
		$this->data = $configPlatform['data'];
		$this->dateFormat = $configPlatform['dateFormat'];
	}

	public function clearTablePositions(): array {
		$data = date($this->dateFormat, strtotime($this->data." days"));
		$status = array();
		
		try{
			$query = "DELETE FROM `positions` WHERE `servertime` <= date(:data);";
			$query = $this->db->prepare($query);
			$query->bindValue(":data", $data);
			$query->execute();

			if($query->rowCount() > 0){
				$status['status'] = 1;
			} else{
				$status['status'] = 2;
			}

		} catch(PDOException $e){
			$status['status'] = 0;
			$status['error'] = $e->getMessage();
		}
		return $status;
	}

	public function clearTableEvents(): array {
		$data = date($this->dateFormat, strtotime($this->data." days"));
		$status = array();

		try{
			$query = "DELETE FROM `events` WHERE `servertime` <= date(:data);";
			$query = $this->db->prepare($query);
			$query->bindValue(":data", $data);
			$query->execute();

			if($query->rowCount() > 0){
				$status['status'] = 1;
			} else{
				$status['status'] = 2;
			}

		} catch(PDOException $e){
			$status['status'] = 0;
			$status['error'] = $e->getMessage();
		}
		return $status;
	}

	public function getVehicles(int $idUser): array {

		$dados = array(
			'vehicles' => [],
			'infoBox' => [
				'total' => 0,
				'ativo' => 0,
				'desabilitado' => 0,
				'cadastrar' => 0
			]
		);

		try{
			$query = "SELECT devices.*, vehicles.expirationtime 
						FROM vehicles LEFT JOIN devices 
						ON vehicles.idvehicle = devices.id 
						WHERE vehicles.iduser = :idUser;";			

			$query = $this->db->prepare($query);
			$query->bindValue(":idUser", $idUser);
			$query->execute();

			if($query->rowCount() > 0){
				$query = $query->fetchAll(PDO::FETCH_ASSOC);

				foreach($query as $item){
						
					if($item['id'] > 0){
						$vehicle = new Vehicle($item);
						$dados['vehicles'][] = $vehicle;

						if($item['disabled'] == 0){
							$dados['infoBox']['ativo']++;
						} else{
							$dados['infoBox']['desabilitado']++;
						}

						$dados['infoBox']['total']++;

					} else{
						$dados['infoBox']['cadastrar']++;
					}
				}
			}

		} catch(PDOException $e){
			echo "ERROR: ".$e->getMessage();
		}
		return $dados;
	}
	
	public function getVehicle(int $idUser, int $idVehicle){
		$vehicles = null;

		try{
			$query = "SELECT devices.*, vehicles.expirationtime 
						FROM devices INNER JOIN vehicles 
						ON devices.id = vehicles.idvehicle 
						WHERE vehicles.iduser = :idUser AND vehicles.idvehicle = :idVehicle;";

			$query = $this->db->prepare($query);
			$query->bindValue(":idUser", $idUser);
			$query->bindValue(":idVehicle", $idVehicle);
			$query->execute();

			if($query->rowCount() > 0){
				$vehicles = new Vehicle($query->fetch(PDO::FETCH_ASSOC));
			}

		} catch(PDOException $e){
			echo "ERROR: ".$e->getMessage();
		}
		return $vehicles;
	}

	public function addVehicle(int $idUser, int $numberVehicles, int $typePlane, bool $newUser): bool {
		$status = false;
		$expirationTime = $this->calculeDate($typePlane, 2);

		try{
			//Iniciar Transação
			$this->db->beginTransaction();

			for($i = 0; $i < $numberVehicles; $i++){
				$query = "INSERT INTO `vehicles` SET `iduser` = :idUser, `expirationtime` = :expirationTime;";
				$query = $this->db->prepare($query);
				$query->bindValue(":idUser", $idUser);
				$query->bindValue(":expirationTime", $expirationTime);
				$query->execute();	
			}

			if(!$newUser){
				$query = "UPDATE `users` 
							SET `expirationtime` = :expirationTime, `disabled` = 0 
							WHERE `id` = :idUser AND expirationtime < :expirationTime";

				$query = $this->db->prepare($query);
				$query->bindValue(":idUser", $idUser);
				$query->bindValue(":expirationTime", $expirationTime);
				$query->execute();
			}

			// Finalizar Transação	
			if($this->db->commit()){
				$status = true;	
			}

		} catch(PDOException $e){
			// Cancelar Transação
			$this->db->rollBack();
			echo "ERROR: ".$e->getMessage();
		}
		return $status;	
	}

	public function updateVehicle(int $idUser, int $idVehicle): bool {
		$status = false;

		try{
			$query = "UPDATE `vehicles` SET `idvehicle` = :idVehicle 
						WHERE `iduser` = :idUser AND `idvehicle` = 0 LIMIT 1;";

			$query = $this->db->prepare($query);
				$query->bindValue(":idUser", $idUser);
				$query->bindValue(":idVehicle", $idVehicle);
				$query->execute();

			if($query->rowCount() > 0){
				$status = true;
			}

		} catch(PDOException $e){
			echo "ERROR: ".$e->getMessage();
		}
		return $status;
	}

	public function updateDateVehicle(int $idUser, int $idVehicle, int $typePlane): bool {
		$status = false;
		$month = $this->calculeDate($typePlane, 1);

		try{
			//Iniciar Transação
			$this->db->beginTransaction();

			$query = "SELECT `expirationtime` FROM `vehicles` WHERE `idvehicle` = :idVehicle;";
			$query = $this->db->prepare($query);
			$query->bindValue(":idVehicle", $idVehicle);
			$query->execute();

			$dataVeiculo = $query->fetch(PDO::FETCH_ASSOC);
			$dataVeiculo = date('Y-m-d', strtotime($dataVeiculo['expirationtime']));
			$dataHoje = date('Y-m-d');

			if($dataVeiculo <= $dataHoje){

				$expirationTime = date('Y-m-d', strtotime($month));

			} else if($dataVeiculo > $dataHoje){

				$expirationTime = date('Y-m-d', strtotime($dataVeiculo.$month));
			}

			$query = "UPDATE vehicles as vehicle INNER JOIN devices as device
						ON vehicle.idvehicle = device.id 
						SET vehicle.expirationtime = :expirationTime, device.disabled = 0
						WHERE vehicle.idvehicle = :idVehicle;";		

			$query = $this->db->prepare($query);
			$query->bindValue(":idVehicle", $idVehicle);
			$query->bindValue(":expirationTime", $expirationTime);	
			$query->execute();

			$query = "UPDATE `users` 
						SET `expirationtime` = :expirationTime, `disabled` = 0 
						WHERE `id` = :idUser AND expirationtime < :expirationTime";

			$query = $this->db->prepare($query);
			$query->bindValue(":idUser", $idUser);
			$query->bindValue(":expirationTime", $expirationTime);
			$query->execute();	

			// Finalizar Transação	
			if($this->db->commit()){
				$status = true;	
			}

		} catch(PDOException $e){
			// Cancelar Transação
			$this->db->rollBack();
			echo "ERROR: ".$e->getMessage();
		}	
		return $status;	
	}

	public function numberRegister(int $idUser): int {
		$qtd = 0;

		try{
			$query = "SELECT COUNT(*) as qtd FROM `vehicles` 
						WHERE `iduser` = :idUser AND `idvehicle` = 0;";

			$query = $this->db->prepare($query);
			$query->bindValue(":idUser", $idUser);
			$query->execute();	
			
			if($query->rowCount() > 0){
				$query = $query->fetch(PDO::FETCH_ASSOC);
				$qtd = $query['qtd'];
			}		

		} catch(PDOException $e){
			echo "ERROR: ".$e->getMessage();
		}
		return $qtd;
	}

	public function getExpirationTime(int $idVehicle): string {
		$date = '';

		try{
			$query = "SELECT `expirationtime` FROM `vehicles` 
						WHERE `idvehicle` = :idVehicle;";

			$query = $this->db->prepare($query);
			$query->bindValue(":idVehicle", $idVehicle);
			$query->execute();	
			
			if($query->rowCount() > 0){
				$query = $query->fetch(PDO::FETCH_ASSOC);
				$date = date('d/m/Y', strtotime($query['expirationtime']));
			}			

		} catch(PDOException $e){
			echo "ERROR: ".$e->getMessage();
		}
		return $date;
	}

	public function getPosition(int $idPosition): array {
		$position = array();

		try{
			$query = "SELECT `devicetime`, `latitude`, `longitude` FROM `positions` 
						WHERE `id` = :idPosition";

			$query = $this->db->prepare($query);
			$query->bindValue(":idPosition", $idPosition);
			$query->execute();	
			
			if($query->rowCount() > 0){
				$position = $query->fetch(PDO::FETCH_ASSOC);
			}

		} catch(PDOException $e){
			echo "ERROR: ".$e->getMessage();
		}
		return $position;
	}

	public function verifyImei(int $imei): bool {
		$status = false;

		try{
			$query = "SELECT `uniqueid` FROM `devices` 
						WHERE `uniqueid` = :imei";

			$query = $this->db->prepare($query);
			$query->bindValue(":imei", $imei);
			$query->execute();	
			
			if($query->rowCount() > 0){
				$status = true;
			}

		} catch(PDOException $e){
			echo "ERROR: ".$e->getMessage();
		}
		return $status;
	}

	// Plataforma API
	public function addUserAPI(User $user, int $typePlane) {
		$curl = new Curl();	

		// Configurações da API
		$config = array(
			'url' => BASE_URL_PLATFORM.'api/users',
			'method' => 'POST'
		);
		//-----------------------------------------

		// Expiration Time
		$expirationTime = $this->calculeDate($typePlane, 3);
		//--------------------------------------------------

		$data = array(
			'name' => $user->getName(),
			'login' => $user->getLogin(),
			'email' => $user->getEmail(),
			'password' => '123456',

			'phone' => $user->getCellPhone(),
			'map' => 'custom',
			'latitude' => 0,
			'longitude' => 0,
			'zoom' => 0,
			'twelveHourFormat' => true,
			'coordinateFormat' => 'dd',
			'poiLayer' => '',

			'disabled' => false,
			'admin' => false,
			'readonly' => false,
			'deviceReadonly' => true,
			'limitCommands' => true,
			'expirationTime' => $expirationTime,
			'deviceLimit' => -1,
			'userLimit' => 0,
			'token' => ''
		);
		return $curl->curl($config, $data);
	}

	public function addVehicleAPI(Vehicle $vehicle) {
		$curl = new Curl();	

		// Configurações da API
		$config = array(
			'url' => BASE_URL_PLATFORM.'api/devices',
			'method' => 'POST'
		);
		//-------------------------------------------

		$data = array(
			'name' => $vehicle->getName(),
			'uniqueId' => $vehicle->getImei(),
			'phone' => $vehicle->getPhone(),
			'model' => $vehicle->getModel(),
			'contact' => $vehicle->getContact(),
			'category' => $vehicle->getCategoryName(),
			'disabled' => false
		);
		return $curl->curl($config, $data);
	}

	public function updateVehicleAPI(Vehicle $vehicle) {
		$curl = new Curl();	

		// Configurações da API
		$config = array(
			'url' => BASE_URL_PLATFORM.'api/devices/'.$vehicle->getId(),
			'method' => 'PUT'
		);
		//--------------------------------------------------------------

		$data = array(
			'id' => $vehicle->getId(),
			'name' => $vehicle->getName(),
			'uniqueId' => $vehicle->getImei(),
			'groupId' => $vehicle->getGroupId(),
			'phone' => $vehicle->getPhone(),
			'model' => $vehicle->getModel(),
			'contact' => $vehicle->getContact(),
			'category' => $vehicle->getCategoryName(),
			'disabled' => ($vehicle->getStatus() ? true : false)
		);
		return $curl->curl($config, $data);
	}

	public function addPermissionAPI(int $userId, int $deviceId) {
		$curl = new Curl();	

		// Configurações da API
		$config = array(
			'url' => BASE_URL_PLATFORM.'api/permissions',
			'method' => 'POST'
		);
		//-----------------------------------------------

		$data = array(
			'userId' => $userId,
			'deviceId' => $deviceId
		);
		return $curl->curl($config, $data);
	}

	// Funções Internas
	private function calculeDate(int $typePlane, int $typeDate): string {
		$month = ' +0 month';
		$date = '';

		switch($typePlane){
			case 1: 
				$month = ' +3 month';
				break;
			case 2:
				$month = ' +6 month';
				break;
			case 3:	
				$month = ' +12 month';
		}

		switch($typeDate){
			case 1: 
				$date = $month;
				break;
			case 2:
				$date = date('Y-m-d', strtotime($month));
				break;
			case 3:
				$date = date(DATE_ISO8601, strtotime(date('Y-m-d', strtotime($month))));
		}
		return $date;
	}
}