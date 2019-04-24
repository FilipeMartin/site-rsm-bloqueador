<?php require_once '../app/Views/templates/templateAreaCliente.php' ?>

<nav class="ac_menu_topo">
	<div class="container column">
		<ul>
			<li><a href="<?=BASE_URL?>area_cliente/" alt="Área do Cliente" title="Área do Cliente">Área do Cliente</a></li>
			<li><a href="<?=BASE_URL?>area_cliente/veiculos/" alt="Veículos" title="Veículos">Veículos</a></li>
			<li><a href="<?=BASE_URL?>area_cliente/cadastrar_veiculo/" alt="Cadastrar" title="Cadastrar">Cadastrar</a></li>
			<li><a href="<?=BASE_URL?>area_cliente/faturas/" alt="Faturas" title="Faturas">Faturas</a></li>
			<li><a href="<?=BASE_URL?>area_cliente/minha_conta/" id="ac_menu_check" alt="Minha Conta" title="Minha Conta">Minha Conta</a></li>
		</ul>
	</div>
</nav>
<section id="conteudo">
	<div class="container">
		<div class="ac_info_content">
			<div class="ac_info_box">
				<div class="title icone_user_blue">
					<h1>Perfil</h1>
				</div>
				<a href="<?=BASE_URL?>area_cliente/minha_conta/" class="item <?=(($infoBox['check'] == 0)?'item item_check':'')?>">
					<span>Meus Dados</span>
				</a>
				<a href="<?=BASE_URL?>area_cliente/minha_conta/alterar_senha/" class="item <?=(($infoBox['check'] == 1)?'item item_check':'')?>">
					<span>Alterar senha</span>
				</a>
			</div>
		</div>
		<div class="ac_main_content">
			<div class="ac_main_box">
				<div class="title">
					<h1><?=$title?></h1>
				</div>
				<div class="edit_my_data <?=(($infoBox['check'] == 1)?'display_none':'')?>">
					<form id="form_edit_user" class="form_edit_user">
						<div class="cadastro_item">
							<h1>Meus Dados</h1>
							<div class="cadastro_row">
								<div class="custom-input input_nome">
			  						<label for="nome" class="custom-input-off">Nome Completo</label>
								 	<input type="text" name="nome" id="nome" value="<?=$editUser['name']?>">
								</div>
								<div class="custom-input input_data_nasc">
			  						<label for="data_nasc" class="custom-input-off">Data de Nascimento</label>
								 	<input type="date" name="dataNasc" id="data_nasc" value="<?=$editUser['dateBirth']?>">
								</div>
							</div>	
							<div class="custom-input input_cpf">
		  						<label for="cpf" class="custom-input-off">CPF</label>
							 	<input type="text" name="cpf" id="cpf" data-cpf="<?=$editUser['cpf']?>" value="<?=$editUser['cpf']?>">
							</div>
						</div>
						<div class="cadastro_item">
							<h1>ENDEREÇO</h1>
							<div class="cadastro_row">
								<div class="custom-input input_cep">
			  						<label for="cep" class="custom-input-off">CEP</label>
								 	<input type="text" name="cep" id="cep" value="<?=$editUser['zipCode']?>">
								</div>
								<div class="buscar_cep">
									<a href="http://www.buscacep.correios.com.br/servicos/dnec/index.do" target="_blank">Não sei meu CEP</a>
								</div>
							</div>
							<div class="custom-input">
		  						<label for="endereco" class="custom-input-off">Endereço</label>
							 	<input type="text" name="endereco" id="endereco" value="<?=$editUser['address']?>">
							</div>
							<div class="cadastro_row">
								<div class="custom-input input_numero">
			  						<label for="numero" class="custom-input-off">Número</label>
								 	<input type="text" name="numero" id="numero" value="<?=$editUser['addressNumber']?>">
								</div>
								<div class="custom-input input_complemento">
			  						<label for="complemento" class="custom-input-off">Complemento (opcional)</label>
								 	<input type="text" name="complemento" id="complemento" value="<?=$editUser['complement']?>">
								</div>	
							</div>
							<div class="cadastro_row">
								<div class="custom-input input_bairro">
			  						<label for="bairro" class="custom-input-off">Bairro (opcional)</label>
								 	<input type="text" name="bairro" id="bairro" value="<?=$editUser['neighborhood']?>">
								</div>
								<div class="custom-input input_cidade">
			  						<label for="cidade" class="custom-input-off">Cidade</label>
								 	<input type="text" name="cidade" id="cidade" value="<?=$editUser['city']?>">
								</div>
								<div class="custom-input input_estado">
									<select name="estado" id="estado">
										<option value="">Estado</option>
										<?php foreach($states as $state): ?>
										<option value="<?=$state?>" <?=(($editUser['state'] == $state)?'selected':'')?>><?=$state?></option>
										<?php endforeach; ?>
									</select>
								</div>
							</div>	
						</div>
						<div class="cadastro_item">
							<h1>Contato</h1>
							<p>Informe um e-mail válido, pois ele será utilizado para logar na plataforma !</p>
							<div class="custom-input">
		  						<label for="email" class="custom-input-off">E-mail</label>
							 	<input type="email" name="email" id="email" data-email="<?=$editUser['email']?>" value="<?=$editUser['email']?>">
							</div>
							<div class="custom-input">
		  						<label for="confirmar_email" class="custom-input-off">Confirmar E-mail</label>
							 	<input type="email" name="confirmar_email" id="confirmar_email" value="<?=$editUser['email']?>">
							</div>
							<div class="custom-input input_celular">
		  						<label for="celular" class="custom-input-off">Celular</label>
							 	<input type="text" name="celular" id="celular" value="<?=$editUser['cellPhone']?>">
							</div>
							<div class="custom-input input_telefone">
		  						<label for="telefone" class="custom-input-off">Telefone</label>
							 	<input type="text" name="telefone" id="telefone" value="<?=$editUser['phone']?>">
							</div>
						</div>
						<div class="cadastro_item">
							<h1>Login</h1>
							<div class="custom-input">
		  						<label for="usuario" class="custom-input-off">Usuário</label>
							 	<input type="text" name="usuario" id="usuario" data-usuario="<?=$editUser['login']?>" value="<?=$editUser['login']?>">
							</div>
						</div>
						<div class="cadastro_item">
							<div class="btn_edit">
								<input type="submit" class="btn_green" value="Editar">
							</div>
						</div>
					</form>	
					<div id="edit_success_user" class="edit_success">
						<div class="cadastro_item">
							<div class="edit_success_box">
								<h1>Seus dados foram editados com sucesso!</h1>
								<button id="btn_fechar_user" class="btn_green">Fechar</button>
							</div>
						</div>
					</div>
				</div>
				<div class="edit_password <?=(($infoBox['check'] == 0)?'display_none':'')?>">
					<form id="form_edit_password" class="form_edit_password">
						<div class="cadastro_item">
							<div class="box">
								<div class="item_1">
									<h1>Alterar Senha</h1>
									<div class="custom-input">
				  						<label for="senha_atual">Senha atual</label>
									 	<input type="password" name="senha_atual" id="senha_atual" maxlength="14">
									 	<span class="msg_input_error"></span>
									</div>
									<div class="custom-input">
				  						<label for="nova_senha">Nova senha</label>
									 	<input type="password" name="nova_senha" id="nova_senha" maxlength="14">
									</div>
									<div class="custom-input">
				  						<label for="confirmar_nova_senha">Confirmar nova senha</label>
									 	<input type="password" name="confirmar_nova_senha" id="confirmar_nova_senha" maxlength="14">
									</div>
								</div>
								<div class="item_2">
									<div class="password_info_box">
										<h1>Dicas para uma boa senha</h1>
										<p>Use letras maiúsculas e minúsculas</p>
										<p>Incluir pelo menos um símbolo (# $ ! % & etc...)</p>
										<p>Não use palavras do dicionário</p>
									</div>
								</div>
							</div>
						</div>	
						<div class="cadastro_item">
							<div class="btn_edit">
								<input type="submit" class="btn_green" value="Alterar Senha">
							</div>
						</div>
					</form>	
					<div id="edit_success_password" class="edit_success">
						<div class="cadastro_item">
							<div class="edit_success_box">
								<h1>Sua senha foi alterada com sucesso!</h1>
								<button id="btn_fechar_password" class="btn_green">Fechar</button>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>