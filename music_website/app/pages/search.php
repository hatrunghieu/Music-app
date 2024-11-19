<?php	require page('includes/header') ?>

	<div class="section-title">Search</div>
	<section class="content">

		<?php

            $title = $_GET['search-each'] ?? null;    

            if (!empty($title)) {

                $title = "%$title%";
                $query = "select * from songs where title like :title order by views desc limit 24";
                $rows = db_query($query, ['title' =>$title]);
    
            }
		?>

		<?php if(!empty($rows)):?>
			<?php foreach($rows as $row):?>
				<?php include page('includes/song')?>
			<?php endforeach;?>
		<?php endif;?>


	</section>
	

<?php require page('includes/footer') ?>
