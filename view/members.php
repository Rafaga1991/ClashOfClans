<?php
$members = $info['memberList'];

$membersOut = json_decode(file_get_contents($json['members'][$fileNameMembers_out]));

$cantMembers = count($members);
$options = $cantMembers / 5;
$limit = isset($_GET['limit']) ? explode('_', $_GET['limit']) : [0, 5];
foreach ($members as $key => $member) {
    if ($key >= $limit[0] && $key < $limit[1]) {
        $member['level'] = $client->getPlayer($member['tag'])->getPlayerInfo()['townHallLevel'];
        $members[$key] = $member;
    } else {
        unset($members[$key]);
    }
}
//var_dump($members);

$next = (($limit[1] < $cantMembers) ? $limit[0] + 5 : $limit[0]) . '_' . (($limit[1] < $cantMembers) ? $limit[1] + 5 : $limit[1]);
$back = (($limit[1] < $cantMembers) ? $limit[0] - 5 : $limit[0]) . '_' . (($limit[1] < $cantMembers) ? $limit[1] - 5 : $limit[1]);
?>

<div class="container-fluid mt-7">
    <div class="row">
        <div class="col">
            <div class="card">
                <!-- Card header -->
                <div class="card-header border-0">
                    <h3 class="mb-0">Miembros del Clan</h3>
                </div>
                <!-- Light table -->
                <div class="table-responsive">
                    <table class="table align-items-center table-flush">
                        <thead class="thead-light">
                            <tr>
                                <th scope="col" class="sort" data-sort="name">Jugador</th>
                                <th scope="col" class="sort" data-sort="budget">Rol</th>
                                <th scope="col" class="sort" data-sort="status">Copas</th>
                                <th scope="col">Ayuntamiento</th>
                                <th scope="col" class="sort" data-sort="completion">Equilibrio en donaciones</th>
                            </tr>
                        </thead>
                        <tbody class="list">
                            <?php foreach ($members as $member) : ?>
                                <?php $param = str_replace('#', '', $member['tag']); ?>
                                <tr>
                                    <th scope="row">
                                        <div class="media align-items-center">
                                            <a href="./?view=showgamer&tag=<?= $param ?>" class="avatar rounded-circle mr-3" data-toggle="tooltip" title="<?= $member['league']['name'] ?>">
                                                <img alt="Image placeholder" src="<?= $member['league']['iconUrls']['small'] ?>">
                                            </a>
                                            <div class="media-body">
                                                <span class="name mb-0 text-sm"><?= $member['name'] ?></span>
                                            </div>
                                        </div>
                                    </th>
                                    <td class="budget">
                                        <?= getTraslation($member['role']) ?>
                                    </td>
                                    <td>
                                        <i class="fas fa-trophy"></i> <?= $member['trophies'] ?>
                                    </td>
                                    <td>
                                        <div class="avatar-group">
                                            <a href="./?view=showgamer&tag=<?= $param ?>" class="avatar avatar-mt rounded-circle" data-toggle="tooltip" data-original-title="Nivel <?= $member['level'] ?>">
                                                <img alt="" src="<?= $img['th']['th' . $member['level']] ?>">
                                            </a>
                                        </div>
                                    </td>
                                    <td>
                                        <?php
                                        $onepercent = $member['donations'] / 100;
                                        if ($onepercent > 0) {
                                            $percentTotal = $member['donationsReceived'] / $onepercent;
                                            $percentTotal = ($percentTotal > 1) ? round($percentTotal, 1) : 100;
                                            $percentTotal = 100 - $percentTotal;
                                            $percentTotal = ($percentTotal > 0) ? $percentTotal : 0;
                                            $percentTotal = ($member['donationsReceived'] == 0) ? 100 : $percentTotal;
                                        } else {
                                            $percentTotal = 0;
                                        }

                                        if ($percentTotal >= 80) {
                                            $color = 'success';
                                        } elseif ($percentTotal >= 60) {
                                            $color = 'info';
                                        } elseif ($percentTotal >= 40) {
                                            $color = 'warning';
                                        } else {
                                            $color = 'danger';
                                        }
                                        ?>
                                        <div class="d-flex align-items-center" data-toggle="tooltip" data-html="true" title="<?php include $tooltip['donation'] ?>">
                                            <span class="completion mr-2"><?= $percentTotal ?>%</span>
                                            <div>
                                                <div class="progress">
                                                    <div class="progress-bar bg-<?= $color ?>" role="progressbar" aria-valuenow="<?= $percentTotal ?>" aria-valuemin="0" aria-valuemax="100" style="width: <?= $percentTotal ?>%;"></div>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
                <!-- Card footer -->
                <div class="card-footer py-4" style="overflow-x: scroll;">
                    <nav aria-label="...">
                        <ul class="pagination">
                            <li class="page-item <?= ($back == '-5_0') ? 'disabled' : '' ?>">
                                <a class="page-link" href="./?view=<?= $view ?>&limit=<?= $back ?>" tabindex="-1">
                                    <i class="fas fa-angle-left"></i>
                                    <span class="sr-only">Previous</span>
                                </a>
                            </li>
                            <?PHP for ($i = 0; $i < $options; $i++) : ?>
                                <?php
                                $val = ((($i + 1) * 5) - 5 . '_' . ($i + 1) * 5);
                                ?>
                                <li class="page-item <?= ($val == ($limit[0] . '_' . $limit[1])) ? 'active' : '' ?>">
                                    <a class="page-link" href="./?view=<?= $view ?>&limit=<?= $val ?>"><?= $i + 1 ?></a>
                                </li>
                            <?php endfor; ?>
                            <li class="page-item <?= ($next == ($limit[0] . '_' . $limit[1])) ? 'disabled' : '' ?>">
                                <a class="page-link" href="./?view=<?= $view ?>&limit=<?= $next ?>">
                                    <i class="fas fa-angle-right"></i>
                                    <span class="sr-only">Next</span>
                                </a>
                            </li>
                        </ul>
                    </nav>
                </div>
            </div>
        </div>
    </div>
    <div class="card">
        <div class="card-header">
            <h3 class="text-muted">Expulsados o Fuera del Clan (<?= count($membersOut) ?>)</h3>
        </div>
        <div class="card-body table-responsive">
            <table class="table" id="membersOut">
                <thead>
                    <tr>
                        <th>Nombre</th>
                        <th>Cant.</th>
                        <th>Fecha</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($membersOut as $memberOut) : ?>
                        <tr>
                            <td><a href="./?view=showgamer&tag=<?= str_replace('#', '', $memberOut->tag) ?>"><?= $memberOut->name ?></a></td>
                            <td><?= $memberOut->cant_out ?></td>
                            <td><?= $memberOut->date ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
    <br>
</div>