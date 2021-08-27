<?php

include '../load.php';

if(isset($_POST['txtMessage'])){
    echo $chat->newMessage($_POST['txtMessage']);
}