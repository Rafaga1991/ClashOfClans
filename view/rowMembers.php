<?php
$idModal = 'info-' . md5($member['name'] . $keyMember . rand(0, 100) . time());
$attacks_T = isset($member['attacks']) ? ($attacks - count($member['attacks'])) : $attacks;
?>
<div class="row">
    <?php if ($cont == 1) : ?>
        <div class="col">
            <?php include $views['colMember']; ?>
        </div>
        <div class="col"></div>
        <div class="col"></div>
    <?php elseif ($cont == 2) : ?>
        <div class="col"></div>
        <div class="col">
            <?php include $views['colMember']; ?>
        </div>
        <div class="col"></div>
    <?php elseif ($cont == 3) : ?>
        <div class="col"></div>
        <div class="col"></div>
        <div class="col">
            <?php include $views['colMember']; ?>
        </div>
    <?php endif; ?>
    <!-- Modal -->
    <div class="modal fade" id="<?= $idModal ?>" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content bg-gradient-warning">
                <div class="modal-header">
                    <h5 class="modal-title text-white">
                        <img src="<?= $img['th']['th' . $member['townhallLevel']] ?>" width="60px" alt="">
                        <?= $member['mapPosition'] . '. ' . $member['name'] ?>
                    </h5>

                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <h4 class="display-8 text-white">Ataques Realizados: <?= isset($member['attacks']) ? count($member['attacks']) : 0 ?></h4>
                    <table class="table">
                        <thead class="text-white">
                            <tr>
                                <th>Nombre</th>
                                <th>Estrellas</th>
                                <th>Tiempo</th>
                            </tr>
                        </thead>
                        <tbody class="text-white">
                            <?php if (isset($member['attacks'])) : ?>
                                <?php foreach ($member['attacks'] as $keyMember => $attack) : ?>
                                    <?php $player = getPlayer($currentWar, $attack['defenderTag']) ?>
                                    <tr>
                                        <td>
                                            <img src="<?= $img['th']['th' . $player['townhallLevel']] ?>" width="40px" alt="" />
                                            <?= $player['mapPosition'] . '. ' . $player['name'] ?>
                                        </td>
                                        <td>
                                            <center>
                                                <?php
                                                $stars = $attack['stars'];
                                                include $views['__start'];
                                                ?>
                                                <br>
                                                <?= $attack['destructionPercentage'] ?>%
                                            </center>
                                        </td>
                                        <td><?= getDuration($attack['duration']) ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </tbody>
                    </table>
                    <hr class="bd-white">
                    <?php $members = getPlayerAttack($currentWar, $member['tag']); ?>
                    <h4 class="display-8 text-white">Defenza: <?= count($members) ?></h4>
                    <table class="table">
                        <thead class="text-white">
                            <tr>
                                <th>Nombre</th>
                                <th>Estrellas</th>
                                <th>Tiempo</th>
                            </tr>
                        </thead>
                        <tbody class="text-white">
                            <?php foreach ($members as $keyMember => $attack) : ?>
                                <tr>
                                    <td>
                                        <img src="<?= $img['th']['th' . $attack['townhallLevel']] ?>" width="40px" alt="" />
                                        <?= $attack['mapPosition'] . '. ' . $attack['name'] ?>
                                    </td>
                                    <td>
                                        <center>
                                            <?php
                                            $stars = $attack['attacks']['stars'];
                                            include $views['__start'];
                                            ?><br>
                                            <?= $attack['attacks']['destructionPercentage'] ?>%
                                        </center>
                                    </td>
                                    <td><?= getDuration($attack['attacks']['duration']) ?></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                </div>
            </div>
        </div>
    </div>
    <?php
    if ($cont < 3 && !$access) {
        $cont++;
        $access = $cont == 3;
    } elseif ($cont > 0) {
        $cont--;
        if ($cont == 1) {
            $access = false;
        }
    }
    ?>
    <div class="col"></div>
    <div class="col"></div>
</div>