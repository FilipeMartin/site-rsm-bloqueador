<?php
namespace Models;

use Exception;

class UserPlatform {

	private $idUser;
	private $idPlatform;

	public function __construct(array $data = array()){
		$this->idUser = $data['iduser'] ?? 0;
		$this->idPlatform = $data['idplatform'] ?? 0;
	}

	public function setIdUser(int $idUser){
		$this->validateIdUser($idUser);
	}

	public function getIdUser(): int {
		return $this->idUser;
	}

	public function setIdPlatform(int $idPlatform){
		$this->validateIdPlatform($idPlatform);
	}

	public function getIdPlatform(): int {
		return $this->idPlatform;
	}

	// Validar Atributos
	private function validateIdUser(int $idUser){
		
		if($idUser >= 0){
			$this->idUser = $idUser;
		} else{
			throw new Exception("Atributo [idUser] Inválido.");
		}

	}

	private function validateIdPlatform(int $idPlatform){
		
		if($idPlatform >= 0){
			$this->idPlatform = $idPlatform;
		} else{
			throw new Exception("Atributo [idPlatform] Inválido.");
		}
		
	}
}