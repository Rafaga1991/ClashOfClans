<?php
if (isset($_POST['username'])) {
    $data = $user->gTocken($_POST['username']);
    if (!$user->isUser($_POST['username'])) {
        unset($_POST['username']);
        $message = 'Correo no válido.';
    }
} elseif (isset($_GET['tocken'])) {
    $valid = $user->isTocken($_GET['tocken']);
    if (isset($_POST['password']) && isset($_POST['rpassword'])) {
        if ($_POST['password'] == $_POST['rpassword']) {
            $user->changePass($_GET['tocken'], $_POST['password']);
            $change = true;
        } else {
            $message = 'Las claves no coinciden';
        }
    }
}
?>

<div class="main-content">
    <!-- Header -->
    <div class="header bg-gradient-primary py-7 py-lg-8 pt-lg-0 opacity-7">
        <div class="container">
            <div class="header-body text-center mb-3">
                <div class="row justify-content-center">
                    <div class="col-xl-5 col-lg-6 col-md-8 px-0">
                        <h1 class="text-white">Cambiar Contrase&nacute;a</h1>
                        <p class="text-lead text-white"><?= $info['description'] ?></p>
                    </div>
                </div>
            </div>
        </div>

        <div class="separator separator-bottom separator-skew zindex-100">
            <svg x="0" y="0" viewBox="0 0 2560 100" preserveAspectRatio="none" version="1.1" xmlns="http://www.w3.org/2000/svg">
                <polygon class="fill-default" points="2560 0 2560 100 0 100"></polygon>
            </svg>
        </div>
    </div>

    <!-- Page content -->
    <div class="container mt--8 pb-5">
        <div class="row justify-content-center">
            <div class="col-lg-5 col-md-7">
                <div class="card bg-secondary border-0 mb-0">
                    <div class="card-header bg-transparent pb-3">
                        <div class="text-muted text-center mt-2 mb-3"><img src="<?= $info['badgeUrls']['small'] ?>" alt=""></div>
                        <div class="btn-wrapper text-center"><?= $info['name'] ?></div>
                    </div>
                    <div class="card-body px-lg-5 py-lg-2">
                        <?php if (!isset($valid)) : ?>
                            <?php if (!isset($_POST['username'])) : ?>
                                <form action="./?view=<?= $view ?>" method="post" role="form">
                                    <label for="">Recuperar Contrase&nacute;a</label>
                                    <div class="form-group mb-3">
                                        <div class="input-group input-group-merge input-group-alternative">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="ni ni-email-83"></i></span>
                                            </div>
                                            <input class="form-control" placeholder="Correo Electrónico" name="username" type="email" required minlength="6">
                                        </div>
                                    </div>
                                    <?php if (isset($message)) : ?>
                                        <label class="text-danger"><?= $message ?></label>
                                    <?php endif; ?>
                                    <div class="text-center">
                                        <button type="submit" class="btn btn-primary my-4">Enviar</button>
                                    </div>
                                </form>
                            <?php else : ?>
                                <script>
                                    window.onload = () => {
                                        $.post(
                                            '<?= urlMail ?>', {
                                                title: "Cambio de Clave",
                                                name: '<?= $_POST['name']?>',
                                                usermail: '<?= $_POST['username'] ?>',
                                                text: '<?='<div><img src="' . $info['badgeUrls']['small'] . '" alt=""><p>Accede al siguiente enlace para cambiar tu clave.</p><p>Enlace: <a href="' . url . '&tocken=' . $data['tocken'] . '">Cambiar Clave</a></p></div>'?>'
                                            }
                                        )
                                    }
                                </script>
                                <center>
                                    <label class="alert alert-success">Correo de Validaci&oacute;n Enviado!</label>
                                </center>
                            <?php endif; ?>
                        <?php else : ?>
                            <?php if ($valid) : ?>
                                <?php if (!isset($change)) : ?>
                                    <form method="post">
                                        <label for="">Ingresa la nueva contraseña</label>
                                        <div class="form-group mb-3">
                                            <div class="input-group input-group-merge input-group-alternative">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text"><i class="ni ni-lock-circle-open"></i></span>
                                                </div>
                                                <input class="form-control" placeholder="Contraseña" name="password" type="password" required minlength="6">
                                            </div>
                                        </div>
                                        <div class="form-group mb-3">
                                            <div class="input-group input-group-merge input-group-alternative">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text"><i class="ni ni-lock-circle-open"></i></span>
                                                </div>
                                                <input class="form-control" placeholder="Repetir Contraseña" name="rpassword" type="password" required minlength="6">
                                            </div>
                                        </div>
                                        <?php if (isset($message)) : ?>
                                            <label class="text-danger"><?= $message ?></label>
                                        <?php endif; ?>
                                        <div class="text-center">
                                            <button type="submit" class="btn btn-primary my-4">Cambiar</button>
                                        </div>
                                    </form>
                                <?php else : ?>
                                    <center>
                                        <label class="alert alert-success">Contrase&nacute;a Actualizada Con Exito!</label>
                                    </center>
                                <?php endif; ?>
                            <?php else : ?>
                                <center>
                                    <label class="alert alert-danger">Tocken expirado o no valido</label>
                                </center>
                            <?php endif; ?>
                        <?php endif; ?>
                    </div>
                </div>
                <div class="row mt-3">
                    <div class="col-6">
                        <a href="./?view=login" class="text-light"><small>Iniciar Sesi&oacute;n</small></a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>