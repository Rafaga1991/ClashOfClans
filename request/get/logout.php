<?php

include '../load.php';

if(Session::Auth()){
    $activity->setActivity([
        "title" => "Cierre de Sesión",
        "description" => "El usuario " . Session::getUsername() . " cerro sesión con exito!",
        "action" => "logout"
      ]);
    Session::logout();
}

header('Location: ../../?view=login');