<!-- Main content -->
<div class="main-content">
  <!-- Header -->
  <div class="header pb-9 d-flex align-items-center" style="min-height: 500px; background-image: url('https://cdn.hobbyconsolas.com/sites/navi.axelspringer.es/public/media/image/2017/02/portada-guia-todas-estrategias-consejos-clash-clans.jpg'); background-size: cover; background-position: center top;">
    <!-- Mask -->
    <span class="mask bg-gradient-default opacity-8"></span>
    <!-- Header container -->
    <?php include $views['__showgamer']; ?>
  </div>
  
  <h2 class="text-center bg-default text-white">
    <i class="fas fa-star text-yellow" style="font-size: 15px"></i>
    <i class="fas fa-star text-yellow" style="font-size: 20px"></i>
    <i class="fas fa-star text-yellow" style="font-size: 15px"></i>
    Registro de Logros 
    <i class="fas fa-star text-yellow" style="font-size: 15px"></i>
    <i class="fas fa-star text-yellow" style="font-size: 20px"></i>
    <i class="fas fa-star text-yellow" style="font-size: 15px"></i>
  </h2>
  <table class="table">
      <tbody>
        <?php foreach($player['achievements'] as $key => $value): ?>
          <?php
            $name = strtolower(str_replace(' ', '', $value['name']));
            $traslation = getTraslation($name);
            if(isset($traslation['completionInfo'])){
              if($traslation['completionInfo'] != null){
                $traslation['completionInfo'] = explode(':', $traslation['completionInfo'])[0];
                if($value['completionInfo'] != null){
                  $traslation['completionInfo'] = $traslation['completionInfo'] . (($value['value'] != 0)?': ' . $value['value']:'');
                }
              }
            }else{
              $traslation = [];
              $traslation['name'] = $value['name'];
              $traslation['info'] = $value['info'];
              $traslation['completionInfo'] = $value['completionInfo'];
            }
          ?>
          <tr>
            <td>
              <div class="text-center">
                <?php if($value['stars'] == 3): ?>
                  <i class="fas fa-star text-yellow" style="font-size: 15px"></i>
                  <i class="fas fa-star text-yellow" style="font-size: 20px"></i>
                  <i class="fas fa-star text-yellow" style="font-size: 15px"></i>
                <?php elseif($value['stars'] == 2):?>
                  <i class="fas fa-star text-yellow" style="font-size: 15px"></i>
                  <i class="fas fa-star text-yellow" style="font-size: 20px"></i>
                  <i class="far fa-star text-yellow" style="font-size: 15px"></i>
                <?php elseif($value['stars'] == 1):?>
                  <i class="fas fa-star text-yellow" style="font-size: 15px"></i>
                  <i class="far fa-star text-yellow" style="font-size: 20px"></i>
                  <i class="far fa-star text-yellow" style="font-size: 15px"></i>
                <?php elseif($value['stars'] == 0):?>
                  <i class="far fa-star text-yellow" style="font-size: 15px"></i>
                  <i class="far fa-star text-yellow" style="font-size: 20px"></i>
                  <i class="far fa-star text-yellow" style="font-size: 15px"></i>
                <?php endif;?>
              </div>
              <strong><?=$traslation['name']?></strong>
              <br>
              <ul>
                <li><?=$traslation['info']?></li>
                <?php if($traslation['completionInfo'] != null): ?>
                <li><?=$traslation['completionInfo']?></li>
                <?php endif; ?>
              </ul>
              <?php
                $percentTotal = ($value['value'] == 0)?100:0;
                $value['value'] = ($value['value'] == 0)?1:$value['value'];
                if($percentTotal == 0){
                  $onepercent = $value['target'] / 100;
                  $percentTotal = $value['value'] / $onepercent;
                  $percentTotal = ($value['value'] > $value['target'])?100:$percentTotal;
                }
              ?>
              <div class="d-flex align-items-center">
                <span class="completion mr-2"><?=$value['value'] . ' / ' . $value['target']?></span>
                <div>
                    <div class="progress">
                        <div class="progress-bar bg-success" role="progressbar" aria-valuenow="<?=$percentTotal?>" aria-valuemin="0" aria-valuemax="100" style="width: <?=$percentTotal?>%;"></div>
                    </div>
                </div>
              </div>
            </td>
          </tr>
        <?php endforeach;?>
      </tbody>
    </table>
</div>

