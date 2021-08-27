<?php
if (isset($_POST['txtQuestion'])) {
    $_POST['txtQuestion'] = getPlaneText($_POST['txtQuestion']);
    if (strpos('-' . $_POST['txtQuestion'], '¿') == 0) {
        $_POST['txtQuestion'] = '¿' . $_POST['txtQuestion'];
    }
    if (strpos('-' . $_POST['txtQuestion'], '?') == 0) {
        $_POST['txtQuestion'] = $_POST['txtQuestion'] . '?';
    }

    $_POST['txtQuestion'] = strtoupper($_POST['txtQuestion']);
    $question->newQuestion($_POST['txtQuestion']);

    $activity->setActivity([
        "title" => "Nueva Pregunta",
        "description" => "El usuario " . Session::getUsername() . " hizo una pregunta.",
        "action" => "register"
    ]);

    $notification->setNotification([
        "title" => "Nueva Pregunta",
        "description" => Session::getUsername() . " hizo una pregunta.",
        "to" => 'sAdmin'
    ]);
} elseif (isset($_POST['txtAnswer']) && isset($_POST['idAnswer']) && isset($_POST['idQuestion'])) {
    $question->updateQuestion($_POST['idQuestion'], $_POST['txtAnswer']);

    $activity->setActivity([
        "title" => "Respuesta De Pregunta",
        "description" => "El usuario " . Session::getUsername() . " respondio una pregunta.",
        "action" => "update"
    ]);

    $notification->setNotification([
        "title" => "Respuesta de Pregunta",
        "description" => Session::getUsername() . " respondio tu pregunta.",
        "to" => $_POST['idAnswer']
    ]);
}

$questions = $question->getQuestions();
?>

<div class="container-fluid mt-7">
    <nav aria-label="breadcrumb" role="navigation">
        <ol class="breadcrumb">
            <li class="breadcrumb-item" aria-current="page"><a href="./?view=publication">Inicio</a></li>
            <li class="breadcrumb-item active" aria-current="page">Informaci&oacute;n</li>
        </ol>
    </nav>
    <h1 class="text-muted">INFORMACIÓN: PREGUNTAS Y RESPUESTAS</h1>

    <div class="accordion-1">
        <div class="container">
            <div class="row">
                <div class="col-md-12 ml-auto">
                    <div class="accordion my-3" id="accordionExample">

                        <div class="card">
                            <div class="card-header">
                                <h5 class="mb-0">
                                    <button class="btn btn-link w-100 text-primary text-left" type="button" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                        ¿COMO REALIZAR UNA PUBLICACIÓN?
                                    </button>
                                </h5>
                            </div>

                            <div id="collapseOne" class="collapse" data-parent="#accordionExample">
                                <div class="card-body opacity-8">
                                    Para realizar un publicaci&oacute;n nos dirigimos a la opci&oacute;n
                                    <a href="./?view=publication"><strong>Publicaciones</strong></a>
                                    de la barra lateral izquierda. <br><br>
                                    <div class="row">
                                        <div class="col-sm-0"><img src="<?= $img['theme']['menu'] ?>" width="300px" alt=""></div>
                                        <div class="col">
                                            Una vez que cargue la p&aacute;gina ubica el boton <strong>Publicar</strong> que se
                                            encuentra en la portada a la derecha de la informaci&oacute;n del clan.
                                            <br><br>
                                            Cuando hagas click sobre el boton aparecer&aacute; el siguiente modal: <br>
                                            <div class="row">
                                                <div class="col"><img src="<?= $img['theme']['publication'] ?>" width="300"></div>
                                                <div class="col">
                                                    <br>
                                                    Si lo que quieres es cargar un archivo (imagen o video) puedes hacer click en
                                                    <strong>Click aqu&iacute; para cargar archivo</strong> (la capacidad maxima de carga es de 5 MB).
                                                    <br><br>
                                                    En cambio si lo que deseas es colocar una url, puedes agregar la url de un video de
                                                    yotube o tiktok, para hacer esto debes ir al video que quieres publicar y luego
                                                    haces click en compartir, copias la url y la pegas en el campo <strong>url de youtube o tiktok</strong>:
                                                    <br><br>
                                                    <strong>YouTube</strong><br>
                                                    <img src="<?= $img['theme']['youtube'] ?>" width="100%" alt="">
                                                    <br><br>
                                                    <strong>TikTok</strong><br>
                                                    <img src="<?= $img['theme']['tiktok'] ?>" width="100%" alt="">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <br>
                                    Por &uacute;ltimo, puedes agregar una descripci&oacute;n y luego click en <strong>Publicar</strong>.
                                    <br><br>
                                    <h4 class="text-muted">Nota: las url de tiktok son lentas a la hora de mostrar el contenido en la p&aacute;gina.</h4>
                                </div>
                            </div>
                        </div>

                        <div class="card">
                            <div class="card-header">
                                <h5 class="mb-0">
                                    <button class="btn btn-link w-100 text-primary text-left" type="button" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="true" aria-controls="collapseOne">
                                        ¿COMO FUNCIONAN LAS NOTIFICACIONES?
                                    </button>
                                </h5>
                            </div>

                            <div id="collapseTwo" class="collapse" data-parent="#accordionExample">
                                <div class="card-body opacity-8">
                                    La importancia de las notificationes es mantener informado al usuario de las
                                    actividades que ocurren en la p&aacute;gina, estas pueden ser:
                                    <br><br>
                                    <ul>
                                        <li>Actualizaci&oacute;n de perfil.</li>
                                        <li>Realizar una publicaci&oacute;n.</li>
                                        <li>Comentar una publicaci&oacute;n.</li>
                                        <li>Darle like a una publicaci&oacute;n.</li>
                                        <li>Crear una lista de guerra.</li>
                                        <li>Actualizar una lista de guerra.</li>
                                        <li>Borrar una lista de guerra.</li>
                                    </ul>
                                </div>
                            </div>
                        </div>

                        <div class="card">
                            <div class="card-header">
                                <h5 class="mb-0">
                                    <button class="btn btn-link w-100 text-primary text-left" type="button" data-toggle="collapse" data-target="#collapse3" aria-expanded="true" aria-controls="collapseOne">
                                        ¿PARA QUE SIRVE EL REGISTRO DE GUERRA?
                                    </button>
                                </h5>
                            </div>

                            <div id="collapse3" class="collapse" data-parent="#accordionExample">
                                <div class="card-body opacity-8">
                                    El registro de guerra muestra todas las guerras que ha tenido
                                    el clan con excepci&oacute;n de las ligas de guerras de clanes.
                                </div>
                            </div>
                        </div>

                        <div class="card">
                            <div class="card-header">
                                <h5 class="mb-0">
                                    <button class="btn btn-link w-100 text-primary text-left" type="button" data-toggle="collapse" data-target="#collapse4" aria-expanded="true" aria-controls="collapseOne">
                                        ¿EL REGISTRO DE GUERRA SIEMPRE SER&Aacute; VISIBLE?
                                    </button>
                                </h5>
                            </div>

                            <div id="collapse4" class="collapse" data-parent="#accordionExample">
                                <div class="card-body opacity-8">
                                    No, porque esto depende del clan,
                                    si el clan tiene p&uacute;blico el registro de guerra, pues aparecer&aacute; la opci&oacute;n
                                    <strong>Registro de Guerras</strong>.
                                </div>
                            </div>
                        </div>

                        <?php foreach ($questions as $key => $value) : ?>
                            <div class="card">
                                <div class="card-header">
                                    <h5 class="mb-0">
                                        <button class="btn btn-link w-100 text-primary text-left" type="button" data-toggle="collapse" data-target="#collapse-<?= md5($key) ?>" aria-expanded="true" aria-controls="collapseOne">
                                            <?= $value['question'] ?>
                                        </button>
                                        <?php if (Session::superAdmin()) : ?>
                                            <button class="btn btn-info" data-toggle="modal" data-target="#modal-<?= md5($key) ?>">Responder</button>
                                            <div class="modal fade" id="modal-<?= md5($key) ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                <div class="modal-dialog modal-dialog-centered" role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="exampleModalLabel"><?= $value['question'] ?></h5>
                                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                <span aria-hidden="true">&times;</span>
                                                            </button>
                                                        </div>
                                                        <form action="" method="post">
                                                            <div class="modal-body">
                                                                <div class="form-group">
                                                                    <label for="">Ingresa tu respuesta:</label>
                                                                    <br>
                                                                    <input type="hidden" name="idAnswer" value="<?= $value['idUserquestion'] ?>">
                                                                    <input type="hidden" name="idQuestion" value="<?= $value['idquestion'] ?>">
                                                                    <textarea class="form-control" name="txtAnswer" cols="30" rows="10" placeholder="respuesta" minlength="6" maxlength="500" required><?= $value['answerquestion'] ?></textarea>
                                                                </div>
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                                <button type="submit" class="btn btn-primary">Enviar</button>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        <?php endif; ?>
                                    </h5>
                                </div>

                                <div id="collapse-<?= md5($key) ?>" class="collapse" data-parent="#accordionExample">
                                    <div class="card-body opacity-8">
                                        <?= $value['answerquestion'] ?>
                                    </div>
                                    <div class="card-footer">
                                        <div class="row">
                                            <div class="col">
                                                <strong>Pregunta de:</strong> <br><br>
                                                <a href="./?view=profile&id=<?=md5($value['idUserquestion'])?>">
                                                    <img src="<?= $img['profile'][$value['imageurl']] ?>" class="avatar rounded-circle" alt=""> <?= $value['username'] ?>
                                                </a>
                                            </div>
                                            <div class="col text-muted text-right text-bottom">
                                                <?= $value['datequestion'] ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                        <br><br><br><br>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="question" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Nueva Pregunta</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="" method="post">
                <div class="modal-body">
                    <div class="form-group">
                        <label for="">¿Cu&aacute;l es tu pregunta?</label>
                        <input type="text" name="txtQuestion" id="" class="form-control" placeholder="¿...?" minlength="6" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Enviar</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="avatar rounded-circle bg-gray" data-toggle="modal" data-target="#question" style="position: fixed;bottom: 70px;right: 27px;cursor: pointer;width: 40px;height: 40px;">
    <i class="fas fa-question"></i>
</div>