<?php

if (isset($_POST['txtDescriptionPublication'])) {
    $data = [
        "description" => getPlaneText($_POST['txtDescriptionPublication']),
        "file" => []
    ];

    if (isset($_FILES['file'])) {
        $name = md5((Session::getUserId() . '_' . rand(0, 100)) . $_FILES['file']['name']);
        $type = explode('/', $_FILES['file']['type']);
        $path = '';

        if ($type[0] == 'image') {
            $path .= $img['publication']['NAME_DIR'] . "/$name." . $type[1];
        } elseif ($type[0] == 'video') {
            $path .= $video['NAME_DIR'] . "/$name." . $type[1];
        }

        if (!empty($path) && $_FILES['file']['size'] <= 5242880) {
            move_uploaded_file($_FILES['file']['tmp_name'], $path);
            $data['file'] = [
                [
                    'name' => $name,
                    'type' => $type[0]
                ]
            ];
        }
    }

    if (isset($_POST['txtUrl']) && empty($path)) {
        if(!empty($_POST['txtUrl'])){
            $value = parse_url($_POST['txtUrl']);
            $fileName = '';
            $type = '';
            if ($value['host'] == 'youtu.be') {
                $fileName = explode('/', $value['path'])[1];
                $type = 'youtube';
            } elseif ($value['host'] == 'www.tiktok.com') {
                $fileName = $value['path'];
                $type = 'tiktok';
            }
            $data['file'] = [
                [
                    'name' => $fileName,
                    'type' => $type
                ]
            ];
        }
    }

    if (!empty($data['description']) || count($data['file']) > 0) {
        $publication->newPublication($data);
        $activity->setActivity([
            "title" => "Nueva Publicación",
            "description" => "El usuario " . Session::getUsername() . " realizo una publicación.",
            "action" => "register"
        ]);
        $notification->setNotification([
            "title" => "Publicación",
            "description" => Session::getUsername() . " realizo una publicación.",
            "to" => 'ALL'
        ]);
        reloadPage();
    }
}
