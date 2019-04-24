<?php require_once '../app/Views/templates/templateAreaCliente.php' ?>

<nav class="ac_menu_topo">
	<div class="container column">
		<ul>
			<li><a href="<?=BASE_URL?>area_cliente/" alt="Área do Cliente" title="Área do Cliente">Área do Cliente</a></li>
			<li><a href="<?=BASE_URL?>area_cliente/veiculos/" alt="Veículos" title="Veículos">Veículos</a></li>
			<li><a href="<?=BASE_URL?>area_cliente/cadastrar_veiculo/" id="ac_menu_check" alt="Cadastrar" title="Cadastrar">Cadastrar</a></li>
			<li><a href="<?=BASE_URL?>area_cliente/faturas/" alt="Faturas" title="Faturas">Faturas</a></li>
			<li><a href="<?=BASE_URL?>area_cliente/minha_conta/" alt="Minha Conta" title="Minha Conta">Minha Conta</a></li>
		</ul>
	</div>
</nav>
<section id="conteudo">
	<div class="container">
		<div class="ac_info_content">
			<div class="ac_info_box">
				<div class="title icone_car_blue">
					<h1>Veículos</h1>
				</div>
				<a href="<?=BASE_URL?>area_cliente/veiculos/" class="item">
					<span>Total</span>
					<span class="badge total"><?=$infoBox['total']?></span>
				</a>
				<a href="<?=BASE_URL?>area_cliente/veiculos/ativo/" class="item">
					<span>Ativo</span>
					<span class="badge ativo"><?=$infoBox['ativo']?></span>
				</a>
				<a href="<?=BASE_URL?>area_cliente/veiculos/desabilitado/" class="item">
					<span>Desabilitado</span>
					<span class="badge"><?=$infoBox['desabilitado']?></span>
				</a>
				<a href="<?=BASE_URL?>area_cliente/cadastrar_veiculo/" class="item item_check">
					<span>Cadastrar</span>
					<span class="badge cadastrar"><?=$infoBox['cadastrar']?></span>
				</a>
			</div>
		</div>
		<div class="ac_main_content">
			<div class="ac_main_box">
				<div class="title">
					<h1><?=$title?></h1>
				</div>
				<?php if($infoBox['cadastrar'] > 0){ ?>
				<div class="register">
					<div class="title">
						<?php if($infoBox['cadastrar'] > 1){ ?>
						<h1><?=$infoBox['cadastrar']?> Veículos para Cadastrar</h1>
						<?php }else{ ?>
						<h1>1 Veículo para Cadastrar</h1>	
					    <?php } ?>
					</div>			
					<form id="form_register_vehicle" class="form_register_vehicle">
						<div class="custom-input">
					  		<label for="nome">Nome do Veículo</label>
							<input type="text" name="nome" id="nome">
						</div>
						<div class="input_line">
							<div class="custom-input input_imei">
						  		<label for="imei">IMEI</label>
								<input type="number" name="imei" id="imei">
							</div>
							<div class="custom-input">
						  		<label for="telefone">Telefone</label>
								<input type="text" name="telefone" id="telefone">
							</div>
						</div>
						<div class="input_line">
							<div class="custom-input input_model">
						  		<label for="modelo">Modelo</label>
								<input type="text" name="modelo" id="modelo">
							</div>
							<div class="custom-input">
								<select name="categoria" id="select_category">
									<option value="">Categoria</option>
									<option value="1">Avião</option>
									<option value="2">Barco</option>
									<option value="3">Bicicleta</option>
									<option value="4">Caminhão</option>
									<option value="5">Carro</option>
									<option value="6">Guindaste</option>
									<option value="7">Helicóptero</option>
									<option value="8">Motocicleta</option>
									<option value="9">Navio</option>
									<option value="10">Offroad</option>
									<option value="11">Ônibus</option>
									<option value="12">Pick-up</option>
									<option value="13">Trator</option>
									<option value="14">Van</option>
								</select>
							</div>
						</div>
						<div class="btn_register">
							<input type="submit" class="btn_green" value="Cadastrar">
						</div>
					</form>
					<div id="register_success" class="register_success">
						<h1>Veículo Cadastrado com Sucesso!</h1>
						<div class="itens"></div>
						<div class="btn_platform">
							<button class="btn_green">Logar na Plataforma</button>
						</div>	
						<div class="btn_prox_cadastro">	
							<button class="btn_blue">Cadastrar outro Veículo &#10154;</button>
						</div>
					</div>
				</div>
				<?php } ?>
			</div>
		</div>
	</div>
</section>