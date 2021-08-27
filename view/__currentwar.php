<?php

$members = [];
$opponents = [];

$currentWar['clan']['members'] = orderListWar($currentWar['clan']['members']);
$currentWar['opponent']['members'] = orderListWar($currentWar['opponent']['members']);

$cont = 1;
$access = false;

if (!Session::Auth()) {
    header('Location: ./?view=login');
}

$idTab = md5($currentWar['clan']['tag'] . '-' . $currentWar['opponent']['tag']); // identificador de ventana
$fileName = md5(explode('T', $currentWar['endTime'])[0] . (str_replace('#', '', Session::getClanTag())));

file_put_contents("./json/wars/$fileName.json", json_encode($currentWar['clan']['members']));

$attacks = (count($currentWarLeagueGroup) > 1) ? 1 : 2;

?>


<div class="card">
    <div class="card-header">Registro de la Guerra Actual</div>
    <div class="card-body">
        <div class="row">
            <div class="col">
                <div class="row">
                    <div class="col">
                        <center>
                            <img src="<?= $currentWar['clan']['badgeUrls']['small'] ?>" alt=""><br>
                            <span class="badge badge-default">
                                <?= $currentWar['clan']['name'] ?>
                            </span>
                        </center>
                    </div>
                    <div class="col">
                        <h5 class="diplay-9">
                            Da&nacute;o: <?= $currentWar['clan']['destructionPercentage'] ?>%
                        </h5>
                        <div class="progress">
                            <div class="progress-bar bg-success" role="progressbar" aria-valuenow="<?= $currentWar['clan']['destructionPercentage'] ?>" aria-valuemin="0" aria-valuemax="100" style="width: <?= $currentWar['clan']['destructionPercentage'] ?>%;"></div>
                        </div>
                        <h5 class="display-9">Ataques: <?= $currentWar['clan']['attacks'] . ' / ' . ($currentWar['teamSize'] * ((isset($currentWarLeagueGroup['rounds']) ? 1 : 2))) ?></h5>
                        <i class="fas fa-star" style="font-size: 15px"></i> <?= $currentWar['clan']['stars'] ?> / <?= $currentWar['teamSize'] * 3 ?>
                    </div>
                </div>
            </div>
            <div class="col">
                <center>
                    <h2 class="badge badge-default">
                        <?= $currentWar['teamSize'] ?> vs <?= $currentWar['teamSize'] ?>
                    </h2>
                    <h5>Preparaci&oacute;n: <?= toDate($currentWar['preparationStartTime']) ?></h5>
                    <h5>Inicio: <?= toDate($currentWar['startTime']) ?></h5>
                    <h5>Fin: <?= toDate($currentWar['endTime']) ?></h5>
                    <span class="badge badge-success"></span>
                </center>
            </div>
            <div class="col">
                <div class="row">
                    <div class="col">
                        <center>
                            <img src="<?= $currentWar['opponent']['badgeUrls']['small'] ?>" alt=""><br>
                            <span class="badge badge-default">
                                <?= $currentWar['opponent']['name'] ?>
                            </span>
                        </center>
                    </div>
                    <div class="col">
                        <h5 class="diplay-9">
                            Da&nacute;o: <?= $currentWar['opponent']['destructionPercentage'] ?>%
                        </h5>
                        <div class="progress">
                            <div class="progress-bar bg-success" role="progressbar" aria-valuenow="<?= $currentWar['opponent']['destructionPercentage'] ?>" aria-valuemin="0" aria-valuemax="100" style="width: <?= $currentWar['opponent']['destructionPercentage'] ?>%;"></div>
                        </div>
                        <h5 class="display-9">Ataques: <?= $currentWar['opponent']['attacks'] . ' / ' . ($currentWar['teamSize'] * ((isset($currentWarLeagueGroup['rounds']) ? 1 : 2))) ?></h5>
                        <i class="fas fa-star" style="font-size: 15px"></i> <?= $currentWar['opponent']['stars'] ?> / <?= $currentWar['teamSize'] * 3 ?>
                    </div>
                </div>
            </div>
        </div>
        <br>
        <div id="printtab_<?= $idTab ?>">
            <div class="row" style="background-image: url('<?= $img['war']['clan'] ?>');background-position: center;background-repeat: no-repeat;background-size: cover;">
                <div class="col text-black">
                    <?php foreach ($currentWar['clan']['members'] as $keyMember => $member) : ?>
                        <?php include $views['rowMembers'] ?>
                    <?php endforeach; ?>
                </div>
                <?php
                $cont = 1;
                $access = false;
                ?>
                <div class="col">
                    <?php foreach ($currentWar['opponent']['members'] as $keyMember => $member) : ?>
                        <?php include $views['rowMembers'] ?>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </div>
    <div class="card-footer">
        Estado: <?= getTraslation($currentWar['state']) ?>
        <br>
        <?php if (count($currentWarLeagueGroup) == 1) : ?>
            <a href="./?view=featured&data=<?= $fileName ?>" target="__blanck"><i class="fas fa-download"></i> Desempeño</a>
        <?php endif; ?>
    </div>
</div>