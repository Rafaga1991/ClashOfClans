<?php

include '../load.php';

$view = 'login';
$answer = 'error';

if(isset($_GET['view'])){
    $view = $_GET['view'];
    switch($view){
        case 'listwar':
            $id = $_GET['id'];
            $listWar->deleteList($id);
            $answer = 'success';

            $activity->setActivity([
                "title" => "Borrado de Lista de Guerra",
                "description" => "El usuario " . Session::getUsername() . " borro una lista de guerra.",
                "action" => "delete"
            ]);
        break;
    }
}

header("Location: ../../?view=$view&status=$answer");