<?php

include '../load.php';

$access = "false";

if(isset($_POST['codeVerification'])){
    $ans = $user->verification($_POST['codeVerification']);
    $access = $ans?"true":"false";
    if($ans){
        $activity->setActivity([
            "title" => "Verificación de Correo Electrónico",
            "description" => "Un usuario verificó su correo electrónico.",
            "action" => "register"
        ]);
    }
}

echo '{"status":' . $access . '}';