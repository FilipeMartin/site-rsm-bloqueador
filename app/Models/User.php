<?php
namespace Models;

use Exception;

class User {

	protected $id;
	protected $idPlatform;
	protected $name;
	protected $dateBirth;
	protected $cpf;
	protected $email;
	protected $login;
	protected $password;
	protected $cellPhone;
	protected $phone;
	protected $zipCode;
	protected $state;
	protected $city;
	protected $neighborhood;
	protected $address;
	protected $addressNumber;
	protected $complement;
	protected $serviceTerms;
	protected $expirationTime;
	protected $admin;
	protected $date;
	protected $status;

	public function __construct(array $data = array()){
		$this->id = $data['id'] ?? 0;
		$this->idPlatform = $data['idplatform'] ?? 0;
		$this->name = $data['name'] ?? '';
		$this->dateBirth = $data['datebirth'] ?? '';
		$this->cpf = $data['cpf'] ?? '';
		$this->email = $data['email'] ?? '';
		$this->login = $data['login'] ?? '';
		$this->password = $data['password'] ?? '';
		$this->cellPhone = $data['cellphone'] ?? '';
		$this->phone = $data['phone'] ?? '';
		$this->zipCode = $data['zipcode'] ?? '';
		$this->state = $data['state'] ?? '';
		$this->city = $data['city'] ?? '';
		$this->neighborhood = $data['neighborhood'] ?? '';
		$this->address = $data['address'] ?? '';
		$this->addressNumber = $data['addressnumber'] ?? '';
		$this->complement = $data['complement'] ?? '';
		$this->serviceTerms = $data['serviceterms'] ?? 0;
		$this->expirationTime = $data['expirationtime'] ?? '';
		$this->admin = $data['admin'] ?? 0;
		$this->date = $data['date'] ?? '';
		$this->status = $data['status'] ?? 0;
	}

	public function setId(int $id){
		$this->validateId($id);
	}

	public function getId(): int {
		return $this->id;
	}

	public function setIdPlatform(int $idPlatform){
		$this->validateIdPlatform($idPlatform);
	}

	public function getIdPlatform(): int {
		return $this->idPlatform;
	}

	public function setName(string $name){
		$this->validateName($name);
	}

	public function getName(): string {
		return $this->name;
	}

	public function setDateBirth(string $dateBirth){
		$this->validateDateBirth($dateBirth);
	}

	public function getDateBirth(): string {
		return $this->dateBirth;
	}

	public function setCpf(string $cpf){
		$this->validateCpf($cpf);
	}

	public function getCpf(): string {
		return $this->cpf;
	}

	public function setEmail(string $email){
		$this->validateEmail($email);
	}

	public function getEmail(): string {
		return $this->email;
	}

	public function setLogin(string $login){
		$this->validateLogin($login);
	}

	public function getLogin(): string {
		return $this->login;
	}

	public function setPassword(string $password){
		$this->validatePassword($password);
	}

	public function getPassword(): string {
		return $this->password;
	}

	public function setCellPhone(string $cellPhone){
		$this->validateCellPhone($cellPhone);
	}

	public function getCellPhone(): string {
		return $this->cellPhone;
	}

	public function setPhone(string $phone){
		$this->validatePhone($phone);
	}

	public function getPhone(): string {
		return $this->phone;
	}

	public function setZipCode(string $zipCode){
		$this->validateZipCode($zipCode);
	}

	public function getZipCode(): string {
		return $this->zipCode;
	}

	public function setState(string $state){
		$this->validateState($state);
	}

	public function getState(): string {
		return $this->state;
	}

	public function setCity(string $city){
		$this->validateCity($city);
	}

	public function getCity(): string {
		return $this->city;
	}

	public function setNeighborhood(string $neighborhood){
		$this->validateNeighborhood($neighborhood);
	}

	public function getNeighborhood(): string {
		return $this->neighborhood;
	}

	public function setAddress(string $address){
		$this->validateAddress($address);
	}

	public function getAddress(): string {
		return $this->address;
	}
	
	public function setAddressNumber(string $addressNumber){
		$this->validateAddressNumber($addressNumber);
	}

	public function getAddressNumber(): string {
		return $this->addressNumber;
	}

	public function setComplement(string $complement){
		$this->validateComplement($complement);
	}

	public function getComplement(): string {
		return $this->complement;
	}

	public function setServiceTerms(int $serviceTerms){
		$this->validateServiceTerms($serviceTerms);
	}

	public function getServiceTerms(): int {
		return $this->serviceTerms;
	}

	public function setExpirationTime(string $expirationTime){
		$this->validateExpirationTime($expirationTime);
	}

	public function getExpirationTime(): string {
		return $this->expirationTime;
	}

	public function setAdmin(int $admin){
		$this->validateAdmin($admin);
	}

	public function getAdmin(): int {
		return $this->admin;
	}

	public function getDate(): string {
		return $this->date;
	}

	public function setStatus(int $status){
		$this->validateStatus($status);
	}

	public function getStatus(): int {
		return $this->status;
	}

	// Validar Atributos
	private function validateId(int $id){

		if($id >= 0){
			$this->id = $id;
		} else{
			throw new Exception("Atributo [id] Inválido.");
		}

	}

	private function validateIdPlatform(int $idPlatform){

		if($idPlatform >= 0){
			$this->idPlatform = $idPlatform;
		} else{
			throw new Exception("Atributo [idPlatform] Inválido.");
		}

	}

	private function validateName(string $name){

		if(!empty($name)){
			$this->name = $name;
		} else{
			throw new Exception("Atributo [name] Inválido.");
		}

	}

	private function validateDateBirth(string $dateBirth){

		if(!empty($dateBirth)){
			$this->dateBirth = $dateBirth;
		} else{
			throw new Exception("Atributo [dateBirth] Inválido.");
		}
		
	}

	private function validateCpf(string $cpf){
		
		if(!empty($cpf)){

			// MELHORAR CÓDIGO
			$this->cpf = str_replace(array(".", "-", " "), "", $cpf);
			//----------------------------------------------------------------------------------------------------------------->

		} else{
			throw new Exception("Atributo [cpf] Inválido.");
		}

	}

	private function validateEmail(string $email){

		if(!empty($email)){
			$this->email = $email;
		} else{
			throw new Exception("Atributo [email] Inválido.");
		}
		
	}

	private function validateLogin(string $login){
		
		if(!empty($login)){
			$this->login = $login;
		} else{
			throw new Exception("Atributo [login] Inválido.");
		}

	}

	private function validatePassword(string $password){
		
		if(!empty($password)){
			$this->password = $password;
		} else{
			throw new Exception("Atributo [password] Inválido.");
		}

	}

	private function validateCellPhone(string $cellPhone){
		
		if(!empty($cellPhone)){
			$this->cellPhone = $cellPhone;
		} else{
			throw new Exception("Atributo [cellPhone] Inválido.");
		}

	}

	private function validatePhone(string $phone){
		
		if(!empty($phone)){
			$this->phone = $phone;
		} else{
			throw new Exception("Atributo [phone] Inválido.");
		}

	}

	private function validateZipCode(string $zipCode){
		
		if(!empty($zipCode)){
			$this->zipCode = $zipCode;
		} else{
			throw new Exception("Atributo [zipCode] Inválido.");
		}

	}

	private function validateState(string $state){
		
		if(!empty($state)){
			$this->state = $state;
		} else{
			throw new Exception("Atributo [state] Inválido.");
		}

	}

	private function validateCity(string $city){
		
		if(!empty($city)){
			$this->city = $city;
		} else{
			throw new Exception("Atributo [city] Inválido.");
		}

	}

	private function validateNeighborhood(string $neighborhood){
		
		if(!empty($neighborhood)){
			$this->neighborhood = $neighborhood;
		} else{
			throw new Exception("Atributo [neighborhood] Inválido.");
		}

	}

	private function validateAddress(string $address){
		
		if(!empty($address)){
			$this->address = $address;
		} else{
			throw new Exception("Atributo [address] Inválido.");
		}

	}

	private function validateAddressNumber(string $addressNumber){
		
		if(!empty($addressNumber)){
			$this->addressNumber = $addressNumber;
		} else{
			throw new Exception("Atributo [addressNumber] Inválido.");
		}

	}

	private function validateComplement(string $complement){
		
		if(!empty($complement)){
			$this->complement = $complement;
		} else{
			throw new Exception("Atributo [complement] Inválido.");
		}

	}

	private function validateServiceTerms(int $serviceTerms){
		
		if($serviceTerms == 0 || $serviceTerms == 1){
			$this->serviceTerms = $serviceTerms;
		} else{
			throw new Exception("Atributo [serviceTerms] Inválido.");
		}

	}

	private function validateExpirationTime(string $expirationTime){
		
		if(!empty($expirationTime)){
			$this->expirationTime = $expirationTime;
		} else{
			throw new Exception("Atributo [expirationTime] Inválido.");
		}

	}

	private function validateAdmin(int $admin){
		
		if($admin == 0 || $admin == 1){
			$this->admin = $admin;
		} else{
			throw new Exception("Atributo [admin] Inválido.");
		}

	}

	private function validateStatus(int $status){
		
		if($status == 0 || $status == 1){
			$this->status = $status;
		} else{
			throw new Exception("Atributo [status] Inválido.");
		}

	}

	// Funções
	public function getUserArray(): array {

		$user = array(
			'id' => $this->id,
			'idPlatform' => $this->idPlatform,
			'name' => $this->name,
			'firstName' => $this->getFirstName(),
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
			'status' => $this->status
		);
		return $user;
	}
	
	public function getFirstName(): string {

		$firstName = "";

		if(!empty($this->name)){
			$firstName = explode(' ', $this->name);
			$firstName = array_shift($firstName);	
		}

		return $firstName;
	}

	public function getAllStates(): array {

		$states = array('AC','AL','AP','AM','BA','CE','DF','ES','GO',
						'MA','MT','MS','MG','PA','PB','PR','PE','PI',
						'RJ','RN','RS','RO','RR','SC','SP','SE','TO'
		);
		
		return $states;
	}

}