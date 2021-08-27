<?php
$dirName = './json/listbreak';
$fileName = "$dirName/listbreak_" . str_replace('#', '', Session::getClanTag()) . '.json';

if (!is_dir($dirName)) {
    mkdir($dirName);
}

if (!file_exists($fileName)) {
    file_put_contents($fileName, '[]');
}

$listbreak = json_decode(file_get_contents($fileName), true);

if (isset($_POST['list'])) {
    if (count($_POST['list']) > 0) {
        foreach ($_POST['list'] as $memberTag) {
            foreach ($info['memberList'] as $member) {
                if ($member['tag'] == $memberTag) {
                    array_push(
                        $listbreak,
                        [
                            'tag' => $memberTag,
                            'name' => $member['name'],
                            'image' => $member['league']['iconUrls'],
                            'date' => time()
                        ]
                    );
                    break;
                }
            }
        }
        file_put_contents($fileName, json_encode($listbreak));
    }
} elseif (isset($_GET['delete'])) {
    if (Session::isPrivilegedInClan()) {
        $acum = [];
        if (strtolower($_GET['delete']) == 'all') {
            file_put_contents($fileName, json_encode($acum));
            $listbreak = $acum;
        } else {
            foreach ($listbreak as $index => $member) {
                if ($member['tag'] != ('#' . $_GET['delete'])) {
                    array_push($acum, $member);
                }
            }
            file_put_contents($fileName, json_encode($acum));
        }
    }
    reloadPage($view);
}

?>

<script src="./js/listwait.js"></script>
<div class="container-fluid mt-7">
    <h1 class="text-muted">Lista De Descanso</h1>
    <div class="card">
        <div class="card-header">
            <div class="row">
                <div class="col">
                    <h2 class="text-muted">Miembros en Descanso (<?=count($listbreak)?>) <i class="fas fa-hourglass-half"></i></h2>
                </div>
                <div class="col text-right">
                    <?php if (Session::isPrivilegedInClan()) : ?>
                        <a href="./?view=<?= $view ?>&delete=all" class="btn btn-danger">Borrar Todo</a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
        <div class="card-body">
            <?php if(count($listbreak) == 0):?>
                <div class="text-center">Actualmente no hay miembros en descanso.</div>
            <?php endif;?>
            <?php foreach ($listbreak as $index => $member) : ?>
                <div class="row">
                    <div class="col">
                        <?= $index + 1 ?>. <img src="<?= $member['image']['small'] ?>" alt=""> <?= $member['name'] ?>
                    </div>
                    <div class="col">
                        <?=date('h:i A | M d', $member['date'])?>
                    </div>
                    <div class="col">
                        <a href="./?view=showgamer&tag=<?= str_replace('#', '', $member['tag']) ?>" class="btn btn-info">Perfil</a>
                        <?php if (Session::isPrivilegedInClan()) : ?>
                            <a href="./?view=<?= $view ?>&delete=<?= str_replace('#', '', $member['tag']) ?>" class="btn btn-danger">Eliminar</a>
                        <?php endif; ?>
                    </div>
                </div>
                <hr class="dropdown-divider">
            <?php endforeach; ?>
        </div>
        <div class="card-footer">
            <?php if (Session::isPrivilegedInClan()) : ?>
                <a href="#" data-toggle='modal' data-target='#newMemberTolistbreak' class="btn btn-primary">Nuevo Miembro</a>
                <div class="modal fade" id="newMemberTolistbreak" tabindex="-1" role="dialog" aria-labelledby="modal-default" aria-hidden="true">
                    <div class="modal-dialog modal- modal-dialog-centered" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h6 class="modal-title" id="modal-title-default"><img src="<?= $info['badgeUrls']['small'] ?>" alt=""> Agregar a Lista de Descanso</h6>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">×</span>
                                </button>
                            </div>
                            <form action="" method="post">
                                <div class="modal-body">
                                    <table class="text-left" id="listMembers">
                                        <thead>
                                            <tr>
                                                <th>Miembros</th>
                                                <th>Copas</th>
                                                <th></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach ($info['memberList'] as $key => $member) : ?>
                                                <tr>
                                                    <td><img src="<?= $member['league']['iconUrls']['small'] ?>" width="40px" alt=""><?= $member['name'] ?></td>
                                                    <td><?= $member['trophies'] ?></td>
                                                    <td><input type="checkbox" onclick="onClickNewListWait(this, '<?= $member['tag'] ?>')"></td>
                                                </tr>
                                            <?php endforeach; ?>
                                        </tbody>
                                    </table>
                                </div>

                                <div class="modal-footer">
                                    <button type="submit" class="btn btn-primary">Agregar</button>
                                    <button type="button" class="btn btn-link  ml-auto" data-dismiss="modal">Cerrar</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>