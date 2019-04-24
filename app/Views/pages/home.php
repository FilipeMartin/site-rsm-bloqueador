	<section id="banner">
		<div class="container column">
			<div class="banner_head_line">
				<div class="banner_area_title">
					<h1>Faça você mesmo o Rastreio e Bloqueio do seu Veículo!</h1>
				</div>
				<div class="banner_area_app">
					<h1>APP Exclusivo</h1>
					<h2>Rastreie seu veículo na palma da sua mão!</h2>
					<h2><a class="txt_baixar_app" href="https://play.google.com/store/apps/details?id=rsmbloqueador.com.br" alt="Baixe aqui o nosso app" title="Baixe aqui o nosso app" target="_blank">Baixe aqui o nosso app</a></h2>
					<a class="txt_baixar_app" href="https://play.google.com/store/apps/details?id=rsmbloqueador.com.br" alt="Baixe aqui o nosso app" title="Baixe aqui o nosso app" target="_blank">
					<img src="<?=BASE_URL?>assets/images/icone_play_store.png"/>
					</a>
				</div>
			</div>
			<div class="banner_options_header">
				<div class="banner_header1">
					<div class="banner_title">
						<h1>Plano Trimestral</h1>
						<p>Plataforma Online</p>
					</div>
					<div class="banner_valor_total">
						<span>R$ </span><span class="valor_trimestral"><?=$valor_trimestral[0]?></span> equivalente a
					</div>
				</div>

				<div class="banner_header2">
					<img src="<?=BASE_URL?>assets/images/placa_planos.png"/>
					<div class="banner_title" style="border-radius: 0;">
						<h1>Plano Semestral</h1>
						<p>Plataforma Online</p>
					</div>
					<div class="banner_header2_body">
						<div class="banner_valor_total">
							<span>R$ </span><span class="valor_semestral"><?=$valor_semestral[0]?></span> equivalente a
						</div>
					</div>
				</div>
				<div class="banner_header3">
					<div class="banner_title">
						<h1>Plano Anual</h1>
						<p>Plataforma Online</p>
					</div>
					<div class="banner_valor_total">
						<span>R$ </span><span class="valor_anual"><?=$valor_anual[0]?></span> equivalente a
					</div>
				</div>
			</div>
		</div>
	</section>
	
	<section id="conteudo">
		<div class="container column">
			<div class="banner_options_body">
				<div class="banner_body1">
					<div class="banner_valor">R$ <span class="valor_trimestral_mes"><?=$valor_trimestral_mes[0]?></span>/mês</div>
					<div class="txt_por_veiculo">por veículo</div>
					<div class="txt_servico_opcional">Serviço Opcional !</div>
					<div class="select_qtd_veiculos">
						<span>Informe a quantidade de veículos</span>
						<select id="select_trimestral">
							<option value="1">Plano para 1 veículo</option>
							<option value="2">Plano para mais de 1 veículo</option>
						</select>
					</div>
					<div class="btn_contratar">
						<button class="btn_contratar_agora">Contrate Agora</button>
					</div>
					<div class="banner_lista_inf">
						<ul>
							<li>Três meses de rastreamento</li>
							<li>Rastreamento online</li>
							<li>Rastreamento veícular <b>24h por dia</b></li>
						</ul>
					</div>
				</div>
				<div class="banner_body2">

					<div class="banner_header2 display">
						<div class="banner_title">
							<h1>Plano Semestral</h1>
							<p>Plataforma Online</p>
						</div>
						<div class="banner_valor_total">
							<span>R$ </span><span class="valor_semestral"><?=$valor_semestral[0]?></span> equivalente a
						</div>
					</div>

					<div class="banner_valor">R$ <span class="valor_semestral_mes"><?=$valor_semestral_mes[0]?></span>/mês</div>
					<div class="txt_por_veiculo">por veículo</div>
					<div class="txt_servico_opcional">Serviço Opcional !</div>
					<div class="select_qtd_veiculos">
						<span>Informe a quantidade de veículos</span>
						<select id="select_semestral">
							<option value="1">Plano para 1 veículo</option>
							<option value="2">Plano para mais de 1 veículo</option>
						</select>
					</div>
					<div class="btn_contratar">
						<button class="btn_contratar_agora">Contrate Agora</button>
					</div>
					<div class="banner_lista_inf">
						<ul>
							<li>Seis meses de rastreamento</li>
							<li>Rastreamento online</li>
							<li>Rastreamento veícular <b>24h por dia</b></li>
						</ul>
					</div>
				</div>
				<div class="banner_body3">

					<div class="banner_header3 display">
						<div class="banner_title">
							<h1>Plano Anual</h1>
							<p>Plataforma Online</p>
						</div>
						<div class="banner_valor_total">
							<span>R$ </span><span class="valor_anual"><?=$valor_anual[0]?></span> equivalente a
						</div>
					</div>

					<div class="banner_valor">R$ <span class="valor_anual_mes"><?=$valor_anual_mes[0]?></span>/mês</div>
					<div class="txt_por_veiculo">por veículo</div>
					<div class="txt_servico_opcional">Serviço Opcional !</div>
					<div class="select_qtd_veiculos">
						<span>Informe a quantidade de veículos</span>
						<select id="select_anual">
							<option value="1">Plano para 1 veículo</option>
							<option value="2">Plano para mais de 1 veículo</option>
						</select>
					</div>
					<div class="btn_contratar">
						<button class="btn_contratar_agora">Contrate Agora</button>
					</div>
					<div class="banner_lista_inf">
						<ul>
							<li>Um ano de rastreamento</li>
							<li>Rastreamento online</li>
							<li>Rastreamento veícular <b>24h por dia</b></li>
						</ul>
					</div>
				</div>
			</div>
			<div class="widget">
				<div class="widget_item">
					<div class="widget_item_body" style="display: flex; flex-direction: column; align-items: center">
						<img src="<?=BASE_URL?>assets/images/img_sms.png"/>
						<h1>Rastreamento via SMS</h1>
						<p>
							<b>O Rastreamento via SMS</b> é um serviço <b>sem mensalidade</b> que possibilita:
						</p>
						<div class="widget_item_desc widget_item_sms">
							<ul>
								<li>Localização e Bloqueio do seu Veículo</li>
								<li>Usando Operadora de Telefonia</li>
								<li>Escuta Espiã</li>
								<li>Monitoramento de Velocidade</li>
								<li>Entre outras Funções</li>
							</ul>
						</div>
						<p>Tudo isso através do nosso APP Exclusivo, disponível na <b>Play Store</b>.</p>
					</div>
				</div>
				<div class="widget_item">
					<div class="widget_item_body" style="display: flex; flex-direction: column; align-items: center">
						<img src="<?=BASE_URL?>assets/images/img_online.png"/>
						<h1>Rastreamento Online</h1>
						<p>
							<b>A Plataforma de Rastreamento Online</b> é um serviço que possibilita o rastreio e bloqueio do seu veículo quando e onde você quiser, de forma simples e fácil, e tudo isso através do seu computador, celular, tablet ou pelo nosso APP Exclusivo, disponível na <b>Play Store</b>.
						</p>
					</div>
				</div>
				<a class="txt_baixar_app" href="https://play.google.com/store/apps/details?id=rsmbloqueador.com.br" alt="Baixe aqui o nosso app" title="Baixe aqui o nosso app" target="_blank">
					<div class="widget_item">
						<div class="widget_item_body" style="display: flex; flex-direction: column; align-items: center">
							<img class="widget_img_app" src="<?=BASE_URL?>assets/images/img_smartphone.png"/>
							<div class="widget_item_app">APP RSM Bloqueador</div>
							<div class="widget_item_desc">
								<ul>
									<li>Localização do seu Veículo</li>
									<li>Bloqueio via SMS ou Internet</li>
									<li>Usando Operadora de Telefonia</li>
									<li>Escuta Espiã</li>
									<li>Monitoramento de Velocidade</li>
									<li>Entre outras Funções</li>
								</ul>
							</div>
						</div>
					</div>
				</a>
			</div>
		</div>
	</section>
	<section id="conteudo_youtube">
		<div class="container column">
			<h1>RSM - Plataforma Online</h1>
			<p>Apresentação da Plataforma de Rastreamento Online - RSM Bloqueador.</p>
			<div class="youtube_video">
				<iframe width="100%" height="490" src="https://www.youtube.com/embed/dbwKBt4NW0Q" frameborder="0" allow="autoplay; encrypted-media" allowfullscreen></iframe>
			</div>
		</div>	
	</section>