<?php
namespace Models;

use Exception;

class AppVehicle {

	private $id;
	private $idUser;
	private $idRegistered;
	private $imei;
	private $name;
	private $phone;
	private $password;
	private $model;
	private $category;
	private $date;
	private $status;

	public function __construct(array $data = array()){
		$this->id = $data['id'] ?? 0;
		$this->idUser = $data['iduser'] ?? 0;
		$this->idRegistered = $data['idregistered'] ?? 0;
		$this->imei = $data['imei'] ?? '';
		$this->name = $data['name'] ?? '';
		$this->phone = $data['phone'] ?? '';
		$this->password = $data['password'] ?? '';
		$this->model = $data['model'] ?? '';
		$this->category = $data['category'] ?? '';
		$this->date = $data['date'] ?? '';
		$this->status = $data['status'] ?? 0;
	}

	public function setId(int $id){
		$this->validateId($id);
	}

	public function getId(): int {
		return $this->id;
	}

	public function setIdUser(int $idUser){
		$this->validateIdUser($idUser);
	}

	public function getIdUser(): int {
		return $this->idUser;
	}

	public function setIdRegistered(int $idRegistered){
		$this->validateIdRegistered($idRegistered);
	}

	public function getIdRegistered(): int {
		return $this->idRegistered;
	}

	public function setImei(string $imei){
		$this->validateImei($imei);
	}

	public function getImei(): string {
		return $this->imei;
	}

	public function setName(string $name){
		$this->validateName($name);
	}

	public function getName(): string {
		return $this->name;
	}

	public function setPhone(string $phone){
		$this->validatePhone($phone);
	}

	public function getPhone(): string {
		return $this->phone;
	}

	public function setPassword(string $password){
		$this->validatePassword($password);
	}

	public function getPassword(): string {
		return $this->password;
	}

	public function setModel(string $model){
		$this->validateModel($model);
	}

	public function getModel(): string {
		return $this->model;
	}

	public function setCategory(string $category){
		$this->validateCategory($category);
	}

	public function getCategory(): string {
		return $this->category;
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

		if(filter_var($id, FILTER_VALIDATE_INT)){
			$this->id = $id;
		} else{
			throw new Exception("Atributo [id] Inválido.");
		}

	}

	private function validateIdUser(int $idUser){

		if($idUser >= 0){
			$this->idUser = $idUser;
		} else{
			throw new Exception("Atributo [idUser] Inválido.");
		}

	}

	private function validateIdRegistered(int $idRegistered){

		if($idRegistered >= 0){
			$this->idRegistered = $idRegistered;
		} else{
			throw new Exception("Atributo [idRegistered] Inválido.");
		}

	}

	private function validateImei(string $imei){

		if(!empty($imei)){
			$this->imei = $imei;
		} else{
			throw new Exception("Atributo [imei] Inválido.");
		}

	}

	private function validateName(string $name){

		if(!empty($name)){
			$this->name = $name;
		} else{
			throw new Exception("Atributo [name] Inválido.");
		}

	}

	private function validatePhone(string $phone){

		if(!empty($phone)){
			$this->phone = $phone;
		} else{
			throw new Exception("Atributo [phone] Inválido.");
		}

	}

	private function validatePassword(string $password){

		if(!empty($password)){
			$this->password = $password;
		} else{
			throw new Exception("Atributo [password] Inválido.");
		}

	}

	private function validateModel(string $model){

		if(!empty($model)){
			$this->model = $model;
		} else{
			throw new Exception("Atributo [model] Inválido.");
		}

	}

	private function validateCategory(string $category){

		if(!empty($category)){
			$this->category = $category;
		} else{
			throw new Exception("Atributo [category] Inválido.");
		}

	}

	private function validateStatus(int $status){

		if($status == 0 || $status == 1){
			$this->status = $status;
		} else{
			throw new Exception("Atributo [status] Inválido.");
		}

	}
}