<div class='row'>
    <div class='col'>
        <img src='<?=$member['league']['iconUrls']['small']?>' width='70px' alt=''>
    </div>
</div>
<div class='row'>
    <div class='col'><?=$member['tag']?></div>
</div>
<div class='row'>
    <div class='col'><?=$member['name']?></div>
</div>
<div class='row'>
    <div class='col'><?=getTraslation($member['role'])?></div>
</div>
<div class='row'>
    <div class='col'><i class='ni ni-trophy'></i> <?=$member['trophies']?></div>
</div>