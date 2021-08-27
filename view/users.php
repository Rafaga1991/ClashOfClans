<?php
    $users = $user->getUsers();
    if (!Session::Admin()) {
        if(!Session::superAdmin()){
            reloadPage();
        }
    }
?>

<div class="container-fluid mt-2">
    <div class="card">
        <div class="card-header">Usuarios</div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table align-items-center table-flush">
                    <thead class="thead-light text-center">
                        <tr>
                            <th scope="col" class="sort" data-sort="name">Nombre</th>
                            <th scope="col" class="sort" data-sort="name">Usuario</th>
                            <th scope="col" class="sort" data-sort="name">Correo Electr&oacute;nico</th>
                            <th scope="col" class="sort">Administrador</th>
                            <th scope="col" class="sort">Acceso</th>
                        </tr>
                    </thead>
                    <tbody class="list">
                        <?php foreach ($users as $key => $data) : ?>
                            <tr>
                                <td>
                                    <a href="./?view=profile&id=<?= md5($key) ?>" class="badge badge-info">
                                        <img src="<?= $img['profile'][$data['imageUrl']] ?>" width="25px" alt=""> <?= $data['nameUser'] . ' ' . $data['lastName'] ?>
                                    </a>
                                </td>
                                <td><?= $data['username'] ?></td>
                                <td>
                                    <a href="#"><?= $data['email'] ?></a>
                                </td>
                                <td>
                                    <center>
                                        <?php if (($data['username'] != Session::getUsername()) && (!$data['privileges'] || Session::superAdmin())) : ?>
                                            <input type="checkbox" userId="<?= md5($key) ?>" onclick="onClickAdmin(this)" data-toggle="tooltip" title="Hacer Administrador" <?= $data['privileges'] ? 'checked' : '' ?>>
                                        <?php else : ?>
                                            <i class="fas fa-check-circle"></i>
                                        <?php endif; ?>
                                    </center>
                                </td>
                                <td>
                                    <center>
                                        <?php if (($data['username'] != Session::getUsername()) && (!$data['privileges'] || Session::superAdmin())) : ?>
                                            <input type="checkbox" userId="<?= md5($key) ?>" onclick="onClickActive(this)" data-toggle="tooltip" title="Dar / Quitar Acceso" <?= $data['active'] ? 'checked' : '' ?>>
                                        <?php else : ?>
                                            <i class="far fa-check-circle"></i>
                                        <?php endif; ?>
                                    </center>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="card-footer"></div>
    </div>
</div>

<script>
    function onClickAdmin(element) {
        var userid = $(element).attr('userId');
        $.post(
            '<?= $request['post']['user'] ?>', {
                update: {
                    id: userid,
                    action: "admin"
                }
            }
        )
    }

    function onClickActive(element) {
        var userid = $(element).attr('userId');
        $.post(
            '<?= $request['post']['user'] ?>', {
                update: {
                    id: userid,
                    action: "active"
                }
            }, (data) => {
                console.log(data);
            }
        )
    }
</script>