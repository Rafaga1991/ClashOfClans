<?php

include '../load.php';

if(isset($_POST['idUser']) && isset($_POST['idPublication'])){
    $answer = $publication->likePublication([
        "user" => $_POST['idUser'],
        "publication" => $_POST['idPublication']
    ]);

    if($answer && $_POST['idUserPublication'] != Session::getUserId()){
        $notification->setNotification([
            "title" => "Publicación",
            "description" => "A " . Session::getUsername() ." le gusto tu publicación.",
            "to" => $_POST['idUserPublication']
        ]);
    }
}elseif(isset($_POST['idPublication']) && isset($_POST['userid'])){
    $publication->delPublication($_POST['idPublication']);
    $message = 'Eliminaste una publicación.';

    if($_POST['userid'] != Session::getUserId()){
        $message = "Un administrador eliminó tu publicación.";
    }

    $notification->setNotification([
        "title" => "Publicación Eliminida",
        "description" => $message,
        "to" => $_POST['userid']
    ]);
}elseif(isset($_POST['idCommentary']) && isset($_POST['idPublication']) && isset($_POST['commentary'])){
    echo json_encode($publication->setCommentary($_POST['idPublication'], $_POST['idCommentary'], $_POST['commentary']));
}