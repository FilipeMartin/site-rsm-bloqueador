<?php
namespace DAO;

use PDO;
use PDOException;

class ValorPlanoDAO {

	public function __construct(){

	}

	public function getValores(): array {
		
		$valores = array(
			// Valor total do Plano
            'valor_trimestral'    => ['45,00', '40,00'],
            'valor_semestral'     => ['72,00', '62,00'],
            'valor_anual'         => ['120,00', '100,00'],
            //--------------------------------------------

            // Valor do Plano equivalente a um mes
            'valor_trimestral_mes'=> ['15,00', '13,35'],
            'valor_semestral_mes' => ['12,00', '10,35'],
            'valor_anual_mes'     => ['10,00', '8,35']
            //--------------------------------------------
        );

        return $valores;
	}

}