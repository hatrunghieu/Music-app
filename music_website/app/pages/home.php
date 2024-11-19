<?php	require page('includes/header') ?>
	<section>
		<img class="hero" src="<?=ROOT?>/assets/images/ban.png" alt="" srcset="">
	</section>

	<center><div class="section-title">Feartures</div></center>
	<section class="content">

		<?php

			$rows = db_query("select * from songs where features = 1 order by id desc limit 16");

		?>

		<?php if(!empty($rows)):?>
			<?php foreach($rows as $row):?>
				<?php include page('includes/song')?>
			<?php endforeach;?>
		<?php else:?>
			<div class="m-2">No song found!</div>
		<?php endif;?>


	</section>
	

<?php require page('includes/footer') ?>
