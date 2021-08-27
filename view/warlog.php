<?php
$victory = 0;
$loser = 0;
$tie = 0;
$exp = 0;
$starWar = 0;

$filter = isset($_GET['s']) ? strtolower($_GET['s']) : '';
if (!empty($filter)) {
    foreach ($warlog['items'] as $key => $war) {
        if ($war['clan']['stars'] <= 100) {
            $values = [
                strtolower($war['clan']['name']),
                strtolower($war['clan']['destructionPercentage']),
                strtolower($war['opponent']['destructionPercentage']),
                strtolower($war['teamSize']),
                strtolower($war['clan']['stars']),
                strtolower($war['clan']['expEarned']),
                strtolower($war['opponent']['name']),
                strtolower($war['opponent']['stars']),
                (strtolower($war['result']) == 'lose') ? 'derrota' : ((strtolower($war['result']) == 'tie') ? 'empate' : 'victoria')
            ];
        }

        if (!inArraySearch($filter, $values)) {
            unset($warlog['items'][$key]);
        }
    }
}
?>
<div class="container-fluid mt-7">
    <?php
    //showArray($warlog);
    ?>
    <div class="row">
        <div class="col-8">
            <table class="table">
                <tbody class="text-white">
                    <?php foreach ($warlog['items'] as $war) : ?>
                        <?php if ($war['clan']['destructionPercentage'] <= 100) : ?>
                            <tr style="background-color: <?= getColorResultWar($war['result']) ?>">
                                <td>
                                    <div class="row">
                                        <div class="col-4">
                                            <img src="<?= $war['clan']['badgeUrls']['small'] ?>" alt="">
                                        </div>
                                        <div class="col">
                                            <?= $war['clan']['name'] ?><br>
                                            <i class="fas fa-fire-alt"></i>
                                            <?= round($war['clan']['destructionPercentage'], 2) ?>% <br>
                                            <i class="fas fa-star"></i>
                                            <?= $war['clan']['stars'] ?><br>
                                            <i class="fas fa-award"></i> <?= $war['clan']['expEarned'] ?> exp
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <i class="fas fa-star" style="font-size: 10px;"></i>
                                    <i class="fas fa-star" style="font-size: 15px;"></i>
                                    <i class="fas fa-star" style="font-size: 10px;"></i><br>
                                    <?= $war['teamSize'] ?> VS <?= $war['teamSize'] ?><br><br>
                                </td>
                                <td>
                                    <div class="row">
                                        <div class="col-2">
                                            <img src="<?= $war['opponent']['badgeUrls']['small'] ?>" alt="">
                                        </div>
                                        <div class="col">
                                            <?= $war['opponent']['name'] ?><br>
                                            <i class="fas fa-fire-alt"></i>
                                            <?= round($war['opponent']['destructionPercentage'], 2) ?>%<br>
                                            <i class="fas fa-star"></i> <?= $war['opponent']['stars'] ?>
                                        </div>
                                        <div class="col">
                                            <div class="text-right"><?= strtoupper(getTraslation($war['result'])) ?></div>
                                            <div class="text-right">
                                                <?php $fileNameData = md5(explode('T', $war['endTime'])[0] . (str_replace('#', '', Session::getClanTag())));?>
                                                <?php if (file_exists("./json/wars/" . $fileNameData . ".json")) : ?>
                                                    <a href="./?view=featured&data=<?= $fileNameData ?>" target="__blanck" class="text-white"><i class="fas fa-chart-pie"></i> Desempe&nacute;o</a>
                                                <?php else : ?>
                                                    <br>
                                                <?php endif; ?>
                                            </div>
                                            <br>
                                            <div class="text-right"><?= toDate($war['endTime']) ?></div>
                                        </div>
                                    </div>
                                </td>

                            </tr>

                            <?php
                            $exp += $war['clan']['expEarned'];
                            if ($war['result'] == 'win') {
                                $victory++;
                            } elseif ($war['result'] == 'lose') {
                                $loser++;
                            } elseif ($war['result'] == 'tie') {
                                $tie++;
                            }
                            ?>

                        <?php endif; ?>
                    <?php endforeach; ?>
                </tbody>
            </table>

        </div>
        <div class="col">
            <div class="card">
                <div class="card-header">INFORMACIÓN</div>
                <div class="card-body">
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item">Victorias: <?= $victory ?></li>
                        <li class="list-group-item">Derrotas: <?= $loser ?></li>
                        <li class="list-group-item">Empates: <?= $tie ?></li>
                        <li class="list-group-item">Experiencia: <?= $exp ?></li>
                        <li class="list-group-item">Total de Guerras: <?= $victory + $loser + $tie ?></li>
                    </ul>
                </div>
                <div class="card-footer">
                    <form action="" method="get">
                        <div class="input-group input-group-alternative input-group-merge">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fas fa-search"></i></span>
                            </div>
                            <input type="hidden" name="view" value="<?= $view ?>">
                            <input class="form-control" placeholder="Filtrar Guerras" name="s" type="text">
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>