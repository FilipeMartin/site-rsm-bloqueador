$(document).ready(function() {

if(window.location.href.match(/registrar\/servico/)){

	// Máscaras
	startMask();
	//==========

	// Start Select Veículo
	var idVeiculo = $('#registrar_select_veiculos option:selected').val();

	startSelectVeiculos();
	//====================================================================

	// Total de Veículos
	var totalVeiculos = $('#registrar_qtd_veiculo').text();
	//=====================================================

	// Forma de Pagamento
	var formaPagamento = $('.forma_pagamento').attr('data-forma-pagamento');
	//======================================================================

	// Etapa Atual - Registro de Serviço
	var etapaAtual = $('.etapas_registro').attr('data-etapa-registro');

	var circulo_1 = $('.etapa_registro_item_1 .circulo_externo');
	var circulo_2 = $('.etapa_registro_item_3 .circulo_externo');
	var circulo_3 = $('.etapa_registro_item_5 .circulo_externo');
	var barra_1 = $('.etapa_registro_item_2 .barra_interna');
	var barra_2 = $('.etapa_registro_item_4 .barra_interna');

	startEtapasRegistro();
	//==================================================================

	// Update - Resumo da compra
	updateValues();
	//==========================

	function startEtapasRegistro(){

		if(etapaAtual == 1){
			etapasRegistro(0);

		} else if(etapaAtual == 2){
			$('.registro .cadastro').css({'display':'none'});
			$('.registro .forma_pagamento').css({'display':'flex'});
			etapasRegistro(1);

		} else if(etapaAtual == 3){
			$('.registro .cadastro').css({'display':'none'});
			$('.registro .forma_pagamento').css({'display':'none'});
			$('.registro .finalizar_compra').css({'display':'flex'});
			etapasRegistro(1);
			setTimeout(function() {
				etapasRegistro(2);
			}, 2500);

		} else if(etapaAtual == 4){
			// Seja Bem-Vindo
		}
	}

	function etapasRegistro(etapa){
		
		if(etapa == 0){
			circulo_1.animate({'width': '50%'}, 50);

		} else if(etapa == 1){
			$('.etapa_registro_item_1 .circulo_numero').fadeOut('fast', function(){                        
                $('.etapa_registro_item_1 .circulo_img').fadeIn('fast');                          
            });

            $('.desc_etapa_1').css({'color':'#303F9F'});

			circulo_1.animate({'width':'100%'}, 50);

			setTimeout(function() {
				barra_1.animate({'width':'100%'}, 50);

				setTimeout(function() {
					circulo_2.animate({'width':'50%'}, 50);
					btnFormaPagamento(true);
				}, 1000);

			}, 1000);

		} else if(etapa == 2){
			$('.etapa_registro_item_3 .circulo_numero').fadeOut('fast', function(){                        
                $('.etapa_registro_item_3 .circulo_img').fadeIn('fast');                          
            });

            $('.desc_etapa_2').css({'color':'#303F9F'});

			circulo_2.animate({'width':'100%'}, 50);

			setTimeout(function() {
				barra_2.animate({'width':'100%'}, 50);

				setTimeout(function() {
					circulo_3.animate({'width':'50%'}, 50);
					btnFinalizarCompra(true);
				}, 1000);

			}, 1000);

		} else if(etapa == 3){
			$('.etapa_registro_item_5 .circulo_numero').fadeOut('fast', function(){                        
                $('.etapa_registro_item_5 .circulo_img').fadeIn('fast');                          
            });

            $('.desc_etapa_3').css({'color':'#303F9F'});

			circulo_3.animate({'width':'100%'}, 50);
		}
	}

	function startMask(){
		$('#cpf').mask('000.000.000-00');
		$('#cep').mask('00.000-000');
		$('#telefone').mask('(00) 0000-0000');
		$('#celular').mask('(00) 00000-0009');
		$('#celular').blur(function(event){
			if($(this).val().length == 15){
				$('#celular').mask('(00) 00000-0009');
			} else{
				$('#celular').mask('(00) 0000-00009');
			}	
		});
	}

	var cepAtual;
	$('#cep').blur(function(){
		if($(this).val().length == 10){

			var cep = $(this).val().replace(/[^\d]+/g,'');

			if(cepAtual != cep){
				cepAtual = cep;
				
				var url = "https://viacep.com.br/ws/"+cep+"/json/";

				$.getJSON(url, function(data){

					if(!("erro" in data)){
						$('#endereco').val(data.logradouro).focus();
						$('#bairro').val(data.bairro).focus();
						$('#cidade').val(data.localidade).focus();
						$('#estado').find('option:contains("'+data.uf+'")').prop('selected', true);
					}
				});
			}	
		}	
	});

	$('#form_cadastro').validate({
    	errorClass: 'custom-input-error',
    	rules:{
    		nome:{
    			required: true,
    			minWords: 2,
    			maxlength: 128,
    			minlength: 5
    		},
    		dataNasc:{
    			required: true,
    			date: true
    		},
    		cpf:{
    			required: true,
    			cpfBR: true,
    			remote:{
    				url: P_BASE_URL+"requisicoes/verify_cpf/",
    				type: "post"
    			}
    		},
    		cep:{
    			required: true,
    			postalcodeBR: true
    		},
    		endereco:{
    			required: true,
    			minlength: 5
    		},
    		numero:{
    			required: true,
    			maxlength: 20
    		},
    		complemento:{
    			maxlength: 128
    		},
    		bairro:{
    			maxlength: 50
    		},
    		cidade:{
    			required: true,
    			minlength: 2
    		},
    		estado:{
    			required: true
    		},
    		email:{
    			required: true,
    			email: true,
    			remote:{
    				url: P_BASE_URL+"requisicoes/verify_email/",
    				type: "post"
    			}
    		},
    		confirmar_email:{
    			required: true,
    			email: true,
    			equalTo: "#email"
    		},
    		celular:{
    			required: true,
    			minlength: 14
    		},
    		telefone:{
    			required: true,
    			minlength: 14
    		},
    		usuario:{
    			required: true,
    			maxlength: 128,
    			minlength: 5,
    			remote:{
    				url: P_BASE_URL+"requisicoes/verify_login/",
    				type: "post"
    			}
    		},
    		senha:{
    			required: true,
    			rangelength: [6,14]
    		},
    		confirmar_senha:{
    			required: true,
    			equalTo: "#senha"
    		},
    		termosServicoCheck:{
    			required: true
    		}
    	},
    	messages:{
    		cpf:{
    			remote: "Este cpf já está cadastrado. Forneça outro."
    		},
    		email:{
    			remote: "Este e-mail já está cadastrado. Forneça outro."
    		},
    		confirmar_email:{
    			equalTo: "Os e-mails não conferem."
    		},
    		celular:{
    			minlength: "Por favor, forneça um celular válido."
    		},
    		telefone:{
    			minlength: "Por favor, forneça um telefone válido."
    		},
    		usuario:{
    			remote: "Este usuário já está cadastrado. Forneça outro."
    		},
    		senha:{
    			rangelength: "Sua senha deve conter de {0} a {1} caracteres."
    		},
    		confirmar_senha:{
    			equalTo: "As senhas não conferem."
    		}
    	},
    	submitHandler: function(form){

    		var url = P_BASE_URL+"requisicoes/dados_cliente/";
			var dadosForm = $(form).serialize();

			$.ajax({
			        url: url,
			        type: 'POST',
			        dataType: 'JSON',
			        data: dadosForm,
			        cache: false,
			        beforeSend: function(){
	                    btnRegister(false);
	                },
			        success: function(result){			           
			            if(result.status){

			            	if(etapaAtual == 1){

			            		etapaAtual++;
			            		if(purchaseRequest()){
			            			$('.registro .cadastro').fadeOut('fast', function(){
									    $('.registro .forma_pagamento').fadeIn('fast');
										etapasRegistro(1);
										btnRegister(true);
									});
			            		} else{
			            			etapaAtual--;
			            			btnRegister(true);
			            		}
											            	
			            	} else{
			            		$('.registro .cadastro').fadeOut('fast', function(){
									$('.registro .forma_pagamento').fadeIn('fast');
									btnRegister(true);
								});
			            	}			         	
			            } else{
			            	alert('Erro na requisição!');
			            	btnRegister(true);	
			            }
			        },
			        error: function(){
			            alert('Erro na requisição!');
			            btnRegister(true);	
			        }
			});
    	}
    });

	btnFormaPagamento(false);
	$('#btn_forma_pagamento').click(function(){

		if(formaPagamento == 1 || formaPagamento == 2){
		
			if(etapaAtual == 2){

				etapaAtual++;
				if(purchaseRequest()){
					$('.registro .forma_pagamento').fadeOut('fast', function(){
						$('.registro .finalizar_compra').fadeIn('fast');
						etapasRegistro(2);
					});
				} else{
					etapaAtual--;
				}

			} else{
				$('.registro .forma_pagamento').fadeOut('fast', function(){
					$('.registro .finalizar_compra').fadeIn('fast');
				});
			}

		} else{
			$('.btn_forma_pagamento').addClass('border_red');
		}
		return false;
	});

	btnFinalizarCompra(false);
	$('#form_finalizar_compra').submit(function(){

		var url = P_BASE_URL+"registrar/finalizar_venda/";
		var dadosForm = $(this).serialize();
		var loadingScreen = $('.loading_screen');
		
		$.ajax({
	        url: url,
	        type: 'POST',
	        dataType: 'JSON',
	        data: dadosForm,
	        cache: false,
	        beforeSend: function(){
				loadingScreen.fadeIn('fast');
				btnFinalizarCompra(false);
            },
	        success: function(result){
	            if(result.status){
					loadingScreen.fadeOut('fast');
	            	PagSeguroLightbox(result.code, {
			                success : function(transactionCode) {
										loadingScreen.fadeIn('fast');		
										$.post(P_BASE_URL+"registrar/consultarTransacao/", {transactionCode:transactionCode})
										.done(function(result){
											window.location.href = P_BASE_URL+"registrar/sucesso/";
										});  	                          		
			                },
			                abort : function() {
								loadingScreen.fadeIn('fast');
								window.location.href = P_BASE_URL+"registrar/sucesso/";			                          	
			                }
         				});
	            } else{
	            	alert('Erro na requisição!');
	            	// Redirecionar;
	            }	
	        },
	        error: function(){
	            alert('Erro na requisição!');
	            //Redirecionar;
	        }
		});
		return false;
	});

	$('.btn_registrar_voltar').click(function(){
		var btnVoltar = $(this).attr('date-btn_registrar_voltar');

		if(btnVoltar == '1'){
			$('.registro .forma_pagamento').fadeOut('fast', function(){
				$('.registro .cadastro').fadeIn('fast');
			});

		} else if(btnVoltar == '2'){
			$('.registro .finalizar_compra').fadeOut('fast', function(){
				$('.registro .forma_pagamento').fadeIn('fast');
			});
		}

	});

	$('#btn_boleto').click(function(){
		var btnClasse = "box_forma_pagamento_check";
		var checkClasse = "check_checked_viability";

		if(!$(this).hasClass(btnClasse)){
			$(this).addClass(btnClasse);
			$('#btn_boleto .check .check_checked').addClass(checkClasse);
			$('#btn_cartao').removeClass(btnClasse);
			$('#btn_cartao .check .check_checked').removeClass(checkClasse);
			$('.btn_forma_pagamento').removeClass('border_red');
			formaPagamento = 1;
			purchaseRequest();
		}

	});

	$('#btn_cartao').click(function(){
		var btnClasse = "box_forma_pagamento_check";
		var checkClasse = "check_checked_viability";

		if(!$(this).hasClass(btnClasse)){
			$(this).addClass(btnClasse);
			$('#btn_cartao .check .check_checked').addClass(checkClasse);
			$('#btn_boleto').removeClass(btnClasse);
			$('#btn_boleto .check .check_checked').removeClass(checkClasse);
			$('.btn_forma_pagamento').removeClass('border_red');
			formaPagamento = 2;
			purchaseRequest();
		}

	});

	$('#registrar_select_plano').change(function() {
		updateValues();
		purchaseRequest();
    });

    $('#registrar_select_veiculos').change(function() {
		var itemSelecionado = $('#registrar_select_veiculos option:selected').val();
		var id = atob(itemSelecionado);
		var boxLista = $('.box_lista');

		if(id == 0){
			boxLista.fadeIn('fast');
		} else{
			boxLista.fadeOut('fast');
		}
		idVeiculo = itemSelecionado;
		totalVeiculos = 1;
		$('#registrar_qtd_veiculo').html(totalVeiculos);
		updateValues();
		purchaseRequest();
    });

    function startSelectVeiculos(){
    	var itemSelecionado = $('#registrar_select_veiculos option:selected').val();
		var id = atob(itemSelecionado);
		var boxLista = $('.box_lista');

		if(id == 0){
			boxLista.fadeIn('fast');
		} else{
			boxLista.fadeOut('fast');
		}
    }

    $('.alt_qtd_veiculo .btn_qtd').click(function(){
		var btnQtd = $(this).attr('data-btn_qtd');

		if(btnQtd == '1'){

			if(totalVeiculos > 1){

				totalVeiculos--;				
				if(!purchaseRequest()){
					totalVeiculos++;
				}
				$('#registrar_qtd_veiculo').html(totalVeiculos);
				updateValues();	
			}

		} else if(btnQtd == '2'){

			if(totalVeiculos < 10 ){

				totalVeiculos++;				
				if(!purchaseRequest()){
					totalVeiculos--;
				}
				$('#registrar_qtd_veiculo').html(totalVeiculos);
				updateValues();
			}
		}
	});

	function updateValues(){

		var plano = $('#registrar_select_plano option:selected').val();
		var qtdVeiculos = totalVeiculos;
		var valorUnitario = $('#valor_unitario');
		var valorDesconto = $('#valor_desconto');
		var valorTotal = $('#valor_total');
		var valorSemDesc;
		var valorDesc;

		if(plano == '1'){
			valorSemDesc = P_VALOR_TRIMESTRAL[0];
			valorDesc = P_VALOR_TRIMESTRAL[1];

		} else if(plano == '2'){
			valorSemDesc = P_VALOR_SEMESTRAL[0];
			valorDesc = P_VALOR_SEMESTRAL[1];

		} else if(plano == '3'){
			valorSemDesc = P_VALOR_ANUAL[0];
			valorDesc = P_VALOR_ANUAL[1];
		}

		if(qtdVeiculos == '1'){
			valorUnitario.html("R$"+valorSemDesc);
			valorDesconto.html('R$0,00');
			valorTotal.html("R$"+valorSemDesc);

		} else{
			valorUnitario.html("R$"+valorDesc);

			// Cálculo do valor sem Desconto
			valorSemDesc = (parseFloat(valorSemDesc.replace(',', '.'))) * qtdVeiculos;
			valorSemDesc = valorSemDesc.toFixed(2).replace('.', ',');
			valorDesconto.html("<strike>R$"+valorSemDesc+"</strike>");
			//========================================================================
			
			// Cálculo do valor com Desconto
			valorDesc = (parseFloat(valorDesc.replace(',', '.'))) * qtdVeiculos;
			valorDesc = valorDesc.toFixed(2).replace('.', ',');
			valorTotal.html("R$"+valorDesc);
			//========================================================================
		}
	}

	function purchaseRequest(){
		var url = P_BASE_URL+"requisicoes/dados_venda/";
		var tipoPlano = $('#registrar_select_plano option:selected').val();
		var resposta = false;

		$.ajax({
		        url: url,
		        type: 'POST',
		        dataType: 'JSON',
		        data: {tipoPlano: tipoPlano, veiculo: idVeiculo, qtdVeiculos: totalVeiculos, formaPagamento: formaPagamento, etapaRegistro: etapaAtual},
		        cache: false,
		        async: false,
		        success: function(result){
		            if(result.status){
		            	resposta = true;
		            } else{
		            	alert('Erro na requisição!');
		            }
		        },
		        error: function(){
		         	alert('Erro na requisição!');   		            
		        }
		});
		return resposta;
    }

    function btnRegister(status){
        var input = $('#form_cadastro :input');
        var btn = $('#form_cadastro .btn_prox_cadastrar :input');

        if(status){
            input.prop("disabled", false);
            btn.val('Próximo');
            btn.removeClass('btn_blue_disabled');
        } else{
            input.prop("disabled", true);
            btn.val('Aguarde...');
            btn.addClass('btn_blue_disabled');
        }
    }

    function btnFormaPagamento(status){
        var btn = $('#btn_forma_pagamento');

        if(status){
        	btn.prop("disabled", false);
            btn.val('Próximo');
            btn.removeClass('btn_blue_disabled');
        } else{
        	btn.prop("disabled", true);
            btn.val('Aguarde...');
            btn.addClass('btn_blue_disabled');
        }
    }

    function btnFinalizarCompra(status){
        var btn = $('#btn_finalizar_compra');

        if(status){
        	btn.prop("disabled", false);
            btn.val('Finalizar Compra');
            btn.removeClass('btn_green_disabled');
        } else{
        	btn.prop("disabled", true);
            btn.val('Aguarde...');
            btn.addClass('btn_green_disabled');
        }
    }
}
});