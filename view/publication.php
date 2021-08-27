<?php
$position = isset($_POST['position']) ? $_POST['position'] : 1;
$limitOption = $info['members'] / 10;
$limit = $position * 10;
// Colideres
$coleaders = [];
$coleaders['memberList'] = [];
$coleaders['members'] = [];

foreach ($info['memberList'] as $key => $member) {
  if(strtolower($member['role']) == 'coleader' || strtolower($member['role']) == 'leader'){
    array_push($coleaders['memberList'], $member);
  }

  if ($key < ($limit - 10) || $key >= $limit) {
    unset($info['memberList'][$key]);
  }
}
$coleaders['members'] = count($coleaders['memberList']);
?>

<br><br><br><br>
<div class="row">
  <div class="col-xl-8">
    <?php include $views['__publication'] ?>
  </div>

  <div class="col-xl-4">
    <div class="card">
      <div class="card-header border-0">
        <div class="row align-items-center">
          <div class="col">
            <h3 class="mb-0">Miembros (<span class="text-info"><?= $info['members'] ?></span>)</h3>
          </div>
          <div class="col text-right">
            <a href="./?view=members" class="btn btn-sm btn-primary">Ver</a>
          </div>
        </div>
      </div>
      <div class="card-body">
        <!-- Members table -->
        <?php foreach ($info['memberList'] as $keyMember => $member) : ?>
          <a href="./?view=showgamer&tag=<?= str_replace('#', '', $member['tag']) ?>" class="text-muted" style="text-decoration: none;">
            <div class="row" style="background-color: <?= $member['tag'] == Session::getPlayerTag() ? Session::getColorPage() . ';color: white;' : 'white;' ?>" data-toggle="tooltip" data-html="true" title="<?php include $tooltip['member']; ?>">
              <div class="col-6">
                <span style="font-size: 12px;"><?= $keyMember + 1 ?></span>. <img src="<?= $member['league']['iconUrls']['small'] ?>" width="15%" alt="">
                <span style="font-size: 12px;"><?= $member['name'] ?></span>
              </div>
              <div class="col">
                <span style="font-size: 12px;"><?= getTraslation($member['role']) ?></span>
              </div>
              <div class="col">
                <i class="ni ni-trophy" style="font-size: 12px;"></i> <?= $member['trophies'] ?>
              </div>
            </div>
          </a>
          <hr class="dropdown-divider">
        <?php endforeach; ?>
        <form action="" method="post">
          <center>
            <button type="submit" name="position" value="<?= (($position - 1) < 1) ? 1 : ($position - 1) ?>" class="btn rounded-circle">
              <i class="fas fa-angle-left"></i>
            </button>
            <?php for ($i = 0; $i < $limitOption; $i++) : ?>
              <input class="position-list-member" style="background-color: <?= (($i + 1) == $position) ? '#23BACA' : '' ?>;" type="submit" name="position" value="<?= $i + 1 ?>">
            <?php endfor; ?>
            <button type="submit" name="position" value="<?= (($position + 1) > $limitOption) ? $limitOption : ($position + 1) ?>" class="btn rounded-circle">
              <i class="fas fa-angle-right"></i>
            </button>
          </center>
        </form>
      </div>
    </div>

    <div class="card">
      <div class="card-header border-0">
        <div class="row align-items-center">
          <div class="col">
            <h3 class="mb-0">L&iacute;der y Col&iacute;deres (<span class="text-info"><?= $coleaders['members'] ?></span>)</h3>
          </div>
          <div class="col text-right">
            <a href="./?view=members" class="btn btn-sm btn-primary">Ver</a>
          </div>
        </div>
      </div>
      <div class="card-body">
        <!-- Members table -->
        <?php foreach ($coleaders['memberList'] as $keyMember => $member) : ?>
          <a href="./?view=showgamer&tag=<?= str_replace('#', '', $member['tag']) ?>" class="text-muted" style="text-decoration: none;">
            <div class="row" style="background-color: <?= $member['tag'] == Session::getPlayerTag() ? Session::getColorPage() . ';color: white;' : 'white;' ?>" data-toggle="tooltip" data-html="true" title="<?php include $tooltip['member']; ?>">
              <div class="col-6">
                <span style="font-size: 12px;"><?= $keyMember + 1 ?></span>. <img src="<?= $member['league']['iconUrls']['small'] ?>" width="15%" alt="">
                <span style="font-size: 12px;"><?= $member['name'] ?></span>
              </div>
              <div class="col">
                <span style="font-size: 12px;"><?= getTraslation($member['role']) ?></span>
              </div>
              <div class="col">
                <i class="ni ni-trophy" style="font-size: 12px;"></i> <?= $member['trophies'] ?>
              </div>
            </div>
          </a>
          <hr class="dropdown-divider">
        <?php endforeach; ?>
      </div>
    </div>
  </div>
</div>