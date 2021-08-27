<?php

include '../load.php';

if(isset($_POST['LIST_ID']) && isset($_POST['LIST_ACTION'])){
    switch($_POST['LIST_ACTION']){
        case 'update':
            $activity->setActivity([
                "title" => "Actualización de Lista de Guerra",
                "description" => "El usuario <strong>" . Session::getUsername() . "</strong> actualizo una lista de guerra.",
                "action" => "update"
            ]);
            $notification->setNotification([
                "title" => "Actualización",
                "description" => '<strong>' . Session::getUsername() . '</strong> actualizó la lista de guerra.',
                "to" => 'ALL'
            ]);
            $listWar->updateList($_POST['LIST']);
        break;
        case 'get':
            echo json_encode($listWar->getList($_POST['LIST_ID']));
        break;
    }
}