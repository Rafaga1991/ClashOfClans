<?php
$cantFile = $publication->getCantFileByUser($_GET['id']);
?>
<br><br><br><br>
<div class="row">
    <div class="col-xl-4 order-xl-2">
        <div class="card card-profile">
            <img src="<?= $img['theme']['clashofclans'] ?>" alt="Image placeholder" class="card-img-top">
            <div class="row justify-content-center">
                <div class="col-lg-3 order-lg-2">
                    <div class="card-profile-image">
                        <label for="fileLoad">
                            <span>
                                <img src="<?= $img['profile'][$userData['imageUrl']] ?>">
                            </span>
                        </label>
                    </div>
                </div>
            </div>
            <div class="card-header text-center border-0 pt-8 pt-md-4 pb-0 pb-md-4">
                <div class="d-flex justify-content-between">
                    <a href="./?view=<?= $view ?>&id=<?= $_GET['id'] ?>&publication=video" class="btn btn-sm btn-default float-right">Videos</a>
                    <?php if (Session::getUsername() == $userData['username']) : ?>
                        <a href="./?view=<?= $view ?>&id=<?= $_GET['id'] ?><?= (isset($_GET['publication']) ? '' : '&publication') ?>" class="btn btn-sm btn-info  mr-4"><?= (isset($_GET['publication']) ? 'Perfil' : 'Publicaciones') ?></a>
                    <?php endif; ?>
                    <a href="./?view=<?= $view ?>&id=<?= $_GET['id'] ?>&publication=image" class="btn btn-sm btn-default float-right">Fotos</a>
                </div>
            </div>
            <div class="card-body pt-0">
                <div class="row">
                    <div class="col">
                        <div class="card-profile-stats d-flex justify-content-center">
                            <div>
                                <span class="heading"><?= $cantFile['video'] ?></span>
                                <span class="description">Videos</span>
                            </div>
                            <div>
                                <br>
                                <span class="description"><?= $userData['username'] ?></span>
                            </div>
                            <div>
                                <span class="heading"><?= $cantFile['image'] ?></span>
                                <span class="description">Fotos</span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="text-center">
                    <h5 class="h3">
                        <?= $userData['nameUser'] . ' ' . $userData['lastName'] ?>
                    </h5>
                    <div class="h5 font-weight-300">
                        <i class="ni location_pin mr-2"></i><span id="countryName"></span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php if (Session::getUsername() == $userData['username'] && !isset($_GET['publication'])) : ?>
        <div class="col-xl-8 order-xl-1">
            <form method="post" enctype="multipart/form-data">
                <input type="hidden" name="img_old" value="<?= $userData['imageUrl'] ?>">
                <div class="card">
                    <div class="card-header">
                        <div class="row align-items-center">
                            <div class="col-8">
                                <h3 class="mb-0">Editar Perfil </h3>
                            </div>
                            <div class="col-4 text-right">
                                <button class="btn btn-sm btn-primary">Guardar Cambios</button>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <?php if (isset($message)) : ?>
                            <label class="alert alert-danger"><?= $message ?></label>
                        <?php endif; ?>
                        <h6 class="heading-small text-muted mb-4">Informaci&oacute;n de Usuario</h6>
                        <div class="pl-lg-4">
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label class="form-control-label" for="input-username">Nombre de Usuario </label>
                                        <input type="text" id="input-username" name="username" class="form-control" placeholder="Nombre de Usuario">
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label class="form-control-label" for="input-email">Correo Eletr&oacute;nico <span class="text-danger" data-toggle="tooltip" title="campo obligatorio">*</span></label>
                                        <input type="email" id="input-email" name="mail" class="form-control" placeholder="Correo Electrónico" value="<?= $userData['email'] ?>" required>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label class="form-control-label" for="input-first-name">Nombre <span class="text-danger" data-toggle="tooltip" title="campo obligatorio">*</span></label>
                                        <input type="text" id="input-first-name" name="name" class="form-control" placeholder="Nombre" value="<?= $userData['nameUser'] ?>" required>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label class="form-control-label" for="input-last-name">Apellido <span class="text-danger" data-toggle="tooltip" title="campo obligatorio">*</span></label>
                                        <input type="text" id="input-last-name" name="lastname" class="form-control" placeholder="Apellido" value="<?= $userData['lastName'] ?>" required>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label class="form-control-label" for="input-first-name">Contraseña</label>
                                        <input type="text" id="input-first-name" name="password" class="form-control" placeholder="contraseña">
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label class="form-control-label" for="input-last-name">Repetir Contraseña</label>
                                        <input type="text" id="input-last-name" name="rpassword" class="form-control" placeholder="contraseña">
                                    </div>
                                </div>
                            </div>
                            <input type="file" id="fileLoad" name="image" accept="image/png, .jpeg, .jpg, image/gif" style="visibility: hidden;">
                        </div>
                    </div>
                </div>
            </form>
        </div>
    <?php else : ?>
        <div class="col-xl-8 order-xl-1">
            <?php include $views['__publication'] ?>
        </div>
    <?php endif; ?>
</div>

<script>
    window.onload = () => {
        $.get(
            'https://clanhechiceros.000webhostapp.com', {
                ip: '<?= $userData['ip'] ?>'
            }, (data) => {
                data = JSON.parse(data);
                $('#countryName')[0].innerHTML = data.country_name;
            }
        )
    }
</script>