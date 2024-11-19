<?php

    db_query("update songs set views = views + 1 where id = :id limit 1", ['id' => $row['id']]);

?>
<!-- Music cart -->
<div class="music-card-full" style="max-width: 800px;">

    <center>
        <h1 class="card-title"><?=esc($row['title'])?></h1>
        <div class="card-subtitle"><?=esc(getArtists(($row['artist_id'])))?></div>
    </center>

    <div style="overflow: hidden;">
        <a href="<?=ROOT?>/song/<?=$row['slug']?>">
            <img src="<?=ROOT?>/<?=$row['image']?>" alt="">
        </a>
    </div>
    <div class="card-content">
        <audio controls style="width:  100%;">
            <source src="<?=ROOT?>/<?=$row['file']?>" type="audio/mpeg">
        </audio>

        <div>Views: <?=$row['views']?></div>
        <div>Created at: <?=get_date($row['date'])?></div>
        
        <a href="<?=ROOT?>/download/<?=$row['slug']?>">
            <button class="btn bg-purple m-2">Download</button>
        </a>
    </div>
</div>