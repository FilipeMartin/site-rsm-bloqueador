<section id="conteudo">
	<div class="container_registro">
		<div class="registro">
			<div class="etapas_registro" data-etapa-registro="<?=$etapaRegistro?>">
				<div class="etapa_registro_item_1">
					<div class="circulo_body">
						<div class="circulo_externo"></div>
						<div class="circulo_interno">
							<div class="circulo_numero">1º</div>
							<img class="circulo_img" src="<?=BASE_URL?>assets/images/check.png"/>
						</div>	
					</div>
				</div>
				<div class="etapa_registro_item_2">
					<div class="barra_externa">
						<div class="barra_interna"></div>	
					</div>
				</div>
				<div class="etapa_registro_item_3">
					<div class="circulo_body">
						<div class="circulo_externo"></div>
						<div class="circulo_interno">
							<div class="circulo_numero">2º</div>
							<img class="circulo_img" src="<?=BASE_URL?>assets/images/check.png"/>
						</div>	
					</div>
				</div>
				<div class="etapa_registro_item_4">
					<div class="barra_externa">
						<div class="barra_interna"></div>	
					</div>
				</div>
				<div class="etapa_registro_item_5">
					<div class="circulo_body">
						<div class="circulo_externo"></div>
						<div class="circulo_interno">
							<div class="circulo_numero">3º</div>
							<img class="circulo_img" src="<?=BASE_URL?>assets/images/check.png"/>
						</div>	
					</div>
				</div>
			</div>
			<div class="desc_etapa">
				<div class="desc_etapa_1">Registrar Cliente</div>
				<div class="desc_etapa_2">Forma de Pagamento</div>
				<div class="desc_etapa_3">Finalizar Compra</div>
			</div>
			<div class="definir_cliente<?=($statusLogin?' display_none':'')?>">
				<div class="definir_cliente_item ckeck_cliente">Cadastre-se</div>
				<div class="definir_cliente_barra"></div>
				<div class="btn_login_user definir_cliente_item">Já sou Cliente</div>
			</div>
			<div class="cadastro<?=($statusLogin?' display_none':'')?>">
				<form id="form_cadastro">
					<div class="cadastro_item">
						<h1>Criar Conta</h1>
						<div class="cadastro_row">
							<div class="custom-input input_nome">
		  						<label for="nome" class="<?=(!empty($user['name'])?'custom-input-off':'')?>">Nome Completo</label>
							 	<input type="text" name="nome" id="nome" value="<?=$user['name']?>">
							</div>
							<div class="custom-input input_data_nasc">
		  						<label for="data_nasc" class="custom-input-off">Data de Nascimento</label>
							 	<input type="date" name="dataNasc" id="data_nasc" value="<?=$user['dateBirth']?>">
							</div>
						</div>	
						<div class="custom-input input_cpf">
	  						<label for="cpf" class="<?=(!empty($user['cpf'])?'custom-input-off':'')?>">CPF</label>
						 	<input type="text" name="cpf" id="cpf" value="<?=$user['cpf']?>">
						</div>
					</div>
					<div class="cadastro_item">
						<h1>ENDEREÇO</h1>
						<div class="cadastro_row">
							<div class="custom-input input_cep">
		  						<label for="cep" class="<?=(!empty($user['zipCode'])?'custom-input-off':'')?>">CEP</label>
							 	<input type="text" name="cep" id="cep" value="<?=$user['zipCode']?>">
							</div>
							<div class="buscar_cep">
								<a href="http://www.buscacep.correios.com.br/servicos/dnec/index.do" target="_blank">Não sei meu CEP</a>
							</div>
						</div>
						<div class="custom-input">
	  						<label for="endereco" class="<?=(!empty($user['address'])?'custom-input-off':'')?>">Endereço</label>
						 	<input type="text" name="endereco" id="endereco" value="<?=$user['address']?>">
						</div>
						<div class="cadastro_row">
							<div class="custom-input input_numero">
		  						<label for="numero" class="<?=(!empty($user['addressNumber'])?'custom-input-off':'')?>">Número</label>
							 	<input type="text" name="numero" id="numero" value="<?=$user['addressNumber']?>">
							</div>
							<div class="custom-input input_complemento">
		  						<label for="complemento" class="<?=(!empty($user['complement'])?'custom-input-off':'')?>">Complemento (opcional)</label>
							 	<input type="text" name="complemento" id="complemento" value="<?=$user['complement']?>">
							</div>	
						</div>
						<div class="cadastro_row">
							<div class="custom-input input_bairro">
		  						<label for="bairro" class="<?=(!empty($user['neighborhood'])?'custom-input-off':'')?>">Bairro (opcional)</label>
							 	<input type="text" name="bairro" id="bairro" value="<?=$user['neighborhood']?>">
							</div>
							<div class="custom-input input_cidade">
		  						<label for="cidade" class="<?=(!empty($user['city'])?'custom-input-off':'')?>">Cidade</label>
							 	<input type="text" name="cidade" id="cidade" value="<?=$user['city']?>">
							</div>
							<div class="custom-input input_estado">
								<select name="estado" id="estado">
									<option value="">Estado</option>
									<?php foreach($states as $state): ?>
									<option value="<?=$state?>" <?=(($user['state'] == $state)?'selected':'')?>><?=$state?></option>
									<?php endforeach; ?>
								</select>
							</div>
						</div>	
					</div>
					<div class="cadastro_item">
						<h1>Contato</h1>
						<p>Informe um e-mail válido, pois ele será utilizado para logar na plataforma !</p>
						<div class="custom-input">
	  						<label for="email" class="<?=(!empty($user['email'])?'custom-input-off':'')?>">E-mail</label>
						 	<input type="email" name="email" id="email" value="<?=$user['email']?>">
						</div>
						<div class="custom-input">
	  						<label for="confirmar_email" class="<?=(!empty($user['email'])?'custom-input-off':'')?>">Confirmar E-mail</label>
						 	<input type="email" name="confirmar_email" id="confirmar_email" value="<?=$user['email']?>">
						</div>
						<div class="custom-input input_celular">
	  						<label for="celular" class="<?=(!empty($user['cellPhone'])?'custom-input-off':'')?>">Celular</label>
						 	<input type="text" name="celular" id="celular" value="<?=$user['cellPhone']?>">
						</div>
						<div class="custom-input input_telefone">
	  						<label for="telefone" class="<?=(!empty($user['phone'])?'custom-input-off':'')?>">Telefone</label>
						 	<input type="text" name="telefone" id="telefone" value="<?=$user['phone']?>">
						</div>
					</div>
					<div class="cadastro_item">
						<h1>Dados de Acesso</h1>
						<div class="custom-input">
	  						<label for="usuario" class="<?=(!empty($user['login'])?'custom-input-off':'')?>">Usuário</label>
						 	<input type="text" name="usuario" id="usuario" value="<?=$user['login']?>">
						</div>
						<div class="custom-input input_senha">
	  						<label for="senha" class="<?=(!empty($user['password'])?'custom-input-off':'')?>">Senha</label>
						 	<input type="password" name="senha" id="senha" maxlength="14" value="<?=$user['password']?>">
						</div>
						<div class="custom-input input_senha">
	  						<label for="confirmar_senha" class="<?=(!empty($user['password'])?'custom-input-off':'')?>">Confirmar senha</label>
						 	<input type="password" name="confirmar_senha" id="confirmar_senha" maxlength="14" value="<?=$user['password']?>">
						</div>
					</div>
					<div class="cadastro_item">
						<div class="termos_servico">
							<div class="termos_servico_box">
								<input type="checkbox" name="termosServicoCheck" id="termos_servico_check" <?=(($user['serviceTerms'] == 1)?'checked':'')?>>
							</div>

							<p>Eu li e concordo com os <a href="" alt="Termos de Serviço" title="Termos de Serviço" target="_blank"><b>Termos de Serviço</b></a> e <a href="" alt="Política de Privacidade" title="Política de Privacidade" target="_blank"><b>Política de Privacidade.</b></a></p>

						</div>
						<div class="btn_prox_cadastrar">
							<input type="submit" class="btn_blue" value="Próximo &#10154;">
						</div>
					</div>
				</form>
			</div>
			<div class="forma_pagamento<?=($statusLogin?' display_flex':'')?>" data-forma-pagamento="<?=$dadosVenda['formaPagamento']?>">
				<h1>Escolha um método de pagamento</h1>
				<div class="box_forma_pagamento">
					<div id="btn_boleto" class="btn_forma_pagamento<?=(($dadosVenda['formaPagamento'] == 1)?' box_forma_pagamento_check':'')?>" alt="Boleto Bancário" title="Boleto Bancário">
						<div class="check">
						 	<div class="check_checked<?=(($dadosVenda['formaPagamento'] == 1)?' check_checked_viability':'')?>"></div>
						</div>
							<img src="<?=BASE_URL?>assets/images/img_boleto.png"/>
					</div>
					<p>OU</p>
					<div id="btn_cartao" class="btn_forma_pagamento<?=(($dadosVenda['formaPagamento'] == 2)?' box_forma_pagamento_check':'')?>" alt="Cartão de Crédito" title="Cartão de Crédito">
						<div class="check">
						 	<div class="check_checked<?=(($dadosVenda['formaPagamento'] == 2)?' check_checked_viability':'')?>"></div>
						</div>
							<img src="<?=BASE_URL?>assets/images/img_cartao_credito.png"/>
					</div>
				</div>
				<div class="btn_prox_forma_pag">
					<input class="btn_registrar_voltar btn_blue<?=($statusLogin?' display_none':'')?>" date-btn_registrar_voltar='1' type="submit" value="Voltar">
					<input type="submit" id="btn_forma_pagamento" class="btn_blue" <?=($statusLogin?'style="margin-left: 200px"':'')?> value="Próximo &#10154;">
				</div>
			</div>
			<div class="finalizar_compra">
				<h1>Filipe está quase terminando !</h1>
				<p>O seu cadastro será realizado assim que finalizar a compra.</p>
				<!-- <div class="caixa-capche" id="caixa-capche">
                    <div class="g-recaptcha" id="recaptchaContainer"></div>   
                </div> -->
				<div class="btn_finalizar_compra">
					<input class="btn_registrar_voltar btn_blue" date-btn_registrar_voltar='2' type="submit" value="Voltar">
					<form id="form_finalizar_compra">
						<input type="hidden" name="token_purchase" value="<?=$tokenPurchase?>">
						<input type="submit" id="btn_finalizar_compra" class="btn_green" value="Finalizar Compra">
					</form>
				</div>
			</div>
		</div>
		<div class="resumo_compra_body">
			<div class="resumo_compra">
				<div class="title">
					<h1>Resumo da compra</h1>
				</div>
				<div class="select_plano">
					<select id="registrar_select_plano">
						<option value="1" <?=(($dadosVenda['plano'] == 1)?'selected':'')?> >Plano Trimestral</option>
						<option value="2" <?=(($dadosVenda['plano'] == 2)?'selected':'')?> >Plano Semestral</option>
						<option value="3" <?=(($dadosVenda['plano'] == 3)?'selected':'')?> >Plano Anual</option>
					</select>
				</div>
				<div class="select_veiculos<?=($statusLogin?' display_flex_important':'')?>">
					<select id="registrar_select_veiculos">
						<option value="<?=base64_encode(0)?>">Novo Veículo</option>
						<?php foreach($vehicles as $vehicle): 
						$id = base64_encode($vehicle['id']);
						?>								
						<option value="<?=$id?>"<?=(($id == $dadosVenda['idVeiculo'])?' selected ':'')?>><?=$vehicle['name']?></option>
						<?php endforeach; ?>
					</select>
				</div>
				<div class="box_lista">
					<div class="qtd_veiculo">
						<h3 id="registrar_qtd_veiculo"><?=$dadosVenda['quantidade']?></h3><h3>veículos</h3>
					</div>
					<div class="alt_qtd_veiculo">
						<div class="btn_qtd" data-btn_qtd="1" alt="Remover um veículo" title="Remover um veículo">
							<div class="barra_horizontal_menor"></div>
						</div>
						<div class="btn_qtd" data-btn_qtd="2" alt="Adicionar mais um veículo" title="Adicionar mais um veículo">
							<div class="barra_horizontal"></div>
							<div class="barra_vertical"></div>
						</div>
					</div>
				</div>
				<div class="valor_unitario">
					<div class="txt_resumo_compra">
						<h3>Valor Unitário</h3>
					</div>
					<div class="txt_resumo_compra">
						<h3 id="valor_unitario">R$0,00</h3>
					</div>
				</div>
				<div class="desconto">
					<div class="txt_resumo_compra">
						<h3>Desconto</h3>
					</div>
					<div class="txt_resumo_compra">
						<h3 id="valor_desconto">R$0,00</h3>
					</div>
				</div>
				<div class="valor_total">
					<div class="txt_resumo_compra">
						<h3><b>Valor Total</b></h3>
					</div>
					<div class="txt_valor_total">
						<h3 id="valor_total">R$0,00</h3>
					</div>
				</div>
				<div class="img">
					<img src="<?=BASE_URL?>assets/images/img_formas_pagamento.png"/>
				</div>
			</div>
		</div>
	</div>
</section>