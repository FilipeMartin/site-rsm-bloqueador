<?php
namespace Models;

use Exception;

class AppUser extends User {

	private $lastUpdate;
	private $token;
	private $session;
	private $platformToken;

	public function __construct(array $data = array()){
		parent::__construct($data);

		$this->lastUpdate = $data['lastupdate'] ?? '';
		$this->token = $data['token'] ?? '';
		$this->session = $data['session'] ?? '';
		$this->platformToken = $data['platformtoken'] ?? null;
	}

	public function setLastUpdate(string $lastUpdate){
		$this->validateLastUpdate($lastUpdate);
	}

	public function getLastUpdate(): string {
		return $this->lastUpdate;
	}

	public function setToken(string $token){
		$this->validateToken($token);
	}

	public function getToken(): string {
		return $this->token;
	}

	public function setSession(string $session){
		$this->validateSession($session);
	}

	public function getSession(): string {
		return $this->session;
	}

	public function setPlatformToken($platformToken){
		$this->validatePlatformToken($platformToken);
	}

	public function getPlatformToken(){
		return $this->platformToken;
	}

	// Validar Atributos
	private function validateLastUpdate(string $lastUpdate){

		if(!empty($lastUpdate)){
			$this->lastUpdate = $lastUpdate;
		} else{
			throw new Exception("Atributo [lastUpdate] Inválido.");
		}

	}

	private function validateToken(string $token){

		if(!empty($token)){
			$this->token = $token;
		} else{
			throw new Exception("Atributo [token] Inválido.");
		}

	}

	private function validateSession(string $session){

		if(!empty($session)){
			$this->session = $session;
		} else{
			throw new Exception("Atributo [session] Inválido.");
		}

	}

	private function validatePlatformToken($platformToken){

		if(strlen($platformToken) == 32){
			$this->platformToken = $platformToken;

		} else if(empty($platformToken)){
			$this->platformToken = null;

		} else{
			throw new Exception("Atributo [platformToken] Inválido.");
		}
		
	}

	// Funções
	public function getUserArray(): array {

		$appUser = array(
			'id' => $this->id,
			'name' => $this->name,
			'dateBirth' => $this->dateBirth,
			'cpf' => $this->cpf,
			'email' => $this->email,
			'login' => $this->login,
			'password' => $this->password,
			'cellPhone' => $this->cellPhone,
			'phone' => $this->phone,
			'zipCode' => $this->zipCode,
			'state' => $this->state,
			'city' => $this->city,
			'neighborhood' => $this->neighborhood,
			'address' => $this->address,
			'addressNumber' => $this->addressNumber,
			'complement' => $this->complement,
			'serviceTerms' => $this->serviceTerms,
			'expirationTime' => $this->expirationTime,
			'admin' => $this->admin,
			'date' => $this->date,
			'status' => $this->status,
			'lastUpdate' => $this->lastUpdate,
			'token' => $this->token,
			'session' => $this->session,
			'platformToken' => $this->platformToken
		);
		return $appUser;
	}

}