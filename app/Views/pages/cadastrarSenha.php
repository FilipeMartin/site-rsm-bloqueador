<section class="ac_banner">
	<div class="container column">
		<div class="ac_banner_title">
			<h1>ÁREA DO CLIENTE</h1>
			<p>Olá, <?=$user['firstName']?>!</p>
		</div>
	</div>
</section>
<section id="conteudo">
	<div class="container">
		<div class="recuperar_senha_box">
			<div class="edit_password">
				<form id="form_edit_password" class="form_edit_password">
					<div class="cadastro_item">
						<div class="box">
							<div class="item_1">
								<h1>Cadastrar Senha</h1>
								<div class="custom-input">
				  					<label for="senha">Senha</label>
									 <input type="password" name="senha" id="senha" maxlength="14">
								</div>
								<div class="custom-input">
				  					<label for="confirmar_senha">Confirmar senha</label>
									 <input type="password" name="confirmar_senha" id="confirmar_senha" maxlength="14">
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
						<input type="hidden" name="token" value="<?=$user['token']?>">
						<div class="btn_edit">
							<input type="submit" class="btn_green" value="Cadastrar Senha">
						</div>
					</div>
				</form>	
				<div id="edit_success_password" class="edit_success">
					<div class="cadastro_item">
						<div class="edit_success_box">
							<h1><?=$user['firstName']?>, sua senha foi cadastrada com sucesso!</h1>
							<button class="btn_login_user btn_blue">Área do Cliente</button>
						</div>
					</div>
				</div>
			</div>
		</div>	
	</div>
</section>