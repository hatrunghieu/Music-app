<!-- Music cart -->
<div class="music-card">
    <div style="overflow: hidden;">
        <a href="<?=ROOT?>/song/<?=$row['slug']?>">
            <img src="<?=ROOT?>/<?=$row['image']?>" alt="">
        </a>
    </div>
    <div class="card-content">
        <div class="card-title"><?=esc($row['title'])?></div>
        <div class="card-subtitle my-1"><?=esc(getArtists(($row['artist_id'])))?></div>
        <div class="card-subtitle my-1  "><?=esc(getCategory(($row['category_id'])))?></div>

    </div>
</div>