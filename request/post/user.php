<?php

include '../load.php';

if(isset($_POST['update'])){
    switch($_POST['update']['action']){
        case 'active':
            $activity->setActivity([
                "title" => "Actulización de Acceso",
                "description" => "El usuario " . Session::getUsername() . " baneo o concedió acceso a otro usuario.",
                "action" => "update"
            ]);
            $user->changeActive($_POST['update']['id']);
        break;
        case 'admin':
            $activity->setActivity([
                "title" => "Actulización de Privilegios",
                "description" => "El usuario " . Session::getUsername() . " quito o asigno un administrador.",
                "action" => "update"
            ]);
            $user->changeAdmin($_POST['update']['id']);
        break;
    }
}