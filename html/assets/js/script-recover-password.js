$(document).ready(function() {

if(window.location.href.match(/recuperar_senha/)){

	var msgError = $('#form_recuperar_senha span');

	$('#form_recuperar_senha').submit(function(){

        var email = $('#email_login').val().trim();

        if(email === ''){
            msgError.html('Campo está vazio!');
            return false;
        }

		var url = P_BASE_URL+"requisicoes/recover_password/";
        var dadosForm = $(this).serialize();

        $.ajax({
                url: url,
                type: 'POST',
                dataType: 'JSON',
                data: dadosForm,
                cache: false,
                beforeSend: function(){
                    btnSend(false);
                    msgError.html('');
                },
                success: function(result){
                    if(result.status){
                        $('#enviar_email').fadeOut('fast', function(){
                            $('#email_enviado').fadeIn('fast').css({'display':'flex'});
                            // Mostrar e-mail
                            $('#email_enviado b').html(result.email);
                            //---------------------------------------
                            btnSend(true);
                        });
                    } else{
                    	switch(result.error){
                    		case 1:
                    			msgError.html('E-mail e/ou login inválido!'); break;
                    		case 2:	
                    			msgError.html('Foi atingido o limite diário de solicitações para a recuperação de senha!'); break;
                            default: 
                                msgError.html('Desculpe, serviço temporariamente indisponível. Tente mais tarde!');   
                    	}
                    	btnSend(true);
                    }
                },
                error: function(){
                    msgError.html('Desculpe, serviço temporariamente indisponível. Tente mais tarde!');
                    btnSend(true);
                }
        });
		return false;
	});

	function btnSend(status){
		var inputSend = $('#form_recuperar_senha :input');
        var btnSend = $('#form_recuperar_senha .btn_recuperar_senha :input');

        if(status){
            inputSend.prop("disabled", false);
            btnSend.val('Enviar');
            btnSend.removeClass('btn_blue_disabled');
        } else{
            inputSend.prop("disabled", true);
            btnSend.val('Enviando...');
            btnSend.addClass('btn_blue_disabled');
        }
    }

    $('#btn_fechar').click(function(){
    	window.location.href = window.location.href;
    });
}
});