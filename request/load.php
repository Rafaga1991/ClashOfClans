<?php

header('Access-Control-Allow-Origin: *');
require_once '../../vendor/autoload.php';
include '../../controller/listWar/ListWar.php';
include '../../controller/database/Connection.php';
include '../../controller/database/Request.php';
include '../../controller/user/User.php';
include '../../controller/user/Session.php';
include '../../controller/activity/Activity.php';
include '../../controller/notification/Notification.php';
include '../../controller/publication/File.php';
include '../../controller/publication/Publication.php';
include '../../controller/chats/Chats.php';
require_once '../../vendor/autoload.php';

use Mpdf\Mpdf;

$listWar = new ListWar();
$mpdf = new Mpdf(array('enable_remote' => true));
$user = new User();
$activity = new Activity();
$notification = new Notification();
$publication = new Publication('../../assets/img/profile');
$chat = new Chat('../../controller/chats/messages', '../../assets/img/profile');
$request = new Request();
