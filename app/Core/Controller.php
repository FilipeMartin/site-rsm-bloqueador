<?php
namespace Core;

use Models\User;
use Models\UserPlatform;
use DAO\ValorPlanoDAO;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

abstract class Controller extends Curl {

    private $configEmail;
    private $configPagseguro;

    public function __construct(){
        parent::__construct();
        global $configEmail;
        global $configPagseguro;
        $this->configEmail = $configEmail;
        $this->configPagseguro = $configPagseguro;
    }

	protected function loadView(string $viewName, array $viewData = array()){
		extract($viewData);
		require_once '../app/Views/pages/'.$viewName.'.php';	
	}

	protected function loadTemplate(string $viewName, array $viewData = array()){
        $valorPlanoDAO = new ValorPlanoDAO();
        $templateData = array();

        $templateData = $valorPlanoDAO->getValores();
        $templateData['statusLogin'] = $this->statusLogin();
        $templateData['pagseguroEnvironment'] = (($this->configPagseguro['environment']) ? '' : 'sandbox.');

        extract($templateData);
		require_once '../app/Views/templates/template.php';
	}

	protected function loadViewInTemplate(string $viewName, array $viewData = array()){
		extract($viewData);
		require_once '../app/Views/pages/'.$viewName.'.php';	
	}

    protected function statusLogin(){
        if(!empty($_SESSION['user']['session']) && $_SESSION['user']['session'] === true){
            return true;
        }
        return false;
    }

    protected function user(): User {
        $user = new User();

        if($this->statusLogin()){
            $user = unserialize($_SESSION['user']['data']);
        }
        return $user;
    }

    protected function newToken(){
        $token = password_hash(rand(99,999), PASSWORD_DEFAULT);
        return $token;
    }

	protected function email(array $user): bool {

        $mail = new PHPMailer(true);                                    // A passagem de `true` habilita exceções

        try {
            // Configurações do servidor
            //$mail->SMTPDebug = 2;                                     // Ativar saída de depuração detalhada
            $mail->isSMTP();                                            // Definir mailer para usar o SMTP
            $mail->CharSet = 'UTF-8';                                   // Aceitar codificação UTF-8
            $mail->Host = $this->configEmail['host'];                   // Especifique servidores SMTP principais e de backup
            $mail->SMTPAuth = true;                                     // Ativar autenticação SMTP
            $mail->Username = $this->configEmail['userName'];           // Nome de usuário SMTP
            $mail->Password = $this->configEmail['password'];           // Senha SMTP
            $mail->SMTPSecure = $this->configEmail['smtpSecure'];       // Ativar criptografia TLS, `ssl` também aceita
            $mail->Port = $this->configEmail['porta'];                  // Porta TCP para conectar-se

            // Configurar idioma
            $mail->setLanguage('pt_br', '../app/dependencies/vendor/phpmailer/phpmailer/language/');

            // Definir o remetente
            $mail->From = $this->configEmail['emailRemetente'];         // E-mail do Remetente    
            $mail->FromName = $this->configEmail['nomeRemetente'];      // Nome do Remetente

            // Definir os destinatário(s)
            $mail->addAddress($user['email'], $user['nome']);           // Adicionar um destinatário, o nome é opcional
            //$mail->setFrom('from@example.com', 'Mailer');
            //$mail->addReplyTo('info@example.com', 'Information');
            //$mail->addCC('rsmbloqueador@gmail.com', 'Eu');            // Enviar uma cópia do E-mail
            //$mail->addBCC('bcc@example.com');                         // Enviar uma cópia do E-mail oculta       

            // Anexos
            //$mail->addAttachment('/var/tmp/file.tar.gz');             // Adicionar Anexos
            //$mail->addAttachment('/tmp/image.jpg', 'new.jpg');        // Nome opcional

            // Conteúdo
            $mail->isHTML(true);                                        // Definir formato de email para HTML
            $mail->Subject = $user['assunto'];                          // Título do E-mail
            $mail->Body    = $user['conteudoHtml'];                     // Este é o corpo da mensagem em HTML
            $mail->AltBody = $user['conteudoTxt'];                      // Este é o corpo da mensagem em texto

            if($mail->send()){
                return true;
            }
            return false;

        } catch (Exception $e) {
            echo 'A mensagem não pôde ser enviada!<br/><br/>Error: '.$mail->ErrorInfo;
            return false;
        }
	}

    protected function serverEmail(string $assunto, string $conteudo){

        $user = array(
            'nome' => $this->configEmail['nomeRemetente'],
            'email' => $this->configEmail['emailServer'],
            'assunto' => $assunto,
            'conteudoHtml' => $conteudo.'<br/><br/>Data: '.date("d/m/Y \à\s h:i:s"),
            'conteudoTxt' => $conteudo.'<br/><br/>Data: '.date("d/m/Y \à\s h:i:s")
        );

        $this->email($user);
    }

    protected function sessionDestroy(){
        session_destroy();
        unset($_SESSION);
        session_start();
    }
}