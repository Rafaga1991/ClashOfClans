<?php
if(Session::Auth()){
    if (count($notifications['notifications']) > 5 && $view != 'notification') {
        $cont = 0;
        foreach($notifications['notifications'] as $key => $value){
            if($cont >= 5){
                unset($notifications['notifications'][$key]);
            }
            $cont++;
        }
    } elseif ($view == 'notification') {
        $allView = [];
        foreach($notifications['notifications'] as $key => $value){
            array_push($allView, [
                "idNotification" => $key,
                "idUser" => Session::getUserId()
            ]);
        }
        $notification->setToSee($allView);
        $notifications = $notification->getNotifications();
    }
}
