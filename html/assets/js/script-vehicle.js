$(document).ready(function() {

if(window.location.href.match(/area_cliente\/veiculos/)){

    var veiculoAtual = 1;

    // Start Map
    startMap();
    //==========

    // Máscaras
    startMask();
    //==========

    $('.vehicles details').click(function(){
        if(veiculoAtual != $(this).attr('id')){
            veiculoAtual = $(this).attr('id');  
        }
    });

    $('.btn_renew_vehicle').click(function(){
        var url = P_BASE_URL+"requisicoes/dados_venda/";
        var idVeiculo = $(this).data('vehicle');

        $.ajax({
                url: url,
                type: 'POST',
                dataType: 'JSON',
                data: {tipoPlano: 3, veiculo: idVeiculo, qtdVeiculos: 1, formaPagamento: 0, etapaRegistro: 2},
                cache: false,
                beforeSend: function(){
                    $('.btn_renew_vehicle').attr('disabled', 'disabled');
                },
                success: function(result){
                    if(result.status){
                        window.location.href = P_BASE_URL+"registrar/servico/";
                    }else{
                       $('.btn_renew_vehicle').removeAttr('disabled'); 
                    }
                },
                error: function(){
                    alert('Erro na requisição!');
                    $('.btn_renew_vehicle').removeAttr('disabled');
                }
        });
    });

    $('.btn_edit_vehicle').click(function(){

        // Inserir dados no formulário
        $('#form_edit_vehicle #veiculo').val($(this).data('vehicle'));
    	$('#form_edit_vehicle #nome').val($(this).data('name'));
    	$('#form_edit_vehicle #imei').val($(this).data('imei'));
    	$('#form_edit_vehicle #telefone').val($(this).data('phone'));
    	$('#form_edit_vehicle #modelo').val($(this).data('model'));
        $('#form_edit_vehicle #select_category option[value="'+$(this).data('category')+'"]').prop('selected', 'true');
        //=============================================================================================================

        // Definir tela principal
        $('#form_edit_vehicle').css({'display':'flex'});
        $('#edit_success').css({'display':'none'});
        //==============================================

        // Abrir formulário
        $('.edit_vehicle_screen').fadeIn('fast');
        //=======================================

        // Resetar formulário
        $('#form_edit_vehicle').validate().resetForm();
        //=============================================
    });

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

    $('#form_edit_vehicle').validate({
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
                    type: "post",
                    data:{
                        imeiCurrent: function() {
                            return $('#'+veiculoAtual+' .btn_edit_vehicle').data('imei');
                        }
                    }
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

            var url = P_BASE_URL+"requisicoes/updateVehicle/";
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

                            var name = $('#form_edit_vehicle #nome').val();
                            var imei = $('#form_edit_vehicle #imei').val();
                            var phone = $('#form_edit_vehicle #telefone').val();
                            var model = $('#form_edit_vehicle #modelo').val();
                            var category = $('#form_edit_vehicle #select_category option:selected').val();
                            var textCategory = $('#form_edit_vehicle #select_category option:selected').text();

                            // Atualizar Dados
                            var titulo = $('#'+veiculoAtual+' summary h1');
                            var btn_edit_vehicle = $('#'+veiculoAtual+' .btn_edit_vehicle');              

                            titulo.html(name);
                            btn_edit_vehicle.data('name', name);
                            btn_edit_vehicle.data('imei', imei);
                            btn_edit_vehicle.data('phone', phone);
                            btn_edit_vehicle.data('model', model);
                            btn_edit_vehicle.data('category', category);
                            //==============================================================

                            // Mostrar Dados
                            $('#form_edit_vehicle').fadeOut('fast', function(){
                                $('#edit_success').fadeIn('fast').css({'display':'flex'});
                                btnEdit(true);
                            });

                            var itens = '<p>Nome: '+name+'</p>'+
                                        '<p>Imei: '+imei+'</p>'+
                                        '<p>Telefone: '+phone+'</p>'+
                                        '<p>Modelo: '+model+'</p>'+
                                        '<p>Categoria: '+textCategory+'</p>';

                            $('#edit_success .itens').html(itens);
                            //==============================================================

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

    $('.edit_vehicle .btn_close').click(function(){
        $('.edit_vehicle_screen').fadeOut('fast');
    });

    $('#edit_success .btn_fechar').click(function(){
        $('.edit_vehicle_screen').fadeOut('fast');
    });

    $('#edit_success .btn_voltar').click(function(){
        $('#edit_success').fadeOut('fast', function(){
            $('#form_edit_vehicle').fadeIn('fast').css({'display':'flex'});
        });
    });

    $('.vehicles summary').click(function(){  
        var status = $(this).data('status');
        var position = $(this).data('position');       

        if(position != ''){
            if(status == 1){
                getPosition(position);
                $(this).data('status', '0');   
            }
        }
    });

    function startMap(){
        var position = $('#1 summary').data('position');

        if(position != ''){
            getPosition(position);
        }
    }

    function getPosition(idPosition){
        var url = P_BASE_URL+"requisicoes/getPosition/";

        $.ajax({
                url: url,
                type: 'POST',
                dataType: 'JSON',
                data: {idPosition: idPosition},
                cache: false,
                success: function(result){    
                    if(result.status){
                        initMap(parseFloat(result.latitude), parseFloat(result.longitude), result.devicetime);
                    }else{
                        $('#map'+veiculoAtual).css({'display':'none'});
                        $('#'+veiculoAtual+' .invalid_map').css({'display':'block'});
                    }
                },
                error: function(){
                    $('#map'+veiculoAtual).css({'display':'none'});
                    $('#'+veiculoAtual+' .invalid_map').css({'display':'block'});
                }
        });   
    }
    
    function initMap(latitude, longitude, data){
        var name = $('#'+veiculoAtual+' .btn_edit_vehicle').data('name');
        $('#'+veiculoAtual+' .position b').html(data);
        var location = {lat: latitude, lng: longitude};

        var map = new google.maps.Map(document.getElementById('map'+veiculoAtual), {
            center: location,
            zoom: 18,
            mapTypeId: 'hybrid'
        });

        var marker = new google.maps.Marker({
            position: location,
            title: name,
            map: map,
            animation: google.maps.Animation.DROP
        });

        var infowindow = new google.maps.InfoWindow(), marker;

        google.maps.event.addListener(marker, 'click', (function(marker, i) {
            return function() {
                infowindow.setContent("<h3 style='margin:0'>"+name+"</h3>");
                infowindow.open(map, marker);
            }
        })(marker));
    }

    function btnEdit(status){
        var inputEdit = $('.form_edit_vehicle :input');
        var btnEdit = $('.form_edit_vehicle .btn_edit :input');

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
}
});