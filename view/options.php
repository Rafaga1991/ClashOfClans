<?php
$typeAlert = 'success';
if (isset($_POST['txtColor'])) {
    $_POST['txtTag'] = isset($_POST['txtTag']) ? $_POST['txtTag'] : Session::getClanTag();
    $clanInfo = $client->getClan($_POST['txtTag'])->getClanInfo();
    if (count($clanInfo) > 1) {
        if (isMember($clanInfo['memberList'], Session::getPlayerTag()) || Session::Admin()) {
            $option->upOption([
                "idUser" => Session::getUserId(),
                "color" => $_POST['txtColor'],
                "clanTag" => $_POST['txtTag']
            ]);
            $message = 'Datos Actualizados Con Exito!';
            $_SESSION['color'] = $_POST['txtColor'];
            $_SESSION['tag']['clan'] = $_POST['txtTag'];
        } else {
            $typeAlert = 'info';
            $message = "No eres miembro del clan <strong>{$clanInfo['name']}</strong>.";
        }
    } else {
        $typeAlert = 'danger';
        $message = 'Tag de clan no valido.';
    }
}
?>

<form method="post">
    <div class="container-fluid mt-7">
        <nav aria-label="breadcrumb" role="navigation">
            <ol class="breadcrumb">
                <li class="breadcrumb-item" aria-current="page"><a href="./?view=publication">Inicio</a></li>
                <li class="breadcrumb-item active" aria-current="page">Opciones</li>
            </ol>
        </nav>
        <?php if (isset($message)) : ?>
            <div class="alert alert-<?= $typeAlert ?> text-center"><?= $message ?></div>
        <?php endif; ?>
        <h1 class="text-muted"><i class="ni ni-settings-gear-65"></i> OPCIONES</h1>
        <hr class="dropdown-divider">
        <div class="row">
            <div class="col">
                <div class="form-group">
                    <label for="txtTag" class="form-label">Tag del Clan</label>
                    <input type="text" class="form-control" name="txtTag" value="<?= Session::getClanTag() ?>" id="txtTag" minlength="4" maxlength="10" disabled required>
                    <input type="checkbox" name="" id="cbTag" onclick="$('#txtTag')[0].disabled = !$(this)[0].checked;">
                    <label for="cbTag" class="form-label" style="font-size: 14px;">Activar tag para cambiarlo.</label>
                </div>
            </div>
            <div class="col">
                <div class="form-group mb-4">
                    <label for="txtColor" class="form-label">Color de la página</label>
                    <input type="color" class="form-control" value="<?= Session::getColorPage() ?>" name="txtColor" id="txtColor">
                </div>
            </div>
        </div>
        <button type="submit" class="btn btn-danger">Guardar Cambios</button>
    </div>
</form>