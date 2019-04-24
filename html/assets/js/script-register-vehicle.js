$(document).ready(function() {

if(window.location.href.match(/area_cliente\/cadastrar_veiculo/)){	

	// Máscaras
	startMask();
	//==========

	function startMask(){
		$('#telefone').mask('(00) 00000-0009');
		$('#telefone').blur(function(event){
			if($(this).val().length == 15){
				$('#telefone').mask('(00) 00000-0009');
			} else{
				$('#telefone').mask('(00) 0000-00009');
			}	
		});
	}

	$('#form_register_vehicle').validate({
    	errorClass: 'custom-input-error',
    	rules:{
    		nome:{
    			required: true,
    			maxlength: 128
    		},
    		imei:{
    			required: true,
    			maxlength: 128,
    			minlength: 15,
    			remote:{
    				url: P_BASE_URL+"requisicoes/verify_imei/",
    				type: "post"
    			}
    		},
    		telefone:{
    			required: true,
    			minlength: 14
    		},
    		modelo:{
    			required: true,
    			maxlength: 128
    		},
    		categoria:{
    			required: true
    		}
    	},
    	messages:{
    		telefone:{
    			minlength: "Por favor, forneça um telefone válido."
    		},
    		imei:{
    			minlength: "Por favor, forneça ao menos {0} dígitos.",
    			remote: "Este imei já está cadastrado. Forneça outro."
    		}
    	},
    	submitHandler: function(form){

    		var url = P_BASE_URL+"requisicoes/register_vehicle/";
			var dadosForm = $(form).serialize();	
			var btn_prox_cadastro = $('.register_success .btn_prox_cadastro');		
			var qtdVeiculo = $('.register .title h1');

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

			            	$('.register .form_register_vehicle').fadeOut('fast', function(){
								$('.register .register_success').fadeIn('fast').css({'display':'flex'});
							});

							var itens = '<p>Nome: '+$(".form_register_vehicle #nome").val()+'</p>'+
										'<p>Imei: '+$(".form_register_vehicle #imei").val()+'</p>'+
										'<p>Telefone: '+$(".form_register_vehicle #telefone").val()+'</p>'+
										'<p>Modelo: '+$(".form_register_vehicle #modelo").val()+'</p>'+
										'<p>Categoria: '+$('#select_category option:selected').text()+'</p>'+
										'<p>Data de Expiração: '+result.expirationTime+'</p>';

							$('.register_success .itens').html(itens);

							if(result.qtdCadastrar > 1){
								qtdVeiculo.html(result.qtdCadastrar+' Veículos para Cadastrar');

							} else if(result.qtdCadastrar == 1){
								qtdVeiculo.html('1 Veículo para Cadastrar');

							} else{
								qtdVeiculo.html('Veículo Cadastrado com Sucesso');
								btn_prox_cadastro.css({'display':'none'});
							}
							// Update InfoBox
							updateInfoBox();
							//===============

			            } else{
			            	btnRegister(true);
			            	alert('Desculpe, Serviço Temporariamente Indisponível. Tente mais tarde.');
			            }
			        },
			        error: function(){
			        	btnRegister(true);
			            alert('Desculpe, Serviço Temporariamente Indisponível. Tente mais tarde.');
			        }
			});
    	}
    });

	$('.register_success .btn_prox_cadastro button').click(function(){

		$('#register_success').fadeOut('fast', function(){
			$('#form_register_vehicle').fadeIn('fast');
			$("#form_register_vehicle").trigger('reset');
			btnRegister(true);
		});
	});

	$('.register_success .btn_platform button').click(function(){	
		window.open(P_BASE_URL_PLATFORM, '_blank');
	});

	function updateInfoBox(){
		var infoBoxTotal = $('.ac_info_box .item .total');
		var infoBoxAtivo = $('.ac_info_box .item .ativo');
		var infoBoxCadastrar = $('.ac_info_box .item .cadastrar');
			
		// InfoBox Total					
		infoBoxTotal.html(parseInt(infoBoxTotal.text())+1);
		//=================================================
			
		// InfoBox Ativo					
		infoBoxAtivo.html(parseInt(infoBoxAtivo.text())+1);
		//=================================================

		// InfoBox Cadastrar
		infoBoxCadastrar.html(parseInt(infoBoxCadastrar.text())-1);
		//=========================================================
	}

	function btnRegister(status){
		var inputRegister = $('.form_register_vehicle :input');
		var btnRegister = $('.form_register_vehicle .btn_register :input');

		if(status){
			inputRegister.prop("disabled", false);
            btnRegister.val('Cadastrar');
            btnRegister.removeClass('btn_green_disabled');
		} else{
			inputRegister.prop("disabled", true);
            btnRegister.val('Cadastrando...');
            btnRegister.addClass('btn_green_disabled');
		}
	}
}
});