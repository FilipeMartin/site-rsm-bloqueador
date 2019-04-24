<?php
namespace Models;

use Exception;

class Vehicle {

	private $id;
	private $name;
	private $imei;
	private $lastUpdate;
	private $positionId;
	private $groupId;
	private $attributes;
	private $phone;
	private $model;
	private $contact;
	private $category;
	private $expirationTime;
	private $status;

	public function __construct(array $data = array()){
		$this->id = $data['id'] ?? 0;
		$this->name = $data['name'] ?? '';
		$this->imei = $data['uniqueid'] ?? '';
		$this->lastUpdate = $data['lastupdate'] ?? '';
		$this->positionId = $data['positionid'] ?? 0;
		$this->groupId = $data['groupid'] ?? 0;
		$this->attributes = $data['attributes'] ?? '';
		$this->phone = $data['phone'] ?? '';
		$this->model = $data['model'] ?? '';
		$this->contact = $data['contact'] ?? '';
		$this->category = $data['category'] ?? '';
		$this->expirationTime = $data['expirationtime'] ?? '';
		$this->status = $data['disabled'] ?? 0;
	}

	public function setId(int $id){
		$this->validateId($id);
	}

	public function getId(): int {
		return $this->id;
	}

	public function setName(string $name){
		$this->validateName($name);
	}

	public function getName(): string {
		return $this->name;
	}

	public function setImei(string $imei){
		$this->validateImei($imei);
	}

	public function getImei(): string {
		return $this->imei;
	}

	public function setLastUpdate(string $lastUpdate){
		$this->validateLastUpdate($lastUpdate);
	}

	public function getLastUpdate(): string {
		return $this->lastUpdate;
	}

	public function setPositionId(int $positionId){
		$this->validatePositionId($positionId);
	}

	public function getPositionId(): int {
		return $this->positionId;
	}

	public function setGroupId(int $groupId){
		$this->validateGroupId($groupId);
	}

	public function getGroupId(): int {
		return $this->groupId;
	}

	public function setAttributes(string $attributes){
		$this->validateAttributes($attributes);
	}

	public function getAttributes(): string {
		return $this->attributes;
	}

	public function setPhone(string $phone){
		$this->validatePhone($phone);
	}

	public function getPhone(): string {
		return $this->phone;
	}

	public function setModel(string $model){
		$this->validateModel($model);
	}

	public function getModel(): string {
		return $this->model;
	}

	public function setContact(string $contact){
		$this->validateContact($contact);
	}

	public function getContact(): string {
		return $this->contact;
	}

	public function setCategory(string $category){
		$this->validateCategory($category);
	}

	public function getCategory(): string {
		return $this->category;
	}

	public function getExpirationTime(string $format = ''): string {
		$expirationTime = $this->expirationTime;

		if(!empty($format)){
			$expirationTime = date($format, strtotime($expirationTime));
		}
		return $expirationTime;
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

	private function validateName(string $name){

		if(!empty($name)){
			$this->name = $name;
		} else{
			throw new Exception("Atributo [name] Inválido.");
		}

	}

	private function validateImei(string $imei){

		if(!empty($imei)){
			$this->imei = $imei;
		} else{
			throw new Exception("Atributo [imei] Inválido.");
		}

	}

	private function validateLastUpdate(string $lastUpdate){

		if(!empty($lastUpdate)){
			$this->lastUpdate = $lastUpdate;
		} else{
			throw new Exception("Atributo [lastUpdate] Inválido.");
		}

	}

	private function validatePositionId(int $positionId){

		if($positionId >= 0){
			$this->positionId = $positionId;
		} else{
			throw new Exception("Atributo [positionId] Inválido.");
		}

	}

	private function validateGroupId(int $groupId){

		if($groupId >= 0){
			$this->groupId = $groupId;
		} else{
			throw new Exception("Atributo [groupId] Inválido.");
		}

	}

	private function validateAttributes(string $attributes){

		if(!empty($attributes)){
			$this->attributes = $attributes;
		} else{
			throw new Exception("Atributo [attributes] Inválido.");
		}

	}

	private function validatePhone(string $phone){

		if(!empty($phone)){
			$this->phone = $phone;
		} else{
			throw new Exception("Atributo [phone] Inválido.");
		}

	}

	private function validateModel(string $model){

		if(!empty($model)){
			$this->model = $model;
		} else{
			throw new Exception("Atributo [model] Inválido.");
		}

	}

	private function validateContact(string $contact){

		if(!empty($contact)){
			$this->contact = $contact;
		} else{
			throw new Exception("Atributo [contact] Inválido.");
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

	// Funções
	public function getVehicleArray(): array {

		$vehicle = array(
			'id' => $this->id,
			'name' => $this->name,
			'imei' => $this->imei,
			'lastUpdate' => $this->lastUpdate,
			'positionId' => $this->positionId,
			'groupId' => $this->groupId,
			'attributes' => $this->attributes,
			'phone' => $this->phone,
			'model' => $this->model,
			'contact' => $this->contact,
			'category' => $this->category,
			'expirationTime' => $this->expirationTime,
			'status' => $this->status
		);
		return $vehicle;
	}

	public function getCategoryId(): int {
		$value = 0; 

		switch($this->category){
			case 'plane':
			    $value = 1; break;
			case 'boat':
			    $value = 2; break;
			case 'bicycle':
			    $value = 3; break;
			case 'truck':
			    $value = 4; break;
			case 'car':
			    $value = 5; break;
			case 'crane':
			    $value = 6; break;
			case 'helicopter':
			    $value = 7; break;
			case 'motorcycle':
			    $value = 8; break;
			case 'ship':
			    $value = 9; break;
			case 'offroad':
			    $value = 10; break;
			case 'bus':
			    $value = 11; break;
			case 'pickup':
			    $value = 12; break;
			case 'tractor':
			    $value = 13; break;
			case 'van':
			    $value = 14;   
		}
		return $value;
	}

	public function getCategoryName(): string {
		$category = '';

		switch($this->category){
			case 1: 
					$category = "plane"; break;
			case 2: 
					$category = "boat"; break;
			case 3: 
					$category = "bicycle"; break;
			case 4: 
					$category = "truck"; break;	
			case 5: 
					$category = "car"; break;
			case 6: 
					$category = "crane"; break;
			case 7: 
					$category = "helicopter"; break;
			case 8: 
					$category = "motorcycle"; break;
			case 9: 
					$category = "ship"; break;
			case 10: 
					$category = "offroad"; break;
			case 11: 
					$category = "bus"; break;
			case 12: 
					$category = "pickup"; break;	
			case 13: 
					$category = "tractor"; break;	
			case 14: 
					$category = "van";											
		}

		return $category;
	}

}