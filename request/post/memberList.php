<?php

include '../load.php';

$members = [];
if(isset($_POST['members'])){
    $members['id'] = md5(time());
    $members['date'] = time();
    $members['members'] = [];
    foreach($_POST['members'] as $key => $member){
        if(gettype($member) != 'string'){
            array_push($members['members'], $member);
        }
    }
    $members['cantMember'] = count($members['members']);
    $members['delete'] = false;
    $members['clanName'] = $_POST['clan'];
    $members['badgeUrls'] = $_POST['badgeUrls'];
    $members['description'] = $_POST['description'];
    $listWar->setList($members);
    $activity->setActivity([
        "title" => "Nueva Lista de Guerra",
        "description" => "El usuario " . Session::getUsername() . " creo una lista de guerra.",
        "action" => "register"
    ]);
    $notification->setNotification([
        "title" => "Lista de Guerra",
        "description" => Session::getUsername() . ' a creado una nueva lista de guerra de ' . $members['cantMember'] . ' integrantes.',
        "to" => 'ALL'
    ]);
    echo '{"status": true,' . '"answer": "' . $members['id'] . '"}';
}else{
    echo '{"status": true}';
}