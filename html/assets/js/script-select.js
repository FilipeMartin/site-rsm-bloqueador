$(document).ready(function() {

if(window.location.href == P_BASE_URL){

	var statusLogin = $('nav .btn_login_user').attr('data-login');

	$('#select_trimestral').change(function() {
		var itemSelecionado = $('#select_trimestral option:selected');
		var valorTotal = $('.valor_trimestral');
		var valorMes = $('.valor_trimestral_mes');

		if(itemSelecionado.val() == 1 ){
			valorTotal.html(P_VALOR_TRIMESTRAL[0]);
			valorMes.html(P_VALOR_TRIMESTRAL_MES[0]);

		} else if(itemSelecionado.val() == 2 ){
			valorTotal.html(P_VALOR_TRIMESTRAL[1]);
			valorMes.html(P_VALOR_TRIMESTRAL_MES[1]);
		}
    });

    $('#select_semestral').change(function() {
		var itemSelecionado = $('#select_semestral option:selected');
		var valorTotal = $('.valor_semestral');
		var valorMes = $('.valor_semestral_mes');

		if(itemSelecionado.val() == 1 ){
			valorTotal.html(P_VALOR_SEMESTRAL[0]);
			valorMes.html(P_VALOR_SEMESTRAL_MES[0]);

		} else if(itemSelecionado.val() == 2 ){
			valorTotal.html(P_VALOR_SEMESTRAL[1]);
			valorMes.html(P_VALOR_SEMESTRAL_MES[1]);
		}
    });

    $('#select_anual').change(function() {
		var itemSelecionado = $('#select_anual option:selected');
		var valorTotal = $('.valor_anual');
		var valorMes = $('.valor_anual_mes');

		if(itemSelecionado.val() == 1 ){
			valorTotal.html(P_VALOR_ANUAL[0]);
			valorMes.html(P_VALOR_ANUAL_MES[0]);

		} else if(itemSelecionado.val() == 2 ){
			valorTotal.html(P_VALOR_ANUAL[1]);
			valorMes.html(P_VALOR_ANUAL_MES[1]);
		}
    });

    $('.banner_body1 .btn_contratar_agora').click(function(){

    	var plano = 1;
    	var qtdVeiculos = $('#select_trimestral option:selected').val();
    	request(plano, qtdVeiculos);
    });

    $('.banner_body2 .btn_contratar_agora').click(function(){

    	var plano = 2;
    	var qtdVeiculos = $('#select_semestral option:selected').val();
    	request(plano, qtdVeiculos);
    });

    $('.banner_body3 .btn_contratar_agora').click(function(){

    	var plano = 3;
    	var qtdVeiculos = $('#select_anual option:selected').val();
    	request(plano, qtdVeiculos);
    });

    function request(plano, qtdVeiculos){

		var url = P_BASE_URL+"requisicoes/dados_venda/";
		var etapaRegistro = (statusLogin?2:1);
		var idVeiculo = 'MA==';

		$.ajax({
	            url: url,
	            type: 'POST',
	            dataType: 'JSON',
	            data: {tipoPlano: plano, veiculo: idVeiculo, qtdVeiculos: qtdVeiculos, formaPagamento: 0, etapaRegistro: etapaRegistro},
	            cache: false,
	            beforeSend: function(){
	            	$('.btn_contratar_agora').attr('disabled', 'disabled');
                },
	            success: function(result){
	            	if(result.status){
	            		window.location.href = P_BASE_URL+"registrar/servico/";
	            	}
	            	$('.btn_contratar_agora').removeAttr('disabled');
	            },
	            error: function(){
	                alert('Erro na requisição!');
	                $('.btn_contratar_agora').removeAttr('disabled');
	            }
	    });
    }
}    
});