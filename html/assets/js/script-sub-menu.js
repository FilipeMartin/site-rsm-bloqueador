$(document).ready(function() {

	$('#menu_mobile').click(function() {

		var sub_menu = $('#sub_menu');
		var btn_barra_top = $('.mm_line_top');
		var btn_barra_center = $('.mm_line_center');
		var btn_barra_bottom = $('.mm_line_bottom');

		if(sub_menu.css('display') == 'flex'){
			sub_menu.css({'display':'none'});
			
			btn_barra_top.css({'transform':'none'});
			btn_barra_center.css({'display':'block'});
			btn_barra_bottom.css({'transform':'none'});

		}else{
			sub_menu.css({'display':'flex'});
			
			btn_barra_top.css({'transform':'translate(0,6px) rotate(45deg)'});
			btn_barra_center.css({'display':'none'});
			btn_barra_bottom.css({'transform':'translate(0,-13px) rotate(-45deg)'});
		}

	});

});