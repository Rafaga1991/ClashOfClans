<?php

include '../load.php';

if(isset($_POST['sql'])){
    echo $request->requestSQLCode($_POST['sql']);
}