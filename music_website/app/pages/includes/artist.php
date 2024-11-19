<!-- Artist cart -->
<div class="music-card">
    <div style="overflow: hidden;">
        <a href="<?=ROOT?>/artist/<?=$row['id']?>">
            <img src="<?=ROOT?>/<?=$row['image']?>" alt="">
        </a>
    </div>
    <div class="card-content">
        <div class="card-title"><?=esc(ucwords($row['name']))?></div>
        <div class="card-subtitle" style="font-style: 11px;"><?=esc(substr($row['bio'], 0, 50))?></div>
    </div>
</div>