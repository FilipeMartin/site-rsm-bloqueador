<?php require_once '../app/Views/templates/templateAreaCliente.php' ?>

<nav class="ac_menu_topo">
	<div class="container column">
		<ul>
			<li><a href="<?=BASE_URL?>area_cliente/" alt="Área do Cliente" title="Área do Cliente">Área do Cliente</a></li>
			<li><a href="<?=BASE_URL?>area_cliente/veiculos/" alt="Veículos" title="Veículos">Veículos</a></li>
			<li><a href="<?=BASE_URL?>area_cliente/cadastrar_veiculo/" alt="Cadastrar" title="Cadastrar">Cadastrar</a></li>
			<li><a href="<?=BASE_URL?>area_cliente/faturas/" id="ac_menu_check" alt="Faturas" title="Faturas">Faturas</a></li>
			<li><a href="<?=BASE_URL?>area_cliente/minha_conta/" alt="Minha Conta" title="Minha Conta">Minha Conta</a></li>
		</ul>
	</div>
</nav>
<section id="conteudo">
	<div class="container">
		<div class="ac_info_content">
			<div class="ac_info_box">
				<div class="title icone_credit_card_blue">
					<h1>Faturas</h1>
				</div>
				<a href="<?=BASE_URL?>area_cliente/faturas/" class="item <?=(($infoBox['check'] == 0)?'item_check':'')?>">
					<span>Total</span>
					<span class="badge"><?=$infoBox['total']?></span>
				</a>
				<a href="<?=BASE_URL?>area_cliente/faturas/pago/" class="item <?=(($infoBox['check'] == 3)?'item_check':'')?>">
					<span>Pago</span>
					<span class="badge"><?=$infoBox['pago']?></span>
				</a>
				<a href="<?=BASE_URL?>area_cliente/faturas/em_aberto/" class="item <?=(($infoBox['check'] == 1)?'item_check':'')?>">
					<span>Em Aberto</span>
					<span class="badge"><?=$infoBox['emAberto']?></span>
				</a>
				<a href="<?=BASE_URL?>area_cliente/faturas/cancelado/" class="item <?=(($infoBox['check'] == 4)?'item_check':'')?>">
					<span>Cancelado</span>
					<span class="badge"><?=$infoBox['cancelado']?></span>
				</a>
				<a href="<?=BASE_URL?>area_cliente/faturas/reembolsado/" class="item <?=(($infoBox['check'] == 5)?'item_check':'')?>">
					<span>Reembolsado</span>
					<span class="badge"><?=$infoBox['reembolsado']?></span>
				</a>	
			</div>
		</div>
		<div class="ac_main_content">
			<div class="ac_main_box">
				<div class="title">
					<h1><?=$title?></h1>
				</div>
				<?php if(count($faturas) > 0){ ?>
				<div class="faturas">
					<table id="listar-faturas" class="data-table-display data_table">
						<thead>
				            <tr>
				                <th>Plano</th>
				                <th>Valor Total</th>
				                <th>Forma de Pagamento</th>
				                <th>Data</th>
				                <th>Status</th>
				            </tr>
				        </thead>
				        <tbody>
				        	<?php foreach($faturas as $fatura): ?>
				        	<tr>
				                <td><?=$fatura['plano']?></td>
				                <td><?=$fatura['valorTotal']?></td>
				                <td><?=$fatura['formaPagamento']?></td>
				                <td><?=$fatura['dataVenda']?></td>
				                <td><?=$fatura['status']?></td>
				            </tr>
				        	<?php endforeach; ?>
				        </tbody>
					</table>
					<div id="loading_table" class="loading_table">
						<h1>Carregando...</h1>
					</div>
				</div>
				<?php } ?>
			</div>
		</div>
	</div>
</section>