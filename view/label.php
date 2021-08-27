<?php if ($troop['village'] == 'home') : ?>
    <?php
    $name = strtolower(str_replace('.', '', str_replace(' ', '', $troop['name'])));
    $url = isset($img['labels'][$name]) ? $img['labels'][$name] : '#';
    ?>
    <?php if ($url != '#' && !in_array($name, $filter)) : ?>
        <div style="display: inline-block;position: relative;" data-toggle="tooltip" data-html="true" title="<?= getTraslation($name) . '<br>Nivel ' . $troop['level'] ?>">
            <img src="<?= $url ?>" width="50px" class="rounded mx-auto bg-default img-responsive" style="margin-bottom: 5px;">
            <div style="position: absolute;bottom: 0px;right: 0px;">
                <span class="badge text-white" style="background-color: <?= ($troop['level'] == $troop['maxLevel']) ? '#A8800B' : '#DA1B0F' ?>;"><?= $troop['level'] ?></span>
            </div>
        </div>
    <?php else : ?>
        <?php if (in_array($name, $filter)) : ?>
            <?php array_push($animals, $troop) ?>
        <?php endif; ?>
    <?php endif; ?>
<?php endif; ?>