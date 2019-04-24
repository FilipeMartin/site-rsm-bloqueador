$(document).ready(function() {

if(window.location.href.match(/area_cliente\/minha_conta/)){

    // Máscaras
    startMask();
    //==========

    var msgError = $('#form_edit_password span');

    $('#senha_atual').change(function(){
        msgError.html('');
    });

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

    $('#form_edit_user').validate({
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
                    type: "post",
                    data:{
                        cpfCurrent: function() {
                            return $('#cpf').data('cpf');
                        }
                    }
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
                    type: "post",
                    data:{
                        emailCurrent: function() {
                            return $('#email').data('email');
                        }
                    }
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
                    type: "post",
                    data:{
                        usuarioCurrent: function() {
                            return $('#usuario').data('usuario');
                        }
                    }
                }
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
            }
        },
        submitHandler: function(form){

            // Resetar formulário
            $(form).validate().resetForm();
            //=============================

            var url = P_BASE_URL+"requisicoes/edit_user/";
            var dadosForm = $(form).serialize();

            $.ajax({
                    url: url,
                    type: 'POST',
                    dataType: 'JSON',
                    data: dadosForm,
                    cache: false,
                    beforeSend: function(){
                        btnEditUser(false);
                    },
                    success: function(result){
                        if(result.status){
                            // Alterar Dados
                            $('#cpf').data('cpf', $('#cpf').val());
                            $('#email').data('email', $('#email').val());
                            $('#usuario').data('usuario', $('#usuario').val());
                            //=================================================

                            // Banner - Alterar nome do Usuário
                            var nome = $('#form_edit_user #nome').val().split(' ')[0];
                            $('.ac_banner_title p').html('Olá, '+nome+'!');
                            //========================================================

                            // Mostrar Mensagem de Sucesso
                            $('#form_edit_user').fadeOut('fast', function(){
                                $('#edit_success_user').fadeIn('fast').css({'display':'flex'});
                                btnEditUser(true);
                            });
                            //=================================================================
                        } else{
                            btnEditUser(true);
                            alert('Desculpe, Serviço Temporariamente Indisponível. Tente mais tarde.');
                        }
                    },
                    error: function(){
                        btnEditUser(true);
                        alert('Desculpe, Serviço Temporariamente Indisponível. Tente mais tarde.');
                    }
            });
        }
    });

    function btnEditUser(status){
        var inputEdit = $('#form_edit_user :input');
        var btnEdit = $('#form_edit_user .btn_edit :input');

        if(status){
            inputEdit.prop("disabled", false);
            btnEdit.val('Editar');
            btnEdit.removeClass('btn_green_disabled');
        } else{
            inputEdit.prop("disabled", true);
            btnEdit.val('Editando...');
            btnEdit.addClass('btn_green_disabled');
        }
    }

    $('#btn_fechar_user').click(function(){
        window.location.href = window.location.href;
    });

    jQuery.validator.addMethod("invalidPassword", function(value, element){

        if(msgError.is(':empty')){
            return true;
        }
        return false;
        
    }, "");

    $('#form_edit_password').validate({
        errorClass: 'custom-input-error',
        rules:{
            senha_atual:{
                invalidPassword: true,
                required: true,
                rangelength: [6,14]
            },
            nova_senha:{
                required: true,
                rangelength: [6,14]
            },
            confirmar_nova_senha:{
                required: true,
                equalTo: "#nova_senha"
            }
        },
        messages:{
            senha_atual:{
                rangelength: "Sua senha deve conter de {0} a {1} caracteres."
            },
            nova_senha:{
                rangelength: "Sua senha deve conter de {0} a {1} caracteres."
            },
            confirmar_nova_senha:{
                equalTo: "As senhas não conferem."
            }
        },
        submitHandler: function(form){

            var url = P_BASE_URL+"requisicoes/edit_password/";
            var dadosForm = $(form).serialize();

            $.ajax({
                    url: url,
                    type: 'POST',
                    dataType: 'JSON',
                    data: dadosForm,
                    cache: false,
                    beforeSend: function(){
                        btnEditPassword(false);
                    },
                    success: function(result){
                        if(result.status){
                            // Mostrar Mensagem de Sucesso
                            $('#form_edit_password').fadeOut('fast', function(){
                                $('#edit_success_password').fadeIn('fast').css({'display':'flex'});
                                btnEditPassword(true);
                            });
                            //=====================================================================
                        } else{
                            switch(result.error){
                                case 1:
                                    alert('Desculpe, Serviço Temporariamente Indisponível. Tente mais tarde.');
                                break; 
                                case 2:
                                    msgError.html('Senha atual inválida.');
                            }
                            btnEditPassword(true);
                        }
                    },
                    error: function(){
                        btnEditPassword(true);
                        alert('Desculpe, Serviço Temporariamente Indisponível. Tente mais tarde.');
                    }
            });  
        }
    });

    function btnEditPassword(status){
        var inputEdit = $('#form_edit_password :input');
        var btnEdit = $('#form_edit_password .btn_edit :input');

        if(status){
            inputEdit.prop("disabled", false);
            btnEdit.val('Alterar Senha');
            btnEdit.removeClass('btn_green_disabled');
        } else{
            inputEdit.prop("disabled", true);
            btnEdit.val('Alterando...');
            btnEdit.addClass('btn_green_disabled');
        }
    }

    $('#btn_fechar_password').click(function(){
        window.location.href = window.location.href;
    });
}
});