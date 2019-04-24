<?php
namespace Controllers;

use Core\Controller;

class SendemailController extends Controller {

	private $password;

	public function __construct(){
		parent::__construct();
		$this->password = '********';
	}

	public function index(){
		$this->loadView('404', array());
	}

	public function send(array $dados){

		if($dados[0] == $this->password && filter_var($dados[1], FILTER_VALIDATE_EMAIL)){
			$user = array(
            	'nome' => 'Usuário RSM',
            	'email' => $dados[1],
            	'assunto' => 'Teste de envio de E-mail',
            	'conteudoHtml' => '<h1>Teste de envio de E-mail.</h1>',
            	'conteudoTxt' => 'Teste de envio de E-mail.'
        	);

			if($this->email($user)){
				echo "<h3 style='font-family: Arial'>E-mail enviado com sucesso!</h3>";
			}
		} else{
			$this->loadView('404', array());
		}
	}
}