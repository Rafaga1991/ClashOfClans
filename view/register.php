<?php
if (isset($_POST['name']) && isset($_POST['lastName']) && isset($_POST['username']) && isset($_POST['password']) && isset($_POST['rpassword'])) {
  if ($_POST['password'] == $_POST['rpassword']) {
    if (!$user->isUser($_POST['username'])) {
      $_POST['clanTag'] = ($_POST['clanTag'] == '') ? $info['tag'] : $_POST['clanTag'];
      $clan = $client->getClan($_POST['clanTag'])->getClanInfo();
      if (count($clan) > 1) {
        if (isMember($clan['memberList'], $_POST['playerTag'])) {
          if (!$option->existsTag($_POST['playerTag'])) {
            $code = '';
            for ($i = 0; $i < 6; $i++) {
              $code .= rand(0, 9);
            }
            foreach ($_POST as $key => $value) {
              $_POST[$key] = getPlaneText($value);
            }
            $_POST['tocken'] = md5($code);
            $user->addUser($_POST);
            $_GET['verification'] = '';
            $activity->setActivity([
              "title" => "Nuevo Usuario",
              "description" => "{$_POST['name']} {$_POST['lastName']} se a registrado.",
              "action" => "register"
            ]);
          } else {
            $message = 'El tag del jugador ingresado se encuentra registrado.';
          }
        } else {
          $message = 'No eres miembro de este clan.';
        }
      } else {
        $message = 'Tag del clan no valido.';
      }
    } else {
      $message = 'El nombre de usuario ' . $_POST['username'] . ' existe.';
    }
  } else {
    if (isset($_GET['verification'])) {
      unset($_GET['verification']);
    }
    $message = 'Las contraseñas no coinciden.';
  }
} elseif (isset($_GET['code'])) {
  $access = $user->verification($_GET['code']);
}
?>

<!-- Main content -->
<div class="main-content">
  <!-- Header -->
  <div class="header bg-gradient-primary py-7 py-lg-8 pt-lg-0">
    <div class="container">
      <div class="header-body text-center mb-3">
        <div class="row justify-content-center">
          <div class="col-xl-5 col-lg-6 col-md-8 px-0">
            <h1 class="text-white">Crear Cuenta</h1>
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
    <!-- Table -->
    <div class="row justify-content-center">
      <div class="col-lg-6 col-md-8">
        <div class="card bg-secondary border-0">
          <div class="card-body px-lg-5 py-lg-5">
            <?php if (!isset($_GET['verification'])) : ?>
              <div class="text-center text-muted mb-4">
                <div class="card-header bg-transparent pb-5">
                  <div class="text-muted text-center mt-2 mb-3"><img src="<?= $info['badgeUrls']['small'] ?>" alt=""></div>
                  <div class="btn-wrapper text-center"><?= $info['name'] ?></div>
                </div>
              </div>
              <form action="./?view=<?= $view ?>" role="form" method="post" class="form">
                <div class="form-group">
                  <div class="input-group input-group-merge input-group-alternative mb-3">
                    <div class="input-group-prepend">
                      <span class="input-group-text"><i class="ni ni-single-02"></i></span>
                    </div>
                    <input class="form-control" placeholder="Nombre" name="name" type="text" data-toggle="tooltip" title="Nombre" required>
                    <div class="input-group-prepend">
                      <span class="input-group-text"><i class="ni ni-single-02"></i></span>
                    </div>
                    <input class="form-control" placeholder="Apellido" name="lastName" data-toggle="tooltip" title="Apellido" type="text" required>
                  </div>
                </div>

                <div class="form-group">
                  <div class="input-group input-group-merge input-group-alternative mb-3">
                    <div class="input-group-prepend">
                      <span class="input-group-text"><i class="ni ni-email-83"></i></span>
                    </div>
                    <input class="form-control" placeholder="Correo" name="email" data-toggle="tooltip" title="Correo Electrónico" type="email" required>
                  </div>
                </div>

                <div class="form-group">
                  <div class="input-group input-group-merge input-group-alternative mb-3">
                    <div class="input-group-prepend">
                      <span class="input-group-text"><i class="ni ni-circle-08"></i></span>
                    </div>
                    <input class="form-control" placeholder="Nombre de Usuario" name="username" data-toggle="tooltip" title="Nombre de Usuario" type="text" required>
                  </div>
                </div>

                <div class="form-group">
                  <div class="input-group input-group-merge input-group-alternative">
                    <div class="input-group-prepend">
                      <span class="input-group-text"><i class="ni ni-tag"></i></span>
                    </div>
                    <input class="form-control" placeholder="tag del clan: #xxxx (Requerido)" name="clanTag" data-toggle="tooltip" title="Tag del Clan" type="text">

                    <div class="input-group-prepend" data-toggle="tooltip" title="Información">
                      <button type="button" class="btn btn-success bg-success" data-toggle="modal" data-target="#clanTag">
                        <i class="fas fa-info text-white"></i>
                      </button>
                      <!-- Modal Información de Tag del Clan -->
                      <div class="modal fade" id="clanTag" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
                        <div class="modal-dialog modal-lg" role="document">
                          <div class="modal-content">
                            <div class="modal-header">
                              <h5 class="modal-title" id="exampleModalLongTitle">Informaci&oacute;n</h5>
                              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                              </button>
                            </div>
                            <div class="modal-body">
                              <p>El tag o etiqueta del clan es un identificador unico que tiene cada clan. <br>
                                <hr class="drodown-divider">
                                Para copiar la etiqueta de tu clan debes ir a la informaci&oacute;n del clan,
                                luego presionas el boton de <strong>compartir</strong> y apareceran varias opciones,
                                preciona la opción de copiar y lo pegas en el campo <i>tag del clan</i>.
                              </p>
                              <img src="<?= $img['theme']['clanTagInfo'] ?>" style="width: 100%;" alt="">
                            </div>
                            <div class="modal-footer">
                              <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerra</button>
                            </div>
                          </div>
                        </div>
                      </div>
                      <!-- fin de modal -->
                    </div>
                  </div>
                </div>

                <div class="form-group">
                  <div class="input-group input-group-merge input-group-alternative">
                    <div class="input-group-prepend">
                      <span class="input-group-text"><i class="ni ni-tag"></i></span>
                    </div>
                    <input class="form-control" placeholder="tag del jugador: #xxxx (Requerido)" name="playerTag" data-toggle="tooltip" title="Tag del Clan" type="text" required>
                    <div class="input-group-prepend" data-toggle="tooltip" title="Información">
                      <button type="button" class="btn btn-success bg-success" data-toggle="modal" data-target="#playerTag">
                        <i class="fas fa-info text-white"></i>
                      </button>
                      <!-- Modal Información de Tag del Clan -->
                      <div class="modal fade" id="playerTag" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
                        <div class="modal-dialog modal-lg" role="document">
                          <div class="modal-content">
                            <div class="modal-header">
                              <h5 class="modal-title" id="exampleModalLongTitle">Informaci&oacute;n</h5>
                              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                              </button>
                            </div>
                            <div class="modal-body">
                              <p>El tag o etiqueta del jugador es un identificador unico que tiene cada jugador. <br>
                                <hr class="drodown-divider">
                                Para copiar tu etiqueta de jugador debes ir a la informaci&oacute;n del jugador,
                                luego presionas el boton de <strong>compartir</strong> y apareceran varias opciones,
                                preciona la opción de copiar y lo pegas en el campo <i>tag del jugador</i>.
                              </p>
                              <img src="<?= $img['theme']['playerTagInfo'] ?>" style="width: 100%;" alt="">
                            </div>
                            <div class="modal-footer">
                              <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerra</button>
                            </div>
                          </div>
                        </div>
                      </div>
                      <!-- fin de modal -->
                    </div>
                  </div>
                </div>

                <div class="form-group">
                  <div class="input-group input-group-merge input-group-alternative">
                    <div class="input-group-prepend">
                      <span class="input-group-text"><i class="ni ni-lock-circle-open"></i></span>
                    </div>
                    <input class="form-control" placeholder="Contraseña" name="password" data-toggle="tooltip" title="Contraseña" type="password" required>
                  </div>
                </div>

                <div class="form-group">
                  <div class="input-group input-group-merge input-group-alternative">
                    <div class="input-group-prepend">
                      <span class="input-group-text"><i class="ni ni-lock-circle-open"></i></span>
                    </div>
                    <input class="form-control" placeholder="Volver a Escribir la Contraseña" name="rpassword" data-toggle="tooltip" title="Repetir Contraseña" type="password" required>
                  </div>
                </div>
                <?php if (isset($message)) : ?>
                  <div class="text-muted font-italic"><span class="text-danger"><?= $message ?></span></div>
                <?php endif; ?>
                <div class="text-center">
                  <button class="btn btn-primary mt-4">Crear Cuenta</button>
                </div>
              </form>
            <?php else : ?>
              <?php if (isset($code)) : ?>
                <script>
                  window.onload = () => {
                    $.post(
                      '<?= urlMail ?>', {
                        title: "Nuevo Registro",
                        name: '<?= $_POST['name'] . ' ' . $_POST['lastName'] ?>',
                        usermail: '<?= $_POST['email'] ?>',
                        text: '<?= '<div><img src="' . $info['badgeUrls']['small'] . '" alt=""><p>Hola ' . $_POST['name'] . ', Verifica tu correo electr&oacute;nico para activar tu cuenta.</p><p>C&oacute;digo: ' . $code . '</p><p>Enlace de Verificaci&oacute;n: <a href="' . url . '&code=' . md5($code) . '">Verificar</a></p></div>' ?>'
                      }
                    )
                  }
                </script>
              <?php endif; ?>
              <span class="alert alert-success">Correo de Verificaci&oacute;n Enviado!</span><br><br>
              <h3>Ingresa el C&oacute;digo de Verificaci&oacute;n:</h3>
              <div class="form-group">
                <div class="input-group input-group-merge input-group-alternative">
                  <div class="input-group-prepend">
                    <span class="input-group-text"><i class="ni ni-lock-circle-open"></i></span>
                  </div>
                  <input class="form-control" id="verificationCode" placeholder="Código de Verificación" data-toggle="tooltip" title="Código de Verificación" type="text">
                </div>
                <button class="btn btn-primary mt-4" onclick="onClickVerication()">Verificar</button>
              </div>
              <h4 class="text-muted">Nota: revisa la carpeta de spam de tu correo.</h4>
            <?php endif; ?>
          </div>
        </div>

        <div class="row mt-3">
          <div class="col-6">
            <a href="./?view=login" class="text-light"><small>Iniciar Sesión</small></a>
          </div>
        </div>

      </div>
    </div>
  </div>
</div>

<script>
  function onClickVerication() {
    if ($('#verificationCode').val() !== '') {
      $.post(
        '<?= $request['post']['verification'] ?>', {
          codeVerification: $('#verificationCode').val()
        }, (data) => {
          data = JSON.parse(data);
          if (data.status) {
            Swal.fire(
              'Verificado',
              'Tu Cuenta se ha Activado!',
              'success'
            ).then(() => {
              location.href = "./?view=login";
            })
          } else {
            Swal.fire(
              'Error',
              'Código de verificación no valido.',
              'error'
            )
          }
        }
      )
    } else {
      Swal.fire(
        'Código de Verificación',
        'Ingresa el Código de Verificación.',
        'info'
      )
    }
  }
</script>

<?php if (isset($access)) : ?>
  <?php if ($access) : ?>
    <script>
      window.onload = () => {
        Swal.fire(
          'Verificado',
          'Tu Cuenta se ha Activado!',
          'success'
        ).then(() => {
          location.href = "./?view=login";
        })
      }
    </script>
  <?php else : ?>
    <script>
      window.onload = () => {
        Swal.fire(
          'Error',
          'Código de verificación no valido.',
          'error'
        )
      }
    </script>
  <?php endif; ?>
<?php endif; ?>