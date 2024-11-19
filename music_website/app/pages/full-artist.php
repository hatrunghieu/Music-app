<!-- Music cart -->
<div class="music-card-full" style="max-width: 800px;">

    <center>
        <h1 class="card-title"><?=esc($row['name'])?></h1>
    </center>

    <div style="overflow: hidden;">
        <img src="<?=ROOT?>/<?=$row['image']?>" alt="">
    </div>
    <div class="card-content">
        <div>
            <?=$row['bio']?>
        </div>

        <div>
            Artist Songs: 
        </div>

        <div style="display: flex; flex-wrap: wrap; justify-content: center;">
            <?php

                $query = "select * from songs where artist_id = :artist_id order by views desc limit 20";
                $song = db_query($query, ['artist_id' =>$row['id']]);

            ?>

            <?php if(!empty($song)):?>
                <?php foreach($song as $row):?>
                    <?php include page('includes/song')?>
                <?php endforeach;?>
            <?php endif;?>
        </div>

    
    </div>
</div>