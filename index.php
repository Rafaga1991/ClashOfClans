<?php

header('Access-Control-Allow-Origin: *');

require_once ('vendor/autoload.php');
include './init.php';
include './controller/database/Connection.php';
include './controller/database/Request.php';
include './api/client/Client.php';
include './controller/user/Session.php';
include './controller/user/User.php';
include './controller/listWar/ListWar.php';
include './controller/activity/Activity.php';
include './controller/notification/Notification.php';
include './controller/publication/File.php';
include './controller/publication/Publication.php';
include './controller/chats/Chats.php';
include './controller/question/Question.php';
include './controller/option/Option.php';

$client = new Client();
$session = new Session();
$listWar = new ListWar();
$option = new Option();
$user = new User($option);
$activity = new Activity();
$notification = new Notification();
$publication = new Publication();
$chat = new Chat('controller/chats/messages');
$question = new Question();
$requestSQL = new Request();

$info = $client->getClan()->getClanInfo();
$warlog = $client->getClan()->getWarLog();
$currentWar = $client->getClan()->getCurrentWar();
$currentWarLeagueGroup = $client->getClan()->getCurrentWarLeagueGroup();
$listMembersWar = $listWar->getList();
$activities = $activity->getActivities();
$notifications = $notification->getNotifications();
$publications = $publication->getPublications();

$views = getFiles('view');
$etc = getFiles('etc');

// array of imagens
$img = [];
$img['labels'] = getFiles('assets/img/labels');
$img['th'] = getFiles('assets/img/th');
$img['war'] = getFiles('assets/img/war');
$img['profile'] = getFiles('assets/img/profile');
$img['theme'] = getFiles('assets/img/theme');
$img['publication'] = getFiles('assets/img/publication');
// end array

// Array of sound
$sound = [];
$sound = getFiles('assets/sound');
// end array

// Array of video
$video = [];
$video = getFiles('assets/video');
// end array

// Array of json
$json = getFiles('json');
$json['members'] = getFiles('json/members');
//end array

// Request post and get
$request = [];
$request['post'] = getFiles('request/post');
$request['get'] = getFiles('request/get');

// Leader of clan
$leader = [];

$tooltip = getFiles('view/tooltips');

$view = 'login';

if(Session::Auth()){
    // Obteniendo información de jugador
    if(!isset($_SESSION['player'])){
        $_SESSION['player'] = $client->getPlayer(Session::getPlayerTag())->getPlayerInfo();
        $_SESSION['role'] = $_SESSION['player']['role'];
    }
    // Revizando la vista
    $view = 'publication';
    if(isset($_GET['view'])){
        if(!in_array($_GET['view'], ['login', 'register', 'home', 'changepass'])){
            $view = $_GET['view'];
        }
    }
    $view = isset($views[$view])? $view : '404';
}else{
    $view = isset($_GET['view'])? $_GET['view'] : $view;
    $view = in_array($view, ['login', 'register', 'changepass'])? $view : 'login';
}

$url = (isset($_SERVER['HTTPS'])? (($_SERVER['HTTPS'] == 'on')? 'https://':'http://'):'http://') . $_SERVER['HTTP_HOST'];

if(isset($info['memberList'])){
    $cantDonations = [];
    foreach($info['memberList'] as $key => $member){
        if($member['donations'] > 0){
            $cantDonations[$key] = $member['donations'];
        }
        if(strtolower($member['role']) == 'leader'){
            $leader = $member;
        }
    }
    // Revirtiendo arreglos
    rsort($cantDonations);
    krsort($listMembersWar);
    // Fin
    $kingDonation = [];
    foreach($cantDonations as $key => $cant){
        if($key > 3){
            break;
        }
        foreach($info['memberList'] as $member){
            if($cant == $member['donations']){
                array_push($kingDonation, $member);
                break;
            }
        }
    }
    // Verificando existencia de id en profile
    include $etc['profile'];
    // Limitando notificationes
    include $etc['notification'];
    // Incluyendo respuesta de publicación
    include $etc['publication'];
    // Verificando los miembros del clan
    include $etc['membersout'];
    
    // Incluyendo paginas
    if($view != 'featured'){
        include $views['home'];
    }elseif(Session::Auth()){
        include $views[$view];
    }else{
        reloadPage();
    }   
}else{
    include $views['maintenance'];
}