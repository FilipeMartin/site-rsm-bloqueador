<?php $user = unserialize($_SESSION['user']['data']); ?>
<section class="ac_banner">
	<div class="container column">
		<div class="ac_banner_title">
			<h1>ÁREA DO CLIENTE</h1>
			<p>Olá, <?=$user->getFirstName()?>!</p>
		</div>
	</div>
</section>