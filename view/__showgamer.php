<?php
if (!Session::Auth() || !isset($_GET['tag'])) {
    header('Location: ./?view=login');
}

$filter = ['lassi', 'mightyyak', 'electroowl', 'unicorn'];
$animals = [];

$tag = '#' . $_GET['tag'];
$player = $client->getPlayer($tag)->getPlayerInfo();
$filterSuperTroopName = getSuperTroopsName();
$superTroops = [];

?>

<div class="container-fluid d-flex align-items-center">
    <div class="row">
        <div class="col">
            <h1 class="display-3 text-white"><img src="<?= $player['league']['iconUrls']['small'] ?>" alt=""> <?= $player['name'] ?> (<strong class="text-muted"><?= getTraslation($player['role']) ?></strong>)</h1>
            <h1 class="display-7 text-white">Aldea Principal</h1>
            <div class="row">
                <div class="col">
                    <h5 class="display-7 text-white">Tropas</h5>
                    <?php foreach ($player['troops'] as $troop) : ?>
                        <?php $troopName = strtolower(str_replace(' ', '', $troop['name'])); ?>
                        <?php if (!in_array($troopName, $filterSuperTroopName)) : ?>
                            <?php include $views['label']; ?>
                            <?php
                            $superTroop = getSuperTroop($troop);
                            if (count($superTroop) > 0 && $troop['village'] == 'home') {
                                $superTroops[$superTroop['name']] = $superTroop;
                            }
                            ?>
                        <?php endif; ?>
                    <?php endforeach; ?>
                    <?php $filter = []; ?>

                    <?php if (count($player['heroes']) > 0) : ?>
                        <br><br>
                        <h5 class="display-7 text-white">H&eacute;roes</h5>
                    <?php endif; ?>
                    <?php foreach ($player['heroes'] as $troop) : ?>
                        <?php include $views['label'] ?>
                    <?php endforeach; ?>
                    <?php if (count($animals) > 0) : ?>
                        <br><br>
                        <h5 class="display-7 text-white">Animales</h5>
                        <?php foreach ($animals as $troop) : ?>
                            <?php include $views['label'] ?>
                        <?php endforeach; ?>
                    <?php endif; ?>
                    <?php if ($view != 'profile') : ?>
                        <hr class="bg-white">
                        <h5 class="display-7 text-white">Información</h5>
                        <button class="btn btn-default" onclick="copyText(this)" data-toggle="tooltip" title="Click Para Copiar"><?= $player['tag'] ?></button>
                        <?php if (isset($player['league']['name'])) : ?>
                            <h5 class="display-7 text-white">Liga: <?= $player['league']['name'] ?></h5>
                        <?php endif; ?>
                        <h5 class="display-7 text-white">Victorias en:</h5>
                        <ul class="text-white">
                            <li>Ataques: <?= $player['attackWins'] ?></li>
                            <li>Defenza: <?= $player['defenseWins'] ?></li>
                        </ul>
                        <?php if (count($player['labels'])) : ?>
                            <h5 class="display-7 text-white">Etiquetas</h5>
                            <?php foreach ($player['labels'] as $label) : ?>
                                <img src="<?= $label['iconUrls']['small'] ?>" width="50px" data-toggle="tooltip" title="<?= getTraslation(strtolower(str_replace(' ', '', $label['name']))) ?>" alt="">
                            <?php endforeach; ?>
                        <?php endif; ?>
                    <?php endif; ?>
                </div>
                <div class="col">
                    <?php if (count($player['spells']) > 0) : ?>
                        <h5 class="display-7 text-white">Hechizos</h5>
                    <?php endif; ?>
                    <?php foreach ($player['spells'] as $troop) : ?>
                        <?php include $views['label'] ?>
                    <?php endforeach; ?>
                    <?php if (count($superTroops) > 0) : ?>
                        <br><br>
                        <h5 class="display-7 text-white">Super Tropas</h5>
                        <?php foreach ($superTroops as $troop) : ?>
                            <?php include $views['label'] ?>
                        <?php endforeach; ?>
                        <br><br>
                    <?php endif; ?>
                    <?php if ($view != 'profile') : ?>
                        <h5 class="display-7 text-white">Ayuntamiento</h5>
                        <div class="row">
                            <div class="col">
                                <?php if (isset($img['th']['th' . $player['townHallLevel']])) : ?>
                                    <img width="200px" src="<?= $img['th']['th' . $player['townHallLevel']] ?>">
                                <?php endif; ?>
                            </div>
                            <div class="col text-white">
                                <label for=""><strong>Nivel</strong> <?= $player['townHallLevel'] ?></label><br>
                                <label for=""><strong><i class="fas fa-award"></i></strong> <?= $player['expLevel'] ?> exp</label><br>
                                <label for=""><strong><i class="fas fa-trophy"></i></strong> <?= $player['trophies'] ?></label><br>
                                <label for=""><strong><i class="fas fa-star"></i></strong> <?= $player['warStars'] ?></label><br>
                                <hr class="bg-white">
                                <label for=""><strong>Clan</strong></label><br>
                                <center>
                                    <img src="<?= $player['clan']['badgeUrls']['small'] ?>" width="80px" alt=""><br>
                                    <?= $player['clan']['name'] ?>
                                    <button class="btn btn-default" onclick="copyText(this)" data-toggle="tooltip" title="Click Para Copiar"><?= $player['clan']['tag'] ?></button>
                                </center>
                            </div>
                            <div class="col text-white">
                                <label for="">
                                    El mejor de la historía: <br>
                                    <strong><i class="fas fa-trophy"></i></strong> <?= $player['bestTrophies'] ?>
                                </label><br>
                                <label for="">
                                    <strong>Donaciones:</strong> <br>
                                    Realizadas: <?= $player['donations'] ?> <br>
                                    Recividas: <?= $player['donationsReceived'] ?>
                                </label>
                            </div>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>