<?php
namespace DAO;

use PDO;
use PDOException;
use Models\User;
use Models\UserPlatform;

class UserPlatformDAO {

	private $db;

	public function __construct(){
		$dataBase = new ConnectionDB();
		$this->db = $dataBase->connect('rsm');
	}

	public function addUserPlatform(UserPlatform $userPlatform): bool {
		$status = false;

		try{
			$query = "INSERT INTO `user_platform` SET `iduser` = :idUser, `idplatform` = :idPlatform;";
			$query = $this->db->prepare($query);
			$query->bindValue("idUser", $userPlatform->getIdUser());
			$query->bindValue("idPlatform", $userPlatform->getIdPlatform());
			$query->execute();

			if($query->rowCount() > 0){
				$status = true;
			}

		} catch(PDOException $e){
			echo "ERROR: ".$e->getMessage();
		}
		return $status;
	}

	public function getUserPlatform(User $user) {
		$userPlatform = null;

		try{
			$query = "SELECT * FROM `user_platform` WHERE `iduser` = :idUser;";
			$query = $this->db->prepare($query);
			$query->bindValue("idUser", $user->getId());
			$query->execute();

			if($query->rowCount() > 0){
                $userPlatform = new UserPlatform($query->fetch(PDO::FETCH_ASSOC));
			}

		} catch(PDOException $e){
			echo "ERROR: ".$e->getMessage();
		}
		return $userPlatform;
	}
} 