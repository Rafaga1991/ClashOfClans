<div class="scrollbar-inner">
  <!-- Brand -->
  <div class="sidenav-header  align-items-center">
    <a class="navbar-brand" href="./?view=publication">
      <img src="<?= $info['badgeUrls']['medium'] ?>" class="navbar-brand-img" alt="..."><?= $info['name'] ?>
    </a>
  </div>
  <div class="navbar-inner">
    <!-- Collapse -->
    <div class="collapse navbar-collapse" id="sidenav-collapse-main">
      <!-- Nav items -->
      <ul class="navbar-nav">
        <li class="nav-item">
          <a class="nav-link <?= ($view == 'publication') ? 'text-white' : '' ?>" style="background-color: <?=($view == 'publication')?Session::getColorPage():'white'?>" href="./?view=publication">
            <i class="ni ni-collection text-primary"></i>
            <span class="nav-link-text">Publicaciones</span>
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link <?= ($view == 'notification') ? 'text-white' : '' ?>" style="background-color: <?=($view == 'notification')?Session::getColorPage():'white'?>" href="./?view=notification">
            <i class="ni ni-bell-55 text-orange"></i>
            <span class="nav-link-text">Notificaciones</span>
          </a>
        </li>
        <?php if ($info['isWarLogPublic']) : ?>
          <li class="nav-item">
            <a class="nav-link <?= ($view == 'warlog') ? 'text-white' : '' ?>" style="background-color: <?=($view == 'warlog')?Session::getColorPage():'white'?>" href="./?view=warlog">
              <i class="ni ni-bullet-list-67 text-primary"></i>
              <span class="nav-link-text">Registro de Guerras</span>
            </a>
          </li>
        <?php endif; ?>
        <li class="nav-item">
          <a class="nav-link <?= ($view == 'currentwar') ? 'text-white' : '' ?>" style="background-color: <?=($view == 'currentwar')?Session::getColorPage():'white'?>" href="./?view=currentwar">
            <i class="fas fa-fist-raised text-danger"></i>
            <span class="nav-link-text">Guerra Actual</span>
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link <?= ($view == 'members') ? 'text-white' : '' ?>" style="background-color: <?=($view == 'members')?Session::getColorPage():'white'?>" href="./?view=members">
            <i class="fas fa-user-friends text-danger"></i>
            <span class="nav-link-text">Miembros del Clan</span>
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link <?= ($view == 'list') ? 'text-white' : '' ?>" style="background-color: <?=($view == 'list')?Session::getColorPage():'white'?>" href="./?view=list">
            <i class="fas fa-list-ol text-red"></i>
            <span class="nav-link-text">Listas</span>
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link <?= ($view == 'chats') ? 'text-white' : '' ?>" style="background-color: <?=($view == 'chats')?Session::getColorPage():'white'?>" href="./?view=chats">
            <i class="fas fa-comments"></i>
            <span class="nav-link-text">Chat</span>
          </a>
        </li>
        <?php if (Session::Admin() || Session::superAdmin()) : ?>
          <li class="nav-item">
            <a class="nav-link <?= ($view == 'users') ? 'text-white' : '' ?>" style="background-color: <?=($view == 'users')?Session::getColorPage():'white'?>" href="./?view=users">
              <i class="fas fa-users"></i>
              <span class="nav-link-text">Usuarios</span>
            </a>
          </li>
        <?php endif; ?>
      </ul>
    </div>
  </div>
</div>