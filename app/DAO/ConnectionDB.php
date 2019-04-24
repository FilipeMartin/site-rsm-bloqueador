<?php
namespace DAO;

use PDO;
use PDOException;

class ConnectionDB {
	
	private $config;
	private $pdo;

	public function __construct(){
		global $configDB;
		$this->config = $configDB;
	}

	public function connect(string $nameDB){

		switch($nameDB){
			case 'rsm':
				$config = $this->config['rsm'];
				break;
			case 'platform':
				$config = $this->config['platform'];
		}

		try {

			$options = array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES UTF8');
			$pdo = new PDO("mysql:host=".$config['host'].";dbname=".$config['name'], $config['user'], $config['pass'], $options);
			$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

			return $pdo;

		} catch(PDOException $ex){
			echo "ERRO: ".$ex->getMessage();
		}
	}
}