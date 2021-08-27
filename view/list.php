<?php
    $listsOptions = json_decode(file_get_contents('./json/list.json'), true);
?>

<div class="container-fuid mt-7">
    <h1 class="text-muted">Listas</h1>
    <hr class="dropdown-divider">
    <div class="row">
        <?php foreach ($listsOptions as $list) : ?>
            <div class="col-xl-3 col-md-6">
                <div class="card card-stats">
                    <!-- Card body -->
                    <a href="<?= $list['url'] ?>" class="">
                        <div class="card-body">
                            <div class="row">
                                <div class="col">
                                    <?=$list['name']?>
                                </div>
                                <div class="col-auto">
                                    <div class="icon icon-shape rounded-circle shadow <?=$list['bg'] . ' ' . $list['fg']?>">
                                        <i class="<?= $list['icon']?>"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
    <br><br><br><br><br>
</div>