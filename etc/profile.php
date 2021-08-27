<?php

if ($view == 'profile') {
    if (isset($_GET['id'])) {
        $_GET['id'] = getPlaneText($_GET['id']);
        $userData = $user->getUser($_GET['id']);
        if (count($userData) == 0) {
            header('Location: ./?view=publication');
        }
        $publications = $publication->getPublications($_GET['id'],(isset($_GET['publication'])?$_GET['publication']:null));

        if (isset($_POST['username']) && isset($_POST['name']) && isset($_POST['lastname']) && isset($_POST['mail']) && isset($_POST['password']) && isset($_POST['rpassword'])) {
            foreach($_POST as $key => $value){
                $_POST[$key] = getPlaneText($value);
            }
            if ($_POST['password'] == $_POST['rpassword']) {
                if (!$user->isUser($_POST['username'])) {
                    $_POST['id'] = $_GET['id'];
                    if (isset($_FILES['image'])) {
                        $type = explode('/', $_FILES['image']['type']);
                        if ($type[0] == 'image') {
                            $name = md5(time() . $_GET['id']);
                            $loc = "{$img['profile']['NAME_DIR']}/$name.{$type[1]}";
                            $_POST['image'] = $name;
                            move_uploaded_file($_FILES['image']['tmp_name'], $loc);
                            $_SESSION['image'] = $name;
                            if ($_POST['img_old'] != 'default') {
                                unlink($img['profile'][$_POST['img_old']]);
                            }
                        } else {
                            $message = "Archivo no valido!";
                        }
                    }
                    $user->updateUser($_POST);
                    $activity->setActivity([
                        "title" => "Actulización de Perfil",
                        "description" => "El usuario " . Session::getUsername() . " actualizó su perfil.",
                        "action" => "update"
                    ]);
                    $notification->setNotification([
                        "title" => "Actualización",
                        "description" => "Tu perfil fue actualizado con exito!",
                        "to" => Session::getUserId()
                    ]);
                    if (!empty($_POST['password']) || !empty($_POST['username'])) {
                        header("Location: {$request['get']['logout']}");
                    } else {
                        header("Location: ./?view=$view&id={$_GET['id']}");
                    }
                } else {
                    $message = "El nombre de usuario existe!";
                }
            } else {
                $message = "Las claves no coinciden.";
            }
        }
    } else {
        header('Location: ./?view=publication');
    }
}
