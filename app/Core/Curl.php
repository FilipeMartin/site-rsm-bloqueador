<?php
namespace Core;

class Curl {

    private $configCurl;

    public function __construct(){
        global $configCurl;
        $this->configCurl = $configCurl;
    }

    public function curl(array $config, array $data){

        $headers = array(
            'Content-Type:application/json',
            'Authorization: Basic '. base64_encode($this->configCurl['user'].":".$this->configCurl['password'])
        );

        $data = json_encode($data);

        // Iniciar Curl
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $config['url']);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_POST, 0);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $config['method']);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_TIMEOUT, 30);

        // Executar Curl
        $result = curl_exec($ch);
        //-----------------------

        // Resposta da Requisição
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        //------------------------------------------------

        // Fechar Conexão
        curl_close($ch);
        //---------------

        if($httpCode == 200 || $httpCode == 204){
            if($httpCode == 204){
                return true;
            }
            return json_decode($result);
        }
        return false;
    }
}