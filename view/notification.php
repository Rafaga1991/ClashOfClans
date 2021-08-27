<!-- Page content -->
<div class="container-fluid mt-6">
  <br>
  <h2 class="text-muted">Notificaciones</h2>
  <h3 class="text-muted">Hola <?= Session::getName() ?>, aqu&iacute; puedes visualizar todas tus notificaciones.</h3>
  <table class="table">
    <tbody>
      <?php foreach ($notifications['notifications'] as $value) : ?>
        <tr>
          <td style="width: 0px;">
            <div class="avatar avatar-sm rounded-circle bg-white">
              <img src="<?=$info['badgeUrls']['small']?>" alt="">
            </div>
          </td>
          <td class="rounded" style="background-color: <?=Session::getColorPage()?>;">
            <div class="card">
              <div class="card-header"><?= $value['titleNotification'] ?></div>
              <div class="card-body">
                <p><?= $value['descriptionNotification'] ?></p>
              </div>
            </div>
            <div class="text-right text-white">
              <?= date('h:i A | M d', strtotime($value['dateNotification'])) ?>
            </div>
          </td>
        </tr>
      <?php endforeach; ?>
    </tbody>
  </table>
</div>
<br><br><br><br><br>