<?php require_once '../app/Views/templates/templateAreaCliente.php' ?>

<nav class="ac_menu_topo">
	<div class="container column">
		<ul>
			<li><a href="<?=BASE_URL?>area_cliente/" alt="Área do Cliente" title="Área do Cliente">Área do Cliente</a></li>
			<li><a href="<?=BASE_URL?>area_cliente/veiculos/" id="ac_menu_check" alt="Veículos" title="Veículos">Veículos</a></li>
			<li><a href="<?=BASE_URL?>area_cliente/cadastrar_veiculo/" alt="Cadastrar" title="Cadastrar">Cadastrar</a></li>
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
				<a href="<?=BASE_URL?>area_cliente/veiculos/" class="item <?=(($infoBox['check'] == 0)?'item_check':'')?>">
					<span>Total</span>
					<span class="badge"><?=$infoBox['total']?></span>
				</a>
				<a href="<?=BASE_URL?>area_cliente/veiculos/ativo/" class="item <?=(($infoBox['check'] == 1)?'item_check':'')?>">
					<span>Ativo</span>
					<span class="badge"><?=$infoBox['ativo']?></span>
				</a>
				<a href="<?=BASE_URL?>area_cliente/veiculos/desabilitado/" class="item <?=(($infoBox['check'] == 2)?'item_check':'')?>">
					<span>Desabilitado</span>
					<span class="badge"><?=$infoBox['desabilitado']?></span>
				</a>
				<a href="<?=BASE_URL?>area_cliente/cadastrar_veiculo/" class="item">
					<span>Cadastrar</span>
					<span class="badge"><?=$infoBox['cadastrar']?></span>
				</a>
			</div>
		</div>
		<div class="ac_main_content">
			<div class="ac_main_box">
				<div class="title">
					<h1><?=$title?></h1>
				</div>
				<?php if(count($vehicles) > 0){ ?>
				<div class="vehicles">
					<?php foreach($vehicles as $vehicle): ?>
					<details id="<?=$vehicle['vehicle']?>" <?=(($vehicle['vehicle'] == 1)?'open':'')?>>
						<summary  
							data-status="<?=(($vehicle['vehicle'] > 1)?'1':'0')?>"
							data-position="<?=$vehicle['positionId']?>">
							<h1><?=$vehicle['name']?></h1>
							<div class="txt_date">Data de Expiração -&nbsp;<div class="date <?=(!$vehicle['status']?'color_green':'color_red')?>"><?=$vehicle['expirationTime']?></div></div>
						</summary>
						<div class="buttons">
							<button class="<?=(!$vehicle['status']?'icone_status_true':'icone_status_false')?>">
								<h1>Status<br>&nbsp;</h1>
							</button>
							<button class="btn_renew_vehicle icone_calendar" data-vehicle="<?=$vehicle['id']?>">
								<h1>Renovar<br/>Plano</h1>
							</button>
							<button class="btn_edit_vehicle icone_edit"  	
								data-vehicle="<?=$vehicle['id']?>" 
								data-name="<?=$vehicle['name']?>" 
								data-imei="<?=$vehicle['imei']?>" 
								data-phone="<?=$vehicle['phone']?>" 
								data-model="<?=$vehicle['model']?>" 
								data-category="<?=$vehicle['category']?>">
								<h1>Editar<br>&nbsp;</h1>
							</button>
							<button class="icone_conf">
								<h1>Comandos<br/>Notificações</h1>
							</button>
						</div>
						<div class="position">
							<h1>Última Localização <b></b></h1>
							<div id="map<?=$vehicle['vehicle']?>" class="map <?=(empty($vehicle['positionId'])?'display_none':'')?>"></div>
							<div class="invalid_map <?=(!empty($vehicle['positionId'])?'display_none':'')?>">
								Localização Indisponível !
							</div>
						</div>
					</details>	
					<?php endforeach; ?>
				</div>
				<div class="edit_vehicle_screen">
					<div class="edit_vehicle">						
						<div class="title">
							<h1>Editar Veículo</h1>
							<div class="btn_close"></div>
						</div>			
						<form id="form_edit_vehicle" class="form_edit_vehicle">
							<div class="custom-input">
								<label for="nome" class="custom-input-off">Nome do Veículo</label>
								<input type="text" name="nome" id="nome">
							</div>
							<div class="input_line">
								<div class="custom-input input_imei">
									<label for="imei" class="custom-input-off">IMEI</label>
									<input type="number" name="imei" id="imei">
								</div>
								<div class="custom-input">
									<label for="telefone" class="custom-input-off">Telefone</label>
									<input type="text" name="telefone" id="telefone">
								</div>
							</div>
							<div class="input_line">
								<div class="custom-input input_model">
									<label for="modelo" class="custom-input-off">Modelo</label>
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
							<input type="hidden" name="veiculo" id="veiculo">
							<div class="btn_edit">
								<input type="submit" class="btn_green" value="Editar">
							</div>
						</form>
						<div id="edit_success" class="edit_success">
							<h1>Veículo Editado com Sucesso!</h1>
							<div class="itens"></div>
							<div class="buttons">
								<button class="btn_voltar btn_blue">Voltar</button>
								<button class="btn_fechar btn_green">Fechar</button>
							</div>	
						</div>					
					</div>
				</div>
				<?php } ?>	
			</div>
		</div>
	</div>
</section>