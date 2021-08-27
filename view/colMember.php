<center>
    <?php if (isset($member['bestOpponentAttack'])) : ?>
        <?php $stars = $member['bestOpponentAttack']['stars']; ?>
        <?php $memberBestAtack = getPlayerAttack($currentWar, $member['tag']); ?>
        <span data-toggle="tooltip" data-html="true" title="<?= $memberBestAtack[0]['mapPosition'] . '. ' . $memberBestAtack[0]['name'] ?> <br> <?= $member['bestOpponentAttack']['destructionPercentage'] ?>% de daño">
            <?php include $views['__start']; ?>
        </span>
    <?php endif; ?>
    <br />
    <a href="#" data-toggle="modal" data-target="#<?= $idModal ?>">
        <img src="<?= $img['th']['th' . $member['townhallLevel']] ?>" width="70px" alt="">
    </a>
    <span class='text-danger' data-toggle='tooltip' title='Ataques Disponibles'>
        <div style="position: absolute;bottom: 20%;right:0px;left:0px;padding: 5px;">
            <span style="background-color: rgba(255, 255, 255, 0.678);border-radius: 5px;padding-left: 5px;padding-right:5px;">
                <?php for ($i = 0; $i < $attacks_T; $i++) : ?>
                    <i class="fab fa-qq" aria-hidden="true"></i>
                <?php endfor; ?>
            </span>
        </div>
    </span>
    <a href="./?view=showgamer&tag=<?= str_replace('#', '', $member['tag']) ?>" class="badge badge-secondary" target="_black" data-toggle="tooltip" title="Ver Perfil"><?= $member['mapPosition'] . '. ' . $member['name'] ?></a>
</center>