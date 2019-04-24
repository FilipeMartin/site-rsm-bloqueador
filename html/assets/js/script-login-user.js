$(document).ready(function() {

	var msgError = $('#form_login span');

	$('.btn_login_user').click(function(){

		var statusLogin = $(this).attr('data-login');

		if(statusLogin){
			window.location.href = P_BASE_URL+'area_cliente/';
		} else{
			$('.login_screen').fadeIn('fast');
		}

	});

	$('#form_login').submit(function(){

		var login = $("#form_login input[name='login']").val().trim();
		var password = $("#form_login input[name='password']").val().trim();

		if(login === '' || password === ''){
			msgError.html('Login e/ou senha estão vazios!');
			return false;
		}

		var url = P_BASE_URL+"requisicoes/user_altentification/";
		var urlPlatform = P_BASE_URL_PLATFORM+"api/session/";
		var dadosForm = $(this).serialize();
		var password = $("#form_login input[type='password'][name='password']").val();

		$.ajax({
		    url: url,
		    type: 'POST',
		    dataType: 'JSON',
		    data: dadosForm,
		    cache: false,
		    beforeSend: function(){
		        btnLogar(false);
		        msgError.html('');
	        },
		    success: function(result){
		            
		        if(result.status){
		        	$.ajaxSetup({
						crossDomain: true,
						xhrFields: {
						    withCredentials: true
						}
					});
					$.post(urlPlatform, {email: result.email, password: password}).always(function(){
						window.location.href = P_BASE_URL+'area_cliente/';
					});
		        } else{
		        	switch(result.error){
		        		case 1: 
		        			msgError.html('Login e/ou senha inválidos!'); break;
		        		case 2: 
		        			msgError.html('Enviamos um e-mail de confirmação para você ativar a sua conta!'); break;
		        		default:
		        			msgError.html('Desculpe, serviço temporariamente indisponível. Tente mais tarde!');	
		        	}
		        	btnLogar(true);
		        }
		    },
		    error: function(){	
		        msgError.html('Desculpe, serviço temporariamente indisponível. Tente mais tarde!');
		        btnLogar(true);
		    }
		});
		return false;
	});

	function btnLogar(status){
		var inputLogar = $('#form_login :input');
        var btnLogar = $('#form_login .btn_login :input');

        if(status){
            inputLogar.prop("disabled", false);
            btnLogar.val('Entrar');
            btnLogar.removeClass('btn_blue_disabled');
        } else{
            inputLogar.prop("disabled", true);
            btnLogar.val('Autenticando...');
            btnLogar.addClass('btn_blue_disabled');
        }
    }

	$('.login_box .btn_close').click(function(){
		$('.login_screen').fadeOut('fast');
	});
});