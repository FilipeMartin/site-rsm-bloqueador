<!DOCTYPE html>
<html lang="pt-br">
<head>
	<meta charset="utf-8"/>
	<meta name="viewport" content="width=device-width,user-scalable=0"/>
	<link rel="shortcut icon" href="<?=BASE_URL?>assets/images/favicon.ico" />
	<link rel="stylesheet" type="text/css" href="<?=BASE_URL?>assets/css/style.css"/>
	<title>RSM Bloqueador</title>
</head>
<body>
	<header>
		<div class="container">
			<div class="logo">
				<a href="<?=BASE_URL?>"><img src="<?=BASE_URL?>assets/images/logo.png"/></a>
			</div>
			<div class="header_telefones">
				<span>(21) 99825-9550</span>
				<span>(21) 99639-6999</span>
				<span class="txt_atend_domic">*Atendimento em domicílio</span>
			</div>
			<div class="menu">
				<nav>
					<div class="menu_mobile" id="menu_mobile">
						<div class="mm_line_top"></div>
						<div class="mm_line_center"></div>
						<div class="mm_line_bottom"></div>
					</div>
					<ul id="sub_menu">
						<li id="btn_menu_inicio" alt="Início" title="Início"><a href="<?=BASE_URL?>">Início</a></li>
						<li alt="Logar na Plataforma" title="Logar na Plataforma"><a href="<?=BASE_URL_PLATFORM?>">Logar na Plataforma</a></li>
						<li alt="Área do Cliente" title="Área do Cliente"><div id="btn_menu_login" class="btn_login_user" data-login="<?=$statusLogin?>">Área do Cliente</div></li>
						<li id="btn_menu_contato" alt="Contato" title="Contato"><a href="">Contato</a></li>
						<?php if($statusLogin){ ?>
						<li alt="Sair" title="Sair"><a href="<?=BASE_URL?>area_cliente/sair/">Sair</a></li>
						<?php } ?>
					</ul>
				</nav>
			</div>
		</div>
	</header>
		<?php $this->loadViewInTemplate($viewName, $viewData); ?>
	<footer>
		<div class="container align-items">
			<div class="footer_copy">
				Todos os direitos reservados - Copyright © RSM Bloqueador.
			</div>
			<div class="footer_cartoes">
				<img src="<?=BASE_URL?>assets/images/img_visa.png"/>
				<img src="<?=BASE_URL?>assets/images/img_master_card.png"/>
			</div>
			<div class="footer_social">
				<ul>
					<li><a href="mailto:rsmbloqueador@gmail.com" alt="rsmbloqueador@gmail.com" title="rsmbloqueador@gmail.com">
							<img src="<?=BASE_URL?>assets/images/icone_email.png"/>
						</a>
					</li>
					<li><a href="" alt="Facebook" title="Facebook" target="_blank">
							<img src="<?=BASE_URL?>assets/images/icone_facebook.png"/>
						</a>
					</li>
					<li><a href="https://www.youtube.com/channel/UC65tHjkcRNIj7L4PqVdfWnA" alt="YouTube" title="YouTube" target="_blank">
							<img src="<?=BASE_URL?>assets/images/icone_youtube.png"/>
						</a>
					</li>
				</ul>
			</div>
			<div class="footer_telefones">
				<span>(21) 99825-9550</span>
				<span>(21) 99639-6999</span>
				<span class="txt_atend_domic">*Atendimento em domicílio</span>
			</div>
		</div>
	</footer>
	<div class="login_screen">
		<div class="login_box">						
			<div class="title">
				<h1>Área do Cliente</h1>
				<div class="btn_close"></div>
			</div>			
			<form id="form_login">
				<div class="custom-input">
					<label for="login">Login</label>
					<input type="text" name="login" id="login">
				</div>
				<div class="custom-input">
					<label for="password">Senha</label>
					<input type="password" name="password" id="password">
				</div>
				<span class="msg_input_error"></span>
				<div class="btn_login">
					<input type="submit" class="btn_blue" value="Entrar">
				</div>
			</form>	
			<div class="recover_password">
				<a href="<?=BASE_URL?>recuperar_senha/" alt="Esqueceu sua senha?" title="Esqueceu sua senha?">Esqueceu sua senha?</a>
			</div>			
		</div>
	</div>
	<div class="ssl"></div>
	<div class="loading_screen"><div class="gif_loading"></div></div>
	<script type="text/javascript">
		var P_BASE_URL = "<?=BASE_URL?>";
		var P_BASE_URL_PLATFORM = "<?=BASE_URL_PLATFORM?>";
		var P_VALOR_TRIMESTRAL = ["<?=$valor_trimestral[0]?>", "<?=$valor_trimestral[1]?>"];
		var P_VALOR_SEMESTRAL = ["<?=$valor_semestral[0]?>", "<?=$valor_semestral[1]?>"];
		var P_VALOR_ANUAL = ["<?=$valor_anual[0]?>", "<?=$valor_anual[1]?>"];
		var P_VALOR_TRIMESTRAL_MES = ["<?=$valor_trimestral_mes[0]?>", "<?=$valor_trimestral_mes[1]?>"];
		var P_VALOR_SEMESTRAL_MES = ["<?=$valor_semestral_mes[0]?>", "<?=$valor_semestral_mes[1]?>"];
		var P_VALOR_ANUAL_MES = ["<?=$valor_anual_mes[0]?>", "<?=$valor_anual_mes[1]?>"];
	</script>
	<script type="text/javascript" src="<?=BASE_URL?>assets/js/script-menu-check.js"></script>
	<script type="text/javascript" src="<?=BASE_URL?>assets/js/jquery-3.2.1.min.js"></script>
	<script type="text/javascript" src="<?=BASE_URL?>assets/js/jquery.mask.min.js"></script>
	<script type="text/javascript" src="<?=BASE_URL?>assets/js/jquery.validate.min.js"></script>
	<script type="text/javascript" src="<?=BASE_URL?>assets/js/additional-methods.min.js"></script>
	<script type="text/javascript" src="<?=BASE_URL?>assets/js/validate/messages_pt_BR.js"></script>
	<script type="text/javascript" src="<?=BASE_URL?>assets/js/datatables.min.js"></script>
	<script type="text/javascript" src="https://stc.<?=$pagseguroEnvironment?>pagseguro.uol.com.br/pagseguro/api/v2/checkout/pagseguro.lightbox.js"></script>
	<script type="text/javascript" src="<?=BASE_URL?>assets/js/script-login-user.js"></script>
	<script type="text/javascript" src="<?=BASE_URL?>assets/js/script-select.js"></script>
	<script type="text/javascript" src="<?=BASE_URL?>assets/js/script-sub-menu.js"></script>
	<script type="text/javascript" src="<?=BASE_URL?>assets/js/script-register-service.js"></script>
	<script type="text/javascript" src="<?=BASE_URL?>assets/js/script-custom-input.js"></script>
	<script type="text/javascript" src="<?=BASE_URL?>assets/js/script-recover-password.js"></script>
	<script type="text/javascript" src="<?=BASE_URL?>assets/js/script-register-password.js"></script>
	<?php if($statusLogin){ ?>
	<script type="text/javascript" src="<?=BASE_URL?>assets/js/script-vehicle.js"></script>
	<script type="text/javascript" src="<?=BASE_URL?>assets/js/script-register-vehicle.js"></script>
	<script type="text/javascript" src="<?=BASE_URL?>assets/js/script-faturas.js"></script>
	<script type="text/javascript" src="<?=BASE_URL?>assets/js/script-my-account.js"></script>
	<script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDGgB1Pli8n2w4WGAjJsI1RA0NAYO6E8Sk&callback=initMap" type="text/javascript"></script>
	<?php } ?>
	<!-- <script type="text/javascript" src="https://www.google.com/recaptcha/api.js?hl=pt-BR&onload=onLoadCallback&render=explicit" async defer></script>
	<script type="text/javascript" src="assets/js/script-recaptcha.js"></script> -->
</body>
</html>