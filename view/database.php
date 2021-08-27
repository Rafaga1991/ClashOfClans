<?php
if (!Session::superAdmin()) {
    reloadPage('publication');
}

if (isset($_GET['export'])) {
    $requestSQL->exportData();
}

if (isset($_FILES['fileSQLImport'])) {
    $req = $requestSQL->importData(json_decode(file_get_contents($_FILES['fileSQLImport']['tmp_name']), true));
    reloadPage("$view&{$req['state']}");
}

$tables = json_decode($requestSQL->requestSQLCode('SHOW tables'), true);
?>

<div class="container-fluid mt-6">
    <br>
    <?php if (isset($_GET['error'])) : ?>
        <label class="alert alert-primary" style="width: 100%;">Los datos en el archivo ya se encontraban en la base de datos!</label>
    <?php elseif (isset($_GET['success'])) : ?>
        <label class="alert alert-success" style="width: 100%;">Los datos se cargaron con exito!</label>
    <?php endif; ?>
    
    <div class="text-right">
        <form action="./?view=<?= $view ?>" method="post" enctype="multipart/form-data">
            <input type="file" name="fileSQLImport" onchange="this.form.submit()" style="visibility: hidden;" id="loadFileSQL" accept=".json">
            <?php if (!isset($_GET['export'])) : ?>
                <a href="./?view=<?= $view ?>&export" class="btn btn-primary">Exportar</a>
            <?php else : ?>
                <a href="./json/database.json" class="btn btn-primary" download>Descargar</a>
            <?php endif; ?>
            <a href="#" onclick="document.getElementById('loadFileSQL').click()" class="btn btn-success">Importar</a>
        </form>
    </div>
    <h1 class="text-muted">C&oacute;digo SQL</h1>
    <textarea class="form-control" placeholder="ingresa el código sql" id="txtSQL" cols="30" rows="10"></textarea>
    <hr class="dropdown-divider">
    <div class="text-right">
        <div class="row text-left">
            <div class="col">
                <div class="form-group">
                    <label for="query" class="form-label">Consultar</label>
                    <select class="form-control" id="query" onclick="showQuery(this)">
                        <?php foreach ($tables as $table) : ?>
                            <option value="SELECT * FROM <?= $table[0] ?>"><?= $table[0] ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>
            <div class="col">
                <div class="form-group">
                    <label for="delete" class="form-label">Eliminar</label>
                    <select class="form-control" id="delete" onclick="showQuery(this)">
                        <?php foreach ($tables as $table) : ?>
                            <option value="DELETE FROM <?= $table[0] ?>"><?= $table[0] ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>
            <div class="col">
                <div class="form-group">
                    <label for="update" class="form-label">Actualizar</label>
                    <select class="form-control" id="update" onclick="showQuery(this)">
                        <?php foreach ($tables as $table) : ?>
                            <option value="UPDATE <?= $table[0] ?> SET __PARAM__ = __VALUE__ WHERE __PARAM__=__VALUE__"><?= $table[0] ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>
            <div class="col">
                <div class="form-group">
                    <label for="insert" class="form-label">Agregar</label>
                    <select class="form-control" id="insert" onclick="showQuery(this)">
                        <?php foreach ($tables as $table) : ?>
                            <option value="INSERT INTO <?= $table[0] ?>(__PARAMS__) VALUES(__VALUES__)"><?= $table[0] ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>
        </div>
        <button class="btn btn-outline-success" onclick="onClickSendSQL()">Procesar</button>
    </div>


    <h1 class="text-muted">Salida de Consulta</h1>
    <textarea class="form-control" id="txtSQLOutput" cols="30" rows="10" readonly="false"></textarea>
    <br><br><br><br><br>
</div>

<script>
    function showQuery(element) {
        $('#txtSQL').val(element.value);
    }

    function onClickSendSQL() {
        $.post(
            '<?= $request['post']['database'] ?>', {
                sql: $('#txtSQL').val()
            }, (request) => {
                try {
                    JSON.parse(request);
                    request = request.replaceAll('[', '[\n\t');
                    request = request.replaceAll(']', '\n]');
                    request = request.replaceAll('{', '{\n\t\t');
                    request = request.replaceAll('}', '\n\t}');

                    request = request.replaceAll(':', ': ');
                    request = request.replaceAll(',', ',\n\t\t');

                    request = request.replaceAll('},\n\t\t', '},\n\t');

                    request = request.replaceAll('"', '');

                    $('#txtSQLOutput').val(request);
                } catch (ex) {
                    $('#txtSQLOutput').val('erro: sintaxis inválida.');
                }
            }
        )
    }
</script>