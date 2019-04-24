<?php
namespace Models;

use Exception;

class AppRegistered {

	private $id;
	private $phone;
	private $imei;

	public function __construct(array $data = array()){
		$this->id = $data['id'] ?? 0;
		$this->phone = $data['phone'] ?? '';
		$this->imei = $data['imei'] ?? '';
	}

	public function setId(int $id){
		$this->validateId($id);
	}

	public function getId(): int {
		return $this->id;
	}

	public function setPhone(string $phone){
		$this->validatePhone($phone);
	}

	public function getPhone(): string {
		return $this->phone;
	}

	public function setImei(string $imei){
		$this->validateImei($imei);
	}

	public function getImei(): string {
		return $this->imei;
	}

	// Validar Atributos
	private function validateId(int $id){

		if($id >= 0){
			$this->id = $id;
		} else{
			throw new Exception("Atributo [id] Inválido.");
		}

	}

	private function validatePhone(string $phone){

		if(!empty($phone)){
			$this->phone = $phone;
		} else{
			throw new Exception("Atributo [phone] Inválido.");
		}

	}

	private function validateImei(string $imei){

		if(!empty($imei)){
			$this->imei = $imei;
		} else{
			throw new Exception("Atributo [imei] Inválido.");
		}

	}

	// Funções
	public function getRegisteredArray(): array {

		$appRegistered = array(
			'id' => $this->id,
			'phone' => $this->phone,
			'imei' => $this->imei
		);
		return $appRegistered;
	}

}