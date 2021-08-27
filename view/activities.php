<?php
if (!Session::superAdmin()) {
    reloadPage();
}
?>

<div class="container-fluid mt-6">
    <br>
    <nav aria-label="breadcrumb" role="navigation">
        <ol class="breadcrumb">
            <li class="breadcrumb-item" aria-current="page"><a href="./?view=publication">Inicio</a></li>
            <li class="breadcrumb-item active" aria-current="page">Actividades</li>
        </ol>
    </nav>
    <h2 class="text-muted">Registro de Actividades</h2>
    <hr class="dropdown-divider">
    <table class="table" id="activity">
        <thead>
            <tr>
                <th></th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($activities as $key => $value) : ?>
                <tr>
                    <td style="visibility: hidden;"><?=$value['idActivity']?></td>
                    <td class="bg-gradient-<?= getColor($value['actionActivity']) ?> text-white rounded">
                        <ul>
                            <li><span class="badge badge-danger">Título: </span><?= $value['titleActivity'] ?></li>
                            <li><span class="badge badge-danger">Descripci&oacute;n:</span> <?= $value['descriptionActivity'] ?></li>
                            <li><span class="badge badge-danger">Fecha:</span> <?= $value['dateActivity'] ?></li>
                        </ul>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
<br></br><br><br><br>