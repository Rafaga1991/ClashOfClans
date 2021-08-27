<?php
$path = './json/wars/' . $_GET['data'] . '.json';
$lastWar = json_decode(file_get_contents($path), true);
$members = [];
$cantMembers = 0;
foreach ($lastWar as $member) {
    $data = getMember($info['memberList'], $member['tag']);

    if (isset($member['attacks'])) {
        /*if (count($member['attacks']) == 2) {
        }*/
        $starT = 0;
        $timeT = 0;
        $destructionT = 0;
        $isMirror = true;
        foreach ($member['attacks'] as $attack) {
            /*$opponent = getMember($currentWar['opponent']['members'], $attack['defenderTag']);
            if ($opponent['mapPosition'] == $member['mapPosition'] && !$isMirror) {
                if ($attack['stars'] >= 2) {
                    $isMirror = true;
                }
            }*/
            $starT += $attack['stars'];
            $destructionT += $attack['destructionPercentage'];
            $timeT += $attack['duration'];
        }

        if ($isMirror) {
            array_push(
                $members,
                [
                    'name' => $member['name'],
                    'image' => $data['league']['iconUrls']['small'],
                    'time' => $timeT,
                    'star' => $starT,
                    'destruction' => $destructionT / 2
                ]
            );
        }
        $cantMembers++;
    }
}

$members = orderBy($members, 'star');

foreach ($members as $key => $member) {
    if ($key == 6) {
        $members[$key] = orderBy($member, 'time', 'asc');
    } else {
        $members[$key] = orderBy($member, 'destruction');
    }
}

//$cantMembers = count($lastWar);
$limit = count($lastWar) - 2;
$bestMember = '';

//showArray($members);
$cont = 0;
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $info['name'] ?></title>
    <link rel="shortcut icon" href="<?= $info['badgeUrls']['small'] ?>" type="image/x-icon">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" integrity="sha512-iBBXm8fW90+nuLcSKlbmrPcLa0OT92xO1BIsZ+ywDWZCvqsWgccV3gFoRBv0z+8dLJgyAHIhR35VZc2oM/gI1w==" crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>

<body>
    <div class="container">
        <h3 class="text-muted">TOP <?= $limit . ' / ' . count($lastWar) ?>: Miembros Destacados en la Guerra</h3>
        <br>
        <?php foreach ($members as $member) : ?>
            <?php foreach ($member as $values) : ?>
                <?php foreach ($values as $value) : ?>
                    <?php if ($cont < $limit) : ?>
                        <div class="row">
                            <div class="col">
                                <?php if ($cont == 0) : ?>
                                    <?php $bestMember = $value['name'] ?>
                                <?php endif; ?>
                                <?= $cont + 1 ?>. <img src="<?= $value['image'] ?>" width="50" alt="">
                                <?php if ($cont == 0) : ?>
                                    <i class="fas fa-crown"></i>
                                <?php endif; ?>
                                <?= $value['name'] ?>
                                <?php if ($cont == 0) : ?>
                                    <i class="fas fa-crown"></i>
                                <?php endif; ?>
                                <?php $cont++; ?>
                            </div>
                            <div class="col">
                                <?php for ($i = 0; $i < $value['star']; $i++) : ?>
                                    <i class="fas fa-star" style="color: #FFC300;"></i>
                                <?php endfor; ?>
                                <?php for ($i = 0; $i < (6 - $value['star']); $i++) : ?>
                                    <i class="far fa-star" style="color: #FFC300;"></i>
                                <?php endfor; ?>
                                <div class="progress">
                                    <div class="progress-bar" role="progressbar" style="width: <?= $value['destruction'] ?>%;" aria-valuenow="<?= $value['destruction'] ?>" aria-valuemin="0" aria-valuemax="100"><?= $value['destruction'] ?>%</div>
                                </div>
                            </div>
                        </div>
                        <hr class="dropdown-divider">
                    <?php endif; ?>
                <?php endforeach; ?>
            <?php endforeach; ?>
        <?php endforeach; ?>
        <br><br>
        <h2 class="text-muted">
            Felicidades a <?= $bestMember ?> por tener el mejor desempeño en la guerra.
        </h2>
        <!--<ol>
            <li>Atacar a su espejo y conseguir un minimo de 2 estrellas.</li>
            <li>Realizar los 2 ataques.</li>
            <li>Mayor estrellas conseguidas que los dem&aacute;s miembros en la guerra.</li>
            <li>Conseguir la victoria en el menor tiempo posible.</li>
            <li>Mayor destrucci&oacute;n que los dem&aacute;s miembros en la guerra.</li>
        </ol>-->
    </div>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>
    <script>
        window.onload = () => {
            window.print();
        }
    </script>
</body>

</html>