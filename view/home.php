<!DOCTYPE html>
<html>

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="Start your development with a Dashboard for Bootstrap 4.">
  <meta name="author" content="Creative Tim">
  <title><?= $info['name'] ?></title>
  <!-- Favicon -->
  <link rel="icon" href="<?= $info['badgeUrls']['small'] ?>" type="image/png">
  <!-- Fonts -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700">
  <!-- Icons -->
  <link rel="stylesheet" href="assets/vendor/nucleo/css/nucleo.css" type="text/css">
  <link rel="stylesheet" href="assets/vendor/@fortawesome/fontawesome-free/css/all.min.css" type="text/css">
  <!-- Page plugins -->
  <!-- Argon CSS -->
  <link rel="stylesheet" href="assets/css/argon.css?v=1.2.0" type="text/css">
  <link rel="stylesheet" href="https://cdn.datatables.net/1.10.25/css/jquery.dataTables.min.css">
  <link rel="stylesheet" href="./css/home.css">
</head>

<body class="<?= !Session::Auth() ? 'bg-default' : '' ?>">
  <?php if (Session::Auth()) : ?>
    <!-- Sidenav -->
    <nav class="sidenav navbar navbar-vertical  fixed-left  navbar-expand-xs navbar-light bg-white" id="sidenav-main">
      <?php include $views['sidenav']; ?>
    </nav>
    <!-- Main content -->
    <div class="main-content" id="panel">
      <!-- Topnav -->
      <nav class="navbar navbar-top navbar-expand navbar-dark border-bottom sticky-top" id="topMenu" style="background-color: <?= Session::getColorPage() ?>;">
        <div class="container-fluid">
          <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <!-- Search form -->
            <form action="./?view=search" method="post" class="navbar-search navbar-search-light form-inline mr-sm-3" id="navbar-search-main">
              <div class="form-group mb-0">
                <div class="input-group input-group-alternative input-group-merge">
                  <div class="input-group-prepend">
                    <span class="input-group-text"><i class="fas fa-search"></i></span>
                  </div>
                  <input class="form-control" placeholder="Buscar..." name="search" type="text">
                </div>
              </div>
              <button type="button" class="close" data-action="search-close" data-target="#navbar-search-main" aria-label="Close">
                <span aria-hidden="true">x</span>
              </button>
            </form>
            <!-- Navbar links -->
            <ul class="navbar-nav align-items-center  ml-md-auto ">
              <li class="nav-item d-xl-none">
                <!-- Sidenav toggler -->
                <div class="pr-3 sidenav-toggler sidenav-toggler-dark" data-action="sidenav-pin" data-target="#sidenav-main">
                  <div class="sidenav-toggler-inner">
                    <i class="sidenav-toggler-line"></i>
                    <i class="sidenav-toggler-line"></i>
                    <i class="sidenav-toggler-line"></i>
                  </div>
                </div>
              </li>
              <li class="nav-item d-sm-none">
                <a class="nav-link" href="#" data-action="search-show" data-target="#navbar-search-main">
                  <i class="ni ni-zoom-split-in"></i>
                </a>
              </li>
              <li class="nav-item dropdown">
                <a class="nav-link" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                  <div class="row">
                    <div class="col">
                      <i class="ni ni-bell-55"></i>
                      <?php if ($notifications['toSee'] > 0) : ?>
                        <div style="position: absolute;bottom: 0px;right: 2px;">
                          <span class="badge text-white" style="background-color: #DA1B0F;font-size: 8px;"><?= $notifications['toSee'] ?></span>
                        </div>
                      <?php endif; ?>
                    </div>
                  </div>
                </a>
                <div class="dropdown-menu dropdown-menu-xl dropdown-menu-right py-0 overflow-hidden">
                  <!-- Dropdown header -->
                  <div class="px-3 py-3">
                    <h6 class="text-sm text-muted m-0">Notificaciones</h6>
                  </div>
                  <!-- List group -->
                  <div class="list-group list-group-flush">
                    <?php foreach ($notifications['notifications'] as $notificationValue) : ?>
                      <a href="#" class="list-group-item list-group-item-action">
                        <div class="row align-items-center">
                          <div class="col-auto">
                            <!-- Avatar -->
                            <img alt="..." src="<?= $info['badgeUrls']['small'] ?>" class="avatar rounded-circle bg-white">
                          </div>
                          <div class="col ml--2">
                            <div class="d-flex justify-content-between align-items-center">
                              <div>
                                <h4 class="mb-0 text-sm"><?= $notificationValue['titleNotification'] ?></h4>
                              </div>
                              <div class="text-right text-muted">
                                <small><?= $notificationValue['dateNotification'] ?></small>
                              </div>
                            </div>
                            <p class="text-sm mb-0"><?= $notificationValue['descriptionNotification'] ?></p>
                          </div>
                        </div>
                      </a>
                    <?php endforeach; ?>
                  </div>
                  <!-- View all -->
                  <a href="./?view=notification" class="dropdown-item text-center text-primary font-weight-bold py-3">Ver Todas</a>
                </div>
              </li>
              <li class="nav-item dropdown">
                <?php include $views['dropdown']; ?>
              </li>
            </ul>
            <ul class="navbar-nav align-items-center  ml-auto ml-md-0 ">
              <li class="nav-item dropdown">
                <a class="nav-link pr-0" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                  <div class="media align-items-center">
                    <span class="avatar avatar-sm rounded-circle">
                      <img width="100%" height="100%" alt="<?= $img['profile']['default'] ?>" src="<?= $img['profile'][Session::getImage()] ?>">
                    </span>
                    <div class="media-body  ml-2  d-none d-lg-block">
                      <span class="mb-0 text-sm  font-weight-bold">
                        <?= strtoupper(Session::getUsername()) ?>
                        <h6 class="text-muted"><?= getTraslation(Session::getRole()) ?></h6>
                      </span>
                    </div>
                  </div>
                </a>
                <div class="dropdown-menu  dropdown-menu-right ">
                  <div class="dropdown-header noti-title">
                    <h6 class="text-overflow m-0">Bienvenid@!</h6>
                  </div>
                  <a href="./?view=profile&id=<?= md5(Session::getUserId()) ?>" class="dropdown-item">
                    <i class="ni ni-single-02"></i>
                    <span>Perfil</span>
                  </a>
                  <a href="./?view=options" class="dropdown-item">
                    <i class="ni ni-settings-gear-65"></i>
                    <span>Opciones</span>
                  </a>
                  <?php if (Session::superAdmin()) : ?>
                    <a href="./?view=activities" class="dropdown-item">
                      <i class="ni ni-calendar-grid-58"></i>
                      <span>Actividades</span>
                    </a>
                  <?php endif; ?>
                  <?php if (Session::superAdmin()) : ?>
                    <a href="./?view=database" class="dropdown-item">
                      <i class="fas fa-database"></i>
                      <span>Base de Datos</span>
                    </a>
                  <?php endif; ?>
                  <a href="./?view=info" class="dropdown-item">
                    <i class="fas fa-info"></i>
                    <span>Informaci&oacute;n</span>
                  </a>
                  <div class="dropdown-divider"></div>
                  <a href="<?= $request['get']['logout'] ?>" class="dropdown-item">
                    <i class="ni ni-button-power"></i>
                    <span>Cerrar Sesión</span>
                  </a>
                </div>
              </li>
            </ul>
          </div>
        </div>
      </nav>
      <!-- Header -->
      <?php if (!in_array($view, ['profile', 'activities', 'options', 'chats', 'info', 'database'])) : ?>
        <!-- Header -->
        <div class="header pb-6" style="min-height: 400px; background-image: url('<?= $img['theme']['coverpage'] ?>'); background-size: cover; background-position: center;">
          <!-- Mask -->
          <span class="mask opacity-6" style="background-color: <?= Session::getColorPage() ?>;"></span>
          <div class="container-fluid">
            <div class="header-body">
              <div class="row align-items-center py-4">
                <div class="col-lg-6 col-7">
                  <h6 class="h2 text-white d-inline-block mb-0">INFORMACIÓN DEL CLAN</h6>
                  <div class="row">
                    <div class="col">
                      <button onclick="copyText(this)" class="btn btn-white" data-toggle="tooltip" title="Etiqueta del Clan"><?= $info['tag'] ?></button>
                    </div>
                    <div class="col">
                      <h6 class="text-white">Etiquetas</h6>
                      <?php foreach ($info['labels'] as $label) : ?>
                        <img src="<?= $label['iconUrls']['small'] ?>" width="40px" data-toggle="tooltip" title="<?= getTraslation(strtolower(str_replace(' ', '', $label['name']))) ?>" alt="">
                      <?php endforeach; ?>
                    </div>
                    <div class="col">
                      <h5 class="text-white d-inline-block mb-0">Ubicación:</h5>
                      <h6 class="text-white"><?= $info['location']['name'] ?></h6>
                      <h5 class="text-white d-inline-block mb-0">Nivel de Clan:</h5>
                      <h6 class="text-white"><?= $info['clanLevel'] ?></h6>
                    </div>
                    <div class="col">
                      <h5 class="text-white d-inline-block mb-0">Puntos del Clan:</h5>
                      <h6 class="text-white"><?= $info['clanPoints'] ?></h6>
                      <h5 class="text-white d-inline-block mb-0">Liga:</h5>
                      <h6 class="text-white"><?= $info['warLeague']['name'] ?></h6>
                    </div>
                  </div>
                  <h6 class="h2 text-white d-inline-block mb-0">Reyes de las Donaciones</h6>
                </div>
                <div class="col">
                  <h5 class="text-white d-inline-block mb-0">Guerras:</h5>
                  <ul class="text-white">
                    <li>
                      <h6 class="text-white d-inline-block mb-0">Ganadas: <?= $info['warWins'] ?></h6>
                    </li>
                    <li>
                      <h6 class="text-white">Perdidas: <?= $info['warLosses'] ?></h6>
                    </li>
                  </ul>
                </div>
                <div class="col">
                  <h4 class="text-white">L&iacute;der del Clan: <br><i class="fas fa-crown text-yellow" style="font-size: 13px;"></i> <?= $leader['name'] ?> <i class="fas fa-crown text-yellow" style="font-size: 13px;"></i></h4>
                </div>
                <div class="col text-right">
                  <a href="#" data-toggle="modal" data-target="#newPublication" class="btn btn-sm btn-neutral">Publicar</a>

                  <div class="modal fade" id="newPublication" tabindex="-1" role="dialog" aria-labelledby="modal-default" aria-hidden="true">
                    <div class="modal-dialog modal- modal-dialog-centered" role="document">
                      <div class="modal-content">
                        <div class="modal-header">
                          <h6 class="modal-title" id="modal-title-default"><img src="<?= $info['badgeUrls']['small'] ?>" alt=""> Nueva Publicaci&oacute;n</h6>
                          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                          </button>
                        </div>

                        <form action="" method="post" enctype="multipart/form-data">
                          <div class="modal-body text-left">
                            <label for="fileUpload" class="text-center text-muted" style="font-size: 100px;width: 100%;cursor: pointer;">
                              <h2 class="text-muted" id="nameFileload">Click aquí para cargar archivo</h2>
                              <i id="loadIcon" class="fas fa-cloud-upload-alt opacity-5"></i>
                            </label>
                            <center>ó</center>
                            <br>

                            <div class="form-group">
                              <input type="text" name="txtUrl" class="form-control" id="txtUrl" placeholder="url de youtube o tiktok">
                            </div>

                            <hr class="dropdown-divider">
                            <div class="form-group">
                              <label for="txtDescriptionPublication">Descripci&oacute;n</label>
                              <textarea name="txtDescriptionPublication" id="txtDescriptionPublication" cols="30" rows="5" class="form-control" placeholder="(opcional)"></textarea>
                            </div>
                            <input type="file" onchange="onLoadFile(this)" id="fileUpload" name="file" style="visibility: hidden;width: 0px;height: 0px;" accept=".png, .jpeg, .jpg, .gif, .mp4, .3gp">
                          </div>

                          <div class="modal-footer">
                            <button type="submit" class="btn btn-primary">Publicar</button>
                            <button type="button" class="btn btn-link  ml-auto" data-dismiss="modal">Cerrar</button>
                          </div>
                        </form>
                      </div>
                    </div>
                  </div>

                </div>
              </div>

              <!-- Reyes de las Donaciones -->
              <div class="row">
                <?php foreach ($kingDonation as $key => $member) : ?>
                  <div class="col-xl-3 col-md-6">
                    <div class="card card-stats">
                      <?php if ($member['tag'] == Session::getPlayerTag()) : ?>
                        <a href="./?view=profile&id=<?= md5(Session::getUserId()) ?>">
                          <div data-toggle="tooltip" title="Perfil" class="avatar rounded-circle" style="position: absolute;bottom: -15px;right: -15px;background-color: <?= Session::getColorPage() ?>;">
                            <i class="fas fa-eye text-white"></i>
                          </div>
                        </a>
                      <?php endif; ?>
                      <!-- Card body -->
                      <a href="./?view=showgamer&tag=<?= str_replace('#', '', $member['tag']) ?>" style="">
                        <div class="card-body">
                          <div class="row">
                            <div class="col">
                              <h5 class="card-title text-uppercase mb-0"><?= ($key == 0) ? '<i class="fas fa-crown"></i> ' : '' ?><?= $member['name'] ?></h5>
                              <span class="h2 font-weight-bold text-muted mb-0"><strong><?= $member['donations'] ?></strong></span>
                              <span class="text-muted">Donaciones</span>
                            </div>
                            <div class="col-auto">
                              <div class="icon icon-shape rounded-circle shadow">
                                <img src="<?= $member['league']['iconUrls']['small'] ?>" alt="">
                              </div>
                            </div>
                          </div>
                          <p class="mt-3 mb-0 text-sm">
                            <span class="<?= getAnswerDonations($member['donations'], $member['donationsReceived']) ?> mr-2"><i class="fa fa-arrow-<?= (($member['donations'] - $member['donationsReceived']) > 0 ? 'up' : 'down') ?>"></i> <?= $member['donationsReceived'] ?></span>
                            <span class="text-muted">Recividas</span>
                          </p>
                        </div>
                      </a>
                    </div>
                  </div>
                <?php endforeach; ?>
              </div>
            </div>
          </div>
        </div>
      <?php elseif ($view == 'profile') : ?>
        <?php
        $userOption = $option->getOption((isset($_GET['id']) ? $_GET['id'] : ''));
        $_GET['tag'] = str_replace('#', '', $userOption['playerTaguseroption']);
        ?>
        <div class="header align-items-center" style="min-height: 500px; background-image: url('<?= $img['theme']['coverprofile'] ?>'); background-size: cover; background-position: center top;">
          <!-- Mask -->
          <span class="mask opacity-6" style="background-color: <?= $userOption['colorPageuseroption'] ?>;"></span>
          <!-- Header container -->
          <div class="container-fluid align-items-center">
            <div class="row">
              <div class="col-lg-3">
                <h1 class="display-2 text-white">Hola <?= Session::getName() ?></h1>
                <?php if ($userData['idUser'] == Session::getUserId()) : ?>
                  <p class="text-white mt-0 mb-5">Este es tu perfil, aquí puedes actualizar tu informaci&oacute;n personal.</p>
                <?php else : ?>
                  <p class="text-white mt-0 mb-5">Este es el perfil de <strong><?= $userData['nameUser'] ?></strong>, aquí puedes visualizar su informaci&oacute;n personal y publicaciones.</p>
                <?php endif; ?>
                <h3 class="text-white">Etiquetas:</h3>
                <a href="#" class="badge badge-danger">MIEMBRO</a>
                <?php if ($userData['privileges']) : ?>
                  <a href="#" class="badge badge-success">ADMIN</a>
                <?php endif; ?>
              </div>
              <div class="col">
                <?php include $views['__showgamer']; ?>
              </div>
            </div>
          </div>
        </div>
      <?php endif; ?>
      <!-- Page content -->

      <div class="container-fluid mt--6">
        <?php
        if (Session::Auth()) {
          include $views[$view];
        } else {
          header('Location: ./?view=login');
        }
        ?>
      </div>

      <div class="card" style="border: <?= Session::getColorPage() ?> solid 1px;" id="showUser">
        <div class="close-user-online" onclick="onClickHiddenUser('#showUser')" data-toggle="tooltip" title="Minimizar">
          <center><i class="fas fa-compress-alt"></i></center>
        </div>
        <div class="card-header">Usuarios en Linea</div>
        <div class="card-body" style="overflow:auto;">
          <div id="usersonline"></div>
        </div>
      </div>

      <button class="btn btn-neutral bg-white avatar rounded-circle" id="initScroll"><i class="ni ni-bold-up"></i></button>

      <div class="btn btn-neutral avatar rounded-circle" style="position: fixed;bottom: 15px;right:15px;background-color: <?= Session::getColorPage() ?>;" onclick="onClickShowUser(this)">
        <i class="fas fa-users text-white"></i>
        <span style="position:absolute;bottom: 0px; right: -10px;">
          <span class="badge badge-success" userid='<?= md5(Session::getUserId()) ?>' username='<?= Session::getUsername() ?>' image='<?= $img['profile'][Session::getImage()] ?>' id="cantuseronline"></span>
        </span>

        <script src="./js/home.js"></script>
      </div>
    <?php else : ?>
      <div class="mask">
        <?php include $views[$view]; ?>
        <?php include $views['footer']; ?>
      </div>
    <?php endif; ?>
    <!-- Argon Scripts -->
    <!-- Core -->
    <script src="assets/vendor/jquery/dist/jquery.min.js"></script>
    <script src="assets/vendor/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
    <script src="assets/vendor/js-cookie/js.cookie.js"></script>
    <script src="assets/vendor/jquery.scrollbar/jquery.scrollbar.min.js"></script>
    <script src="assets/vendor/jquery-scroll-lock/dist/jquery-scrollLock.min.js"></script>
    <!-- Optional JS -->
    <script src="assets/vendor/chart.js/dist/Chart.min.js"></script>
    <script src="assets/vendor/chart.js/dist/Chart.extension.js"></script>
    <!-- Argon JS -->
    <script src="assets/js/argon.js?v=1.2.0"></script>
    <script src="https://cdn.datatables.net/1.10.25/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
      var tag = '';
      var intervalCopy;

      var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-toggle="tooltip"]'))
      var tooltipList = tooltipTriggerList.map(function(tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl)
      })

      function copyText(element) {
        if (tag == '') {
          var input = document.createElement('input');
          input.setAttribute('value', $(element)[0].innerHTML);
          document.body.appendChild(input);
          input.select();
          document.execCommand('copy');
          document.body.removeChild(input);
          tag = $(element)[0].innerHTML;
          $(element)[0].innerHTML = 'Copiado!';
          intervalCopy = setInterval(() => {
            clearInterval(intervalCopy);
            $(element)[0].innerHTML = tag;
            tag = '';
          }, 3000);
        } else {
          $(element)[0].innerHTML = tag;
          tag = '';
        }
      }

      let cantElementSelect = [];
      var values = [];
      var elementID = '';

      function selected(element, contElement) {
        if (cantElementSelect[contElement] == undefined) {
          cantElementSelect[contElement] = 0;
        }
        if ($(element)[0].checked) {
          cantElementSelect[contElement]++;
          values.push({
            name: $(element).attr('member'),
            url: $(element).attr('url'),
            trophies: $(element).attr('trophies'),
            position: $(element).attr('position')
          });
        } else {
          cantElementSelect[contElement]--;
          var value_temp = [];
          values.forEach((val, index) => {
            if (val.position !== $(element).attr('position')) {
              value_temp.push(val);
            }
          })
          values = value_temp;
        }
        $('#' + contElement)[0].innerHTML = cantElementSelect[contElement];
        elementID = contElement;
      }

      function sendMembers() {
        if (cantElementSelect[elementID] >= 5) {
          $.post(
            "./request/post/memberList.php", {
              members: values,
              clan: '<?= $info['name'] ?>',
              badgeUrls: '<?= $info['badgeUrls']['small'] ?>',
              description: $('#txtDescriptionList').val()
            }, (request) => {
              request = JSON.parse(request);
              if (request.status) {
                Swal.fire(
                  'Creada Con Exito',
                  'Lista de Guerra Creada.',
                  'success'
                ).then(() => {
                  location.reload();
                })
              }
            }
          );
        } else {
          Swal.fire(
            'Miembros insuficientes',
            'Debe seleccionar 10 o más Miembros del clan.',
            'error'
          )
        }
      }

      function onClickLike(idUser, idPublication, elementID, idUserPublication) {
        var element = document.getElementById(elementID);
        var elementClass = element.classList[0];

        $.post(
          '<?= $request['post']['publication'] ?>', {
            idUserPublication: idUserPublication,
            idUser: idUser,
            idPublication: idPublication
          }, (answer) => {
            if (elementClass == 'far') {
              elementClass = 'fas';
            } else {
              elementClass = 'far';
            }

            element.classList.forEach((value, index) => {
              if (index > 0) {
                elementClass += ' ' + value;
              }
            })
            element.className = elementClass;
          }
        );
      }

      function onLoadFile(element) {
        var acum = $('#loadIcon')[0].className;
        if ($(element)[0].files[0].size <= 5242880) {
          if ($('#loadIcon')[0].classList.length === 3) {
            acum = $('#loadIcon')[0].className + ' text-success'
          } else if ($('#loadIcon')[0].classList.length > 3) {
            acum.replace('text-danger', 'text-success');
          }
          $("#nameFileload")[0].innerText = $(element)[0].files[0].name;
        } else {
          if ($('#loadIcon')[0].classList.length === 3) {
            acum = $('#loadIcon')[0].className + ' text-danger'
          } else if ($('#loadIcon')[0].classList.length > 3) {
            acum.replace('text-success', 'text-danger');
          }
          $("#nameFileload")[0].innerText = 'Este archivo supera los 5 MB permitidos.';
        }
        $('#loadIcon')[0].className = acum;
      }

      function onClickDelete(userid, idPublication) {
        Swal.fire({
          title: '¿Realmente quieres borrar esta publicación?',
          showDenyButton: true,
          confirmButtonText: `Si`,
          denyButtonText: `No`,
        }).then((result) => {
          /* Read more about isConfirmed, isDenied below */
          if (result.isConfirmed) {
            $.post(
              '<?= $request['post']['publication'] ?>', {
                idPublication: idPublication,
                userid: userid
              }, () => {
                Swal.fire('Exito!', 'Publicación Eliminada.', 'success').then(() => {
                  location.reload();
                })
              }
            )
          }
        })
      }

      function onPlay(id) {
        if ($('#' + id)[0].classList.length === 0) {
          $('#' + id)[0].className = $('#' + id)[0].className + 'opacity-5';
        }
      }

      function onPause(id) {
        var acumClass = '';
        var listClass = $('#' + id)[0].classList;
        if (listClass.length === 1) {
          for (let i = 0; i < listClass.length - 1; i++) {
            acumClass += listClass[i] + ' ';
          }
          $('#' + id)[0].className = acumClass;
        }
      }

      $(document).ready(() => {
        $('#listMembers').DataTable();
        $('#listMembersWars').DataTable();
        <?php if ($view == 'currentwar' && count($currentWarLeagueGroup) > 1) : ?>
          currentwar();
        <?php elseif ($view == 'listwar') : ?>
          idElementName.forEach((value) => {
            $('#' + value).DataTable({
              pageLength: 10
            });
          })
        <?php endif; ?>
        // obteniendo el estilo del fondo
      })

      <?php if (!Session::Auth()) : ?>
        $('#maskBG')[0].style.height = $('#videoBG')[0].clientHeight + 'px';
      <?php endif; ?>

      if (location.search != '') { // mostrando alerta
        var search = location.search.split('&');
        if (search.length >= 2) {
          search = search[1].split('=');
          if (search.length == 2) {
            if (search[1] == 'success') {
              Swal.fire(
                'Eliminado',
                'Lista de Guerra Eliminada!',
                'success'
              )
            } else if (search[1] == 'error') {
              Swal.fire(
                'Error',
                'Esta Lista no Existe!',
                'error'
              )
            }
          }
        }
      }
    </script>

</body>

</html>