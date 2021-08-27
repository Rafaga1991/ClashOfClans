<footer class="py-5 bg-default">
    <div class="container">
      <div class="row align-items-center justify-content-xl-between">
        <div class="col-xl-6">
          <div class="copyright text-center text-xl-left text-muted">
            &copy; 2021 RMB
          </div>
        </div>
        <div class="col-xl-6">
          <ul class="nav nav-footer justify-content-center justify-content-xl-end">
            <li class="nav-item" data-toggle="tooltip" title="Perfil del Clan">
              <a href="clashofclans://action=OpenClanProfile&tag=<?=urlencode($info['tag'])?>" class="nav-link">Clan</a>
            </li>
            <li class="nav-item">
              <a href="clashofclans://action=OpenPlayerProfile&tag=<?=urlencode($leader['tag'])?>" data-toggle="tooltip" title="Perfil del Líder" class="nav-link">L&iacute;der</a>
            </li>
          </ul>
        </div>
      </div>
    </div>
</footer>