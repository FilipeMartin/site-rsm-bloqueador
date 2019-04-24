<?php require_once '../app/Views/templates/templateAreaCliente.php' ?>

<nav class="ac_menu_topo">
	<div class="container column">
		<ul>
			<li><a href="<?=BASE_URL?>area_cliente/" id="ac_menu_check" alt="Área do Cliente" title="Área do Cliente">Área do Cliente</a></li>
			<li><a href="<?=BASE_URL?>area_cliente/veiculos/" alt="Veículos" title="Veículos">Veículos</a></li>
			<li><a href="<?=BASE_URL?>area_cliente/cadastrar_veiculo/" alt="Cadastrar" title="Cadastrar">Cadastrar</a></li>
			<li><a href="<?=BASE_URL?>area_cliente/faturas/" alt="Faturas" title="Faturas">Faturas</a></li>
			<li><a href="<?=BASE_URL?>area_cliente/minha_conta/" alt="Minha Conta" title="Minha Conta">Minha Conta</a></li>
		</ul>
	</div>
</nav>
<section id="conteudo">
	<div class="container column">
		<div class="ac_painel_title">
			<h1>Painel de Informações</h1>
		</div>
		<div class="ac_painel">
			<a href="">
				<div class="ac_painel_item icone_cube">
					<div class="number"><?=$infoBox['servicos']?></div>
					<div class="title">Serviços</div>
					<div class="highlight bg-color-blue"></div>
				</div>
			</a>
			<a href="<?=BASE_URL?>area_cliente/veiculos/">
				<div class="ac_painel_item icone_car">
					<div class="number"><?=$infoBox['veiculo']['total']?></div>
					<div class="title">Veículos</div>
					<div class="highlight bg-color-green"></div>
				</div>
			</a>
			<a href="<?=BASE_URL?>area_cliente/cadastrar_veiculo/">
				<div class="ac_painel_item icone_car">
					<div class="number"><?=$infoBox['veiculo']['cadastrar']?></div>
					<div class="title">Cadastrar</div>
					<div class="highlight bg-color-red"></div>
				</div>
			</a>
			<a href="<?=BASE_URL?>area_cliente/faturas/em_aberto/">
				<div class="ac_painel_item icone_credit_card">
					<div class="number"><?=$infoBox['faturas']?></div>
					<div class="title">Faturas</div>
					<div class="highlight bg-color-gold"></div>				
				</div>
			</a>
		</div>
	</div>
</section>