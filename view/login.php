<?php
  if(isset($_POST['username']) && isset($_POST['password'])){
    if(!$user->isAccess($_POST['username'], $_POST['password'])){
      $message = "Usuario y/o clave inválido";
    }else{
      $activity->setActivity([
        "title" => "Inicio de Sesión",
        "description" => "{$_POST['username']} a iniciado sesión.",
        "action" => "login"
      ]);
      reloadPage($view);
    }
  }
?>

<!-- Main content -->
<div class="main-content">
  <!-- Header -->
  <div class="header bg-gradient-primary py-7 py-lg-8 pt-lg-0 opacity-7">
    <div class="container">
      <div class="header-body text-center mb-3">
        <div class="row justify-content-center">
          <div class="col-xl-5 col-lg-6 col-md-8 px-0">
            <h1 class="text-white">Iniciar Sesión</h1>
            <p class="text-lead text-white"><?=$info['description']?></p>
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
          <div class="card-header bg-transparent pb-5">
            <div class="text-muted text-center mt-2 mb-3"><img src="<?=$info['badgeUrls']['small']?>" alt=""></div>
            <div class="btn-wrapper text-center"><?=$info['name']?></div>
          </div>
          <div class="card-body px-lg-5 ">
            <form action="./?view=<?=$view?>" method="post" role="form">
              <div class="form-group mb-3">
                <div class="input-group input-group-merge input-group-alternative">
                  <div class="input-group-prepend">
                    <span class="input-group-text"><i class="ni ni-email-83"></i></span>
                  </div>
                  <input class="form-control" placeholder="Correo o Nombre de Usuario" name="username" type="text" required>
                </div>
              </div>
              <div class="form-group">
                <div class="input-group input-group-merge input-group-alternative">
                  <div class="input-group-prepend">
                    <span class="input-group-text"><i class="ni ni-lock-circle-open"></i></span>
                  </div>
                  <input class="form-control" placeholder="Contraseña" name="password" type="password" required>
                </div>
              </div>
              <div class="custom-control custom-control-alternative custom-checkbox">
                <?php if(isset($message)):?>
                  <label class="custom-control-label" for=" customCheckLogin">
                    <span class="text-red"><?=$message?></span>
                  </label>
                <?php endif;?>
              </div>
              <div class="text-center">
                <button type="submit" class="btn btn-primary my-4">Acceder</button>
              </div>
            </form>

          </div>
        </div>
        <div class="row mt-3">
          <div class="col-6">
            <a href="./?view=changepass" class="text-light"><small>¿Olvidaste tu Contraseña?</small></a>
          </div>
          <div class="col-6 text-right">
            <a href="./?view=register" class="text-light"><small>Crear Nueva Cuenta</small></a>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>