<?php
require_once 'environment.php';

global $configDB;

if(ENVIRONMENT == 'development'){
	define("BASE_URL", "http://rsmbloqueador.pc/");
	define("BASE_URL_PLATFORM", "http://191.252.184.199:8082/");

	$configDB = array(
		'rsm' => [
			'host' => 'localhost',
			'name' => 'rsm_bloqueador',
			'user' => 'root',
			'pass' => ''
		],

		'platform' => [
			'host' => 'localhost',
			'name' => 'traccar',
			'user' => 'root',
			'pass' => ''
		]
	);

}else{
	define("BASE_URL", "https://www.rsmbloqueador.com.br/");
	define("BASE_URL_PLATFORM", "https://gps.rsmbloqueador.com.br/");

	$configDB = array(
		'rsm' => [
			'host' => 'localhost',
			'name' => 'rsm_bloqueador',
			'user' => 'root',
			'pass' => '********'
		],

		'platform' => [
			'host' => 'localhost',
			'name' => 'traccar',
			'user' => 'root',
			'pass' => '********'
		]
	);
}