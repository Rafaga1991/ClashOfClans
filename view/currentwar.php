<?php if ($currentWar['state'] != 'notInWar') : ?>
    <div class="container-fluid mt-6">
        <?php include $views['__currentwar']; ?>
    </div>
    <audio autoplay loop>
        <source src="<?= $sound['warSound'] ?>" type="audio/mp3">
    </audio>
<?php elseif (count($currentWarLeagueGroup) > 1) : ?>
    <audio autoplay loop>
        <source src="<?= $sound['warSound'] ?>" type="audio/mp3">
    </audio>
    <br></br><br><br>
    <h1 class="text-muted">LIGA DE GUERRA DE CLANES</h1>
    <div class="nav-wrapper">
        <ul class="nav nav-pills nav-fill flex-column flex-md-row" id="tabs-icons-text" role="tablist">
            <?php foreach ($currentWarLeagueGroup['rounds'] as $key => $round) : ?>
                <li class="nav-item">
                    <a class="nav-link mb-sm-3 mb-md-0" id="wars-<?= md5($key) ?>-war" data-toggle="tab" href="#wars-<?= $key ?>" role="tab" aria-selected="true">
                        Guerra <?= $key + 1 ?>
                    </a>
                </li>
            <?php endforeach; ?>
        </ul>
    </div>
    <div class="tab-content" id="myTabContent">
        <hr class="dropdown-divider">
        <h1 class="text-muted">Guerras Actuales</h1>
        <hr class="dropdown-divider">
        <?php $keyInwar = 0;?>
        <?php foreach ($currentWarLeagueGroup['rounds'] as $key => $round) : ?>
            <?php $data = []; ?>
            <div class="tab-pane fade" id="wars-<?= $key ?>" role="tabpanel">
                <!-- Inicio -->
                <div class="nav-wrapper">
                    <ul class="nav nav-pills nav-fill flex-column flex-md-row" id="tabs-icons-text-<?= $key ?>" role="tablist">
                        <?php foreach ($round['warTags'] as $keyWarTags => $warTags) : ?>
                            <?php
                            if ($warTags != '#0') {
                                $data[$keyWarTags] = $client->getClan()->getCurrentWarLeague($warTags);
                                if ($data[$keyWarTags]['state'] == 'inWar') {
                                    $keyInwar = $key;
                                } elseif (($key + 1) == count($currentWarLeagueGroup['rounds']) && $data[$keyWarTags]['state'] != 'preparation') {
                                    $keyInwar = $key;
                                }
                            } else {
                                break;
                            }
                            ?>
                            <li class="nav-item">
                                <a class="nav-link mb-sm-3 mb-md-0<?= ($keyWarTags == 0) ? ' active' : '' ?>" id="wars-<?= md5($keyWarTags) ?>-vs-<?= $key ?>" data-toggle="tab" href="#vs-<?= $keyWarTags ?>-<?= $key ?>" role="tab" aria-controls="vs-<?= $keyWarTags ?>-<?= $key ?>" aria-selected="true">
                                    <img src="<?= $data[$keyWarTags]['clan']['badgeUrls']['small'] ?>" width="25px" alt=""> <?= $data[$keyWarTags]['clan']['name'] ?>
                                    <br>VS <br>
                                    <img src="<?= $data[$keyWarTags]['opponent']['badgeUrls']['small'] ?>" width="25px" alt=""> <?= $data[$keyWarTags]['opponent']['name'] ?>
                                </a>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                </div>
                <div class="tab-content" id="myTabContent">
                    <?php foreach ($data as $keyData => $currentWar) : ?>
                        <div class="tab-pane fade<?= ($keyData == 0) ? ' show active' : '' ?>" id="vs-<?= $keyData ?>-<?= $key ?>" role="tabpanel">
                            <?php include $views['__currentwar'] ?>
                        </div>
                    <?php endforeach; ?>
                </div>
                <!-- fin -->
            </div>
        <?php endforeach; ?>
    </div>
    <hr class="dropdown-divider">
    <h1 class="text-muted">Clanes En La Guerra</h1>
    <hr class="dropdown-divider">
    <div class="nav-wrapper">
        <ul class="nav nav-pills nav-fill flex-column flex-md-row" id="tabs-icons-text" role="tablist">
            <?php foreach ($currentWarLeagueGroup['clans'] as $key => $clan) : ?>
                <li class="nav-item">
                    <a class="nav-link mb-sm-3 mb-md-0<?= ($key == 0) ? ' active' : '' ?>" id="tabs-<?= md5($key) ?>-tab" data-toggle="tab" href="#tab-<?= md5($clan['name']) ?>" role="tab" aria-controls="tab-<?= md5($clan['name']) ?>" aria-selected="true">
                        <img src="<?= $clan['badgeUrls']['small'] ?>" width="25px" alt=""><?= $clan['name'] ?>
                    </a>
                </li>
            <?php endforeach; ?>
        </ul>
    </div>
    <div class="card shadow">
        <div class="card-body">
            <div class="tab-content" id="myTabContent">
                <h1 class="text-muted">Miembros</h1>
                <hr class="dropdown-divider">
                <?php foreach ($currentWarLeagueGroup['clans'] as $key => $clan) : ?>
                    <div class="tab-pane fade<?= ($key == 0) ? ' show active' : '' ?>" id="tab-<?= md5($clan['name']) ?>" role="tabpanel" aria-labelledby="tabs-<?= md5($key) ?>-tab">
                        <?php foreach ($clan['members'] as $member) : ?>
                            <a href="./?view=showgamer&tag=<?= str_replace('#', '', $member['tag']) ?>" data-toggle="tooltip" data-html="true" title="Ver Jugador <br>Nivel <?= $member['townHallLevel'] ?>" target="_blanck">
                                <img src="<?= $img['th']['th' . $member['townHallLevel']] ?>" width="25" alt=""> <?= $member['name'] ?>
                            </a>
                            <hr class="dropdown-divider">
                        <?php endforeach; ?>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
    <br><br><br><br>
    <script>
        function currentwar(){
            var showTab = $('#wars-<?= $keyInwar ?>')[0];
            var tab = $('#wars-<?= md5($keyInwar) ?>-war')[0];
            tab.className += ' active';
            showTab.className += ' show active';
        }
    </script>
<?php else : ?>
    <style>
        body {
            background-image: url(data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABoAAAAaCAYAAACpSkzOAAAABHNCSVQICAgIfAhkiAAAAAlwSFlzAAALEgAACxIB0t1+/AAAABZ0RVh0Q3JlYXRpb24gVGltZQAxMC8yOS8xMiKqq3kAAAAcdEVYdFNvZnR3YXJlAEFkb2JlIEZpcmV3b3JrcyBDUzVxteM2AAABHklEQVRIib2Vyw6EIAxFW5idr///Qx9sfG3pLEyJ3tAwi5EmBqRo7vHawiEEERHS6x7MTMxMVv6+z3tPMUYSkfTM/R0fEaG2bbMv+Gc4nZzn+dN4HAcREa3r+hi3bcuu68jLskhVIlW073tWaYlQ9+F9IpqmSfq+fwskhdO/AwmUTJXrOuaRQNeRkOd5lq7rXmS5InmERKoER/QMvUAPlZDHcZRhGN4CSeGY+aHMqgcks5RrHv/eeh455x5KrMq2yHQdibDO6ncG/KZWL7M8xDyS1/MIO0NJqdULLS81X6/X6aR0nqBSJcPeZnlZrzN477NKURn2Nus8sjzmEII0TfMiyxUuxphVWjpJkbx0btUnshRihVv70Bv8ItXq6Asoi/ZiCbU6YgAAAABJRU5ErkJggg==);
        }

        .error-template {
            padding: 40px 15px;
            text-align: center;
        }

        .error-actions {
            margin-top: 15px;
            margin-bottom: 15px;
        }

        .error-actions .btn {
            margin-right: 10px;
        }
    </style>
    <br><br>
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="error-template">
                    <h1>
                        Buscando / Esperando</h1>
                    <h2>
                        En Espera...</h2>
                    <div class="error-details">
                        Buscando o Esperando el Inicio de una Guerra
                    </div>
                    <div class="error-actions">
                        <h1>
                            <i class="fas fa-search text-blue"></i>
                        </h1>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php endif; ?>