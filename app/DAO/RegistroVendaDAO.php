<?php
namespace DAO;

use PDO;
use PDOException;
use Models\User;
use Models\AppUser;
use Models\RegistroVenda;

class RegistroVendaDAO {

	private $db;

	public function __construct(){
		$dataBase = new ConnectionDB();
		$this->db = $dataBase->connect('rsm');
	}

	public function adicionar(User $user, RegistroVenda $registroVenda, array $token, bool $newUser): array {
		$resposta = array('status' => false);

		// Criptografar Senha
		$user->setPassword(password_hash($user->getPassword(), PASSWORD_BCRYPT));
		//-----------------------------------------------------------------------

		try{
			//Iniciar Transação
			$this->db->beginTransaction();

			if($newUser){
				// Cadastrar Usuário
				$query = "INSERT INTO `users` SET 
							`name` = :name, 
							`datebirth` = :dateBirth, 
							`cpf` = :cpf, 
							`email` = :email, 
							`login` = :login, 
							`password` = :password, 
							`cellphone` = :cellPhone, 
							`phone` = :phone, 
							`zipcode` = :zipCode, 
							`state` = :state, 
							`city` = :city, 
							`neighborhood` = :neighborhood, 
							`address` = :address, 
							`addressnumber` = :addressNumber, 
							`complement` = :complement, 
							`serviceterms` = :serviceTerms;";

				$query = $this->db->prepare($query);
				$query->bindValue(":name", $user->getName());
				$query->bindValue(":dateBirth", $user->getDateBirth());
				$query->bindValue(":cpf", $user->getCpf());
				$query->bindValue(":email", $user->getEmail());
				$query->bindValue(":login", $user->getLogin());
				$query->bindValue(":password", $user->getPassword());
				$query->bindValue(":cellPhone", $user->getCellPhone());
				$query->bindValue(":phone", $user->getPhone());
				$query->bindValue(":zipCode", $user->getZipCode());
				$query->bindValue(":state", $user->getState());
				$query->bindValue(":city", $user->getCity());
				$query->bindValue(":neighborhood", $user->getNeighborhood());
				$query->bindValue(":address", $user->getAddress());
				$query->bindValue(":addressNumber", $user->getAddressNumber());
				$query->bindValue(":complement", $user->getComplement());
				$query->bindValue(":serviceTerms", $user->getServiceTerms());
				$query->execute();
				
				$idUser = $this->db->lastInsertId();

				// Relacionar com a tabela app_users
				$appUser = new AppUser();
				$appUser->setId($idUser);
				$appUser->setLastUpdate(time());
				$appUser->setToken(md5($user->getEmail().$user->getCpf().rand(99,999)));	
				$appUser->setSession(md5(rand(99,999)));

				$query = "INSERT INTO `app_users` SET 
							`iduser` = :idUser, 
							`lastupdate` = :lastUpdate, 
							`token` = :token, 
							`session` = :session, 
							`platformtoken` = :platformToken;";

				$query = $this->db->prepare($query);
				$query->bindValue(":idUser", $appUser->getId());
				$query->bindValue(":lastUpdate", $appUser->getLastUpdate());
				$query->bindValue(":token", $appUser->getToken());
				$query->bindValue(":session", $appUser->getSession());
				$query->bindValue(":platformToken", $appUser->getPlatformToken());
				$query->execute();

				// Cadastrar Token
				$query = "INSERT INTO `tokens` SET `iduser` = :idUser, `type` = :type, `token` = :token;";
				$query = $this->db->prepare($query);
				$query->bindValue(":idUser", $idUser);
				$query->bindValue(":type", $token['type']);
				$query->bindValue(":token", $token['token']);
				$query->execute();
			
			} else{
				$idUser = $user->getId();
			}

			// Cadastrar Venda
			$query = "INSERT INTO `registro_vendas` SET 
						`idusuario` = :idUsuario, 
						`idveiculo` = :idVeiculo, 
						`plano` = :plano, 
						`valortotal` = :valorTotal, 
						`valorunitario` = :valorUnitario, 
						`quantidade` = :quantidade, 
						`formapagamento` = :formaPagamento;";

			$query = $this->db->prepare($query);
			$query->bindValue(":idUsuario", $idUser);
			$query->bindValue(":idVeiculo", $registroVenda->getIdVeiculo());
			$query->bindValue(":plano", $registroVenda->getPlano());
			$query->bindValue(":valorTotal", $registroVenda->getValorTotal());	
			$query->bindValue(":valorUnitario", $registroVenda->getValorUnitario());
			$query->bindValue(":quantidade", $registroVenda->getQuantidade());
			$query->bindValue(":formaPagamento", $registroVenda->getFormaPagamento());	
			$query->execute();	

			$idVenda = $this->db->lastInsertId();

			// Finalizar Transação	
			if($this->db->commit()){
				$resposta['status'] = true;
				$resposta['idVenda'] = $idVenda;
			}

		} catch(PDOException $e){
			// Cancelar Transação
			$this->db->rollBack();
			echo "ERROR: ".$e->getMessage();
		}
		return $resposta;
	}

	public function getVendas(int $idUser): array {
		$registers = array();

		try{
			$query = "SELECT *, `status` as `idstatus` FROM `registro_vendas` 
						WHERE `idusuario` = :idUser AND `status` >= 1 AND `status` <= 5;";
			$query = $this->db->prepare($query);
			$query->bindValue(":idUser", $idUser);
			$query->execute();

			if($query->rowCount() > 0){

				$query = $query->fetchAll(PDO::FETCH_ASSOC);

				foreach($query as $register){
					$registers[] = new RegistroVenda($register);
				}
			}

		} catch(PDOException $e){
			echo "ERROR: ".$e->getMessage();
		}	
		return $registers;
	}

	public function getVenda(int $idVenda) {
		$registroVenda = null;

		try{
			$query = "SELECT * FROM `registro_vendas` WHERE `id` = :id;";
			$query = $this->db->prepare($query);
			$query->bindValue(":id", $idVenda);
			$query->execute();

			if($query->rowCount() > 0){
				$registroVenda = new RegistroVenda($query->fetch(PDO::FETCH_ASSOC));
			}

		} catch(PDOException $e){
			echo "ERROR: ".$e->getMessage();
		}	
		return $registroVenda;
	}

	public function getVendasAberta(int $idUser): int {
		$faturas = 0;

		try{
			$query = "SELECT count(*) as `qtd` FROM `registro_vendas` 
						WHERE `idusuario` = :idUser AND `status` = 1;";

			$query = $this->db->prepare($query);
			$query->bindValue(":idUser", $idUser);
			$query->execute();

			if($query->rowCount() > 0){
				$query = $query->fetch(PDO::FETCH_ASSOC);
				$faturas = $query['qtd'];
			}			

		} catch(PDOException $e){
			echo "ERROR: ".$e->getMessage();
		}
		return $faturas;
	}

	public function editarStatus(RegistroVenda $registroVenda): bool {
		$status = false;

		try{
			$query = "UPDATE `registro_vendas` SET 
						`status` = :status, `statusdata` = NOW() 
						WHERE `id` = :id;";

			$query = $this->db->prepare($query);
			$query->bindValue(":id", $registroVenda->getId());
			$query->bindValue(":status", $registroVenda->getStatus());	
			$query->execute();

			if($query->rowCount() > 0){
				$status = true;
			}		

		} catch(PDOException $e){
			echo "ERROR: ".$e->getMessage();
		}
		return $status;
	}
}