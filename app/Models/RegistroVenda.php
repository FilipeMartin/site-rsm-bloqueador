<?php
namespace Models;

use Exception;

class RegistroVenda {

	private $id;
	private $idUsuario;
	private $idVeiculo;
	private $plano;
	private $valorTotal;
	private $valorUnitario;
	private $quantidade;
	private $formaPagamento;
	private $dataVenda;
	private $statusData;
	private $status;

	public function __construct(array $data = array()){
		$this->id = $data['id'] ?? 0;
		$this->idUsuario = $data['idusuario'] ?? 0;
		$this->idVeiculo = $data['idveiculo'] ?? 0;
		$this->plano = $data['plano'] ?? 0;
		$this->valorTotal = $data['valortotal'] ?? 0;
		$this->valorUnitario = $data['valorunitario'] ?? 0;
		$this->quantidade = $data['quantidade'] ?? 0;
		$this->formaPagamento = $data['formapagamento'] ?? 0;
		$this->dataVenda = $data['datavenda'] ?? '';
		$this->statusData = $data['statusdata'] ?? '';
		$this->status = $data['status'] ?? 0;
	}

	public function getId(): int {
		return $this->id;
	}

	public function setIdUsuario(int $idUsuario){
		$this->validateIdUsuario($idUsuario);
	}

	public function getIdUsuario(): int {
		return $this->idUsuario;
	}

	public function setIdVeiculo(int $idVeiculo){
		$this->validateIdVeiculo($idVeiculo);
	}

	public function getIdVeiculo(): int {
		return $this->idVeiculo;
	}

	public function setPlano(int $plano){
		$this->validatePlano($plano);
	}

	public function getPlano(): int {
		return $this->plano;
	}

	public function setValorTotal(float $valorTotal){
		$this->validateValorTotal($valorTotal);
	}

	public function getValorTotal(): float {
		return $this->valorTotal;
	}

	public function setValorUnitario(float $valorUnitario){
		$this->validateValorUnitario($valorUnitario);
	}

	public function getValorUnitario(): float {
		return $this->valorUnitario;
	}

	public function setQuantidade(int $quantidade){
		$this->validateQuantidade($quantidade);
	}

	public function getQuantidade(): int {
		return $this->quantidade;
	}

	public function setFormaPagamento(int $formaPagamento){
		$this->validateFormaPagamento($formaPagamento);
	}

	public function getFormaPagamento(): int {
		return $this->formaPagamento;
	}

	public function getDataVenda(string $format = ''): string {
		$dataVenda = $this->dataVenda;

		if(!empty($format)){
			$dataVenda = date($format, strtotime($dataVenda));
		}
		return $dataVenda;
	}

	public function getStatusData(): string {
		return $this->statusData;
	}

	public function setStatus(int $status){
		$this->validateStatus($status);
	}

	public function getStatus(): int {
		return $this->status;
	}

	// Validar Atributos
	private function validateIdUsuario(int $idUsuario){
		
		if($idUsuario >= 0){
			$this->idUsuario = $idUsuario;
		} else{
			throw new Exception("Atributo [idUsuario] Inválido.");
		}

	}

	private function validateIdVeiculo(int $idVeiculo){
		
		if($idVeiculo >= 0){
			$this->idVeiculo = $idVeiculo;
		} else{
			throw new Exception("Atributo [idVeiculo] Inválido.");
		}

	}

	private function validatePlano(int $plano){
		
		if($plano >= 0){
			$this->plano = $plano;
		} else{
			throw new Exception("Atributo [plano] Inválido.");
		}

	}

	private function validateValorTotal(float $valorTotal){
		
		if($valorTotal >= 0){
			$this->valorTotal = $valorTotal;
		} else{
			throw new Exception("Atributo [valorTotal] Inválido.");
		}

	}

	private function validateValorUnitario(float $valorUnitario){
		
		if($valorUnitario >= 0){
			$this->valorUnitario = $valorUnitario;
		} else{
			throw new Exception("Atributo [valorUnitario] Inválido.");
		}

	}

	private function validateQuantidade(int $quantidade){
		
		if($quantidade >= 0){
			$this->quantidade = $quantidade;
		} else{
			throw new Exception("Atributo [quantidade] Inválido.");
		}

	}

	private function validateFormaPagamento(int $formaPagamento){
		
		if($formaPagamento >= 0){
			$this->formaPagamento = $formaPagamento;
		} else{
			throw new Exception("Atributo [formaPagamento] Inválido.");
		}

	}

	private function validateStatus(int $status){
		
		if($status >= 0){
			$this->status = $status;
		} else{
			throw new Exception("Atributo [status] Inválido.");
		}
		
	}

	// Funções
	public function getRegistroVendaArray(): array {

		$registroVenda = array(
			'id' => $this->id,
			'idUsuario' => $this->idUsuario,
			'idVeiculo' => base64_encode($this->idVeiculo),
			'plano' => $this->plano,
			'valorTotal' => $this->valorTotal,
			'valorUnitario' => $this->valorUnitario,
			'quantidade' => $this->quantidade,
			'formaPagamento' => $this->formaPagamento,
			'dataVenda' => $this->dataVenda,
			'statusData' => $this->statusData,
			'status' => $this->status
		);
		return $registroVenda;
	}

	public function getPlanoNome(): string {
		$plano = '';
		switch($this->plano){
			case 1: $plano = "Trimestral"; break;
			case 2: $plano = "Semestral"; break;
			case 3: $plano = "Anual";
		}
		return $plano;
	}

	public function getValorTotalMoeda(): string {
		$valorTotal = 'R$ 0,0';

		if($this->valorTotal > 0){
			$valorTotal = 'R$ '.str_replace('.',',',$this->valorTotal);
		}
		return $valorTotal;
	}

	public function getFormaPagamentoNome(): string {
		$formaPagamento = '';

		switch($this->formaPagamento){
			case 1: $formaPagamento = "Boleto Bancário"; break;
			case 2: $formaPagamento = "Cartão de Crédito";
		}
		return $formaPagamento;
	}

	public function getStatusNome(): string {
		$status = '';

		switch($this->status){
			case 1: 
				$status = "Em Aberto"; break;
			case 3: 
				$status = "Pago"; break;
			case 4: 
				$status = "Cancelado"; break;
			case 5: 
				$status = "Reembolsado";
		}
		return $status;
	}

	public function processarValores(array $valorPlanos){
		$valorTotal = 0;
		$valorUnitario = 0;
		$valorSemDesc = 0;
		$valorDesc = 0;

		if($this->getPlano() === 1){
			$valorSemDesc = $valorPlanos['valor_trimestral'][0];
			$valorDesc = $valorPlanos['valor_trimestral'][1];

		} else if($this->getPlano() === 2){
			$valorSemDesc = $valorPlanos['valor_semestral'][0];
			$valorDesc = $valorPlanos['valor_semestral'][1];

		} else if($this->getPlano() === 3){
			$valorSemDesc = $valorPlanos['valor_anual'][0];
			$valorDesc = $valorPlanos['valor_anual'][1];
		}

		// Formatar Valores para Float
		$valorSemDesc = floatval(str_replace(',','.',$valorSemDesc));
		$valorDesc = floatval(str_replace(',','.',$valorDesc));
		//-----------------------------------------------------------

		if($this->getQuantidade() === 1){
			$valorTotal = $valorSemDesc;
			$valorUnitario = $valorSemDesc;

		} else{
			$valorTotal = $valorDesc * $this->getQuantidade();
			$valorUnitario = $valorDesc;
		}

		$this->setValorTotal($valorTotal);
		$this->setValorUnitario($valorUnitario);
	}
	
}