$(document).ready(function() {

if(window.location.href.match(/recuperar_senha\/cadastrar/)){

    $('#form_edit_password').validate({
        errorClass: 'custom-input-error',
        rules:{
            senha:{
                required: true,
                rangelength: [6,14]
            },
            confirmar_senha:{
                required: true,
                equalTo: "#senha"
            }
        },
        messages:{
            senha:{
                rangelength: "Sua senha deve conter de {0} a {1} caracteres."
            },
            confirmar_senha:{
                equalTo: "As senhas não conferem."
            }
        },
        submitHandler: function(form){

            var url = P_BASE_URL+"requisicoes/register_password/";
            var dadosForm = $(form).serialize();

            $.ajax({
                    url: url,
                    type: 'POST',
                    dataType: 'JSON',
                    data: dadosForm,
                    cache: false,
                    beforeSend: function(){
                        btnEdit(false);
                    },
                    success: function(result){
                        if(result.status){
                            // Mostrar Mensagem de Sucesso
                            $('#form_edit_password').fadeOut('fast', function(){
                                $('#edit_success_password').fadeIn('fast').css({'display':'flex'});
                                btnEdit(true);
                            });
                            //---------------------------------------------------------------------
                        } else{
                            btnEdit(true);
                            alert('Desculpe, Serviço Temporariamente Indisponível. Tente mais tarde.');
                        }
                    },
                    error: function(){
                        btnEdit(true);
                        alert('Desculpe, Serviço Temporariamente Indisponível. Tente mais tarde.');
                    }
            });
        }
    });

    function btnEdit(status){
        var inputEdit = $('#form_edit_password :input');
        var btnEdit = $('#form_edit_password .btn_edit :input');

        if(status){
            inputEdit.prop("disabled", false);
            btnEdit.val('Cadastrar Senha');
            btnEdit.removeClass('btn_green_disabled');
        } else{
            inputEdit.prop("disabled", true);
            btnEdit.val('Cadastrando...');
            btnEdit.addClass('btn_green_disabled');
        }
    }
}
});