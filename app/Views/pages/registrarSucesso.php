<section class="ac_banner">
	<div class="container column">
		<div class="ac_banner_title">
			<h1>ÁREA DO CLIENTE</h1>
			<p>Olá, <?=$user['firstName']?>!</p>
		</div>
	</div>
</section>
<section id="conteudo">
	<div class="container" style="flex-direction: column">

        <?php if(!$statusLogin){ ?>
        <h3><?=$user['firstName']?> obrigado por se cadastrar na RSM Bloqueador !</h3>
        <h3>Enviamos um e-mail para <?=$user['email']?> com as instruções para ativar a sua conta.</h3>
        <?php } ?>

        <?php if(!empty($transaction)){ ?>
        <h3>Status da compra: <?=$transaction['status']?></h3>
        <h3>Code: <?=$transaction['code']?></h3>

        <?php if($transaction['statusBoleto']){ ?>
        <h3>Boleto: <a href="<?=$transaction['linkBoleto']?>" target="_blank">Segunda via do Boleto</a></h3>
        <?php } ?>
        <?php } else{ ?>
        <h3><?=$user['firstName']?>, cancelou à compra!!!</h3>
        <?php } ?>
	</div>
</section>