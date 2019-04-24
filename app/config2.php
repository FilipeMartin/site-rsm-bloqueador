<?php
global $configPlatform;
global $configEmail;
global $configCurl;
global $configPagseguro;

$configPlatform = array(

	// Agendamento no Crontab
	'password' => '********',
	'ipServer' => '191.252.194.49',
	//===========================================

	// Data para a limpeza do BD da Plataforma
	'data' => '-30',
	'dateFormat' => 'Y-m-d'
	//===========================================
);

$configEmail = array(

	// Configuração do SMTP
    'host' => 'smtp.gmail.com',
    'userName' => 'rsmbloqueador@gmail.com',
    'password' => '********',
    'smtpSecure' => 'ssl',
    'porta' => '465',
    'emailRemetente' => 'rsmbloqueador@gmail.com',
    'nomeRemetente' => 'RSM Bloqueador',
    //============================================   

    // Configuração do Server Email
    'emailServer' => 'filipe_loiola@hotmail.com'
    //============================================  
);

$configCurl = array(

	// Plataforma API
    'user' => 'admin',
    'password' => '********' 
    //============================================
);

$configPagseguro = array(

    // Configuração do Pagseguro

    // Production == true || Sandbox == false
    'environment' => false,
    //============================================

	// Credenciais
    'email' => 'rsmbloqueador@gmail.com',
    'token' => '********',
    'tokenSandbox' => '********',
    'emailUserSandbox' => 'c71678280901519598164@sandbox.pagseguro.com.br'
    //====================================================================
);