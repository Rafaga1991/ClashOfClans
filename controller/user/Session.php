<?php

session_start();

class Session{
    public static function Auth():bool{
        return isset($_SESSION['AUTH'])?$_SESSION['AUTH']:false;
    }

    public static function Admin():bool{
        return isset($_SESSION['privileges'])?$_SESSION['privileges']:false;
    }

    public static function superAdmin():bool{
        return in_array(Session::getUserId(), [1]);
    }

    public static function getImage():string{
        return isset($_SESSION['image'])?$_SESSION['image']:'';
    }

    public static function getUsername():string{
        return isset($_SESSION['username'])?$_SESSION['username']:'';
    }

    public static function getName():string{
        return isset($_SESSION['nameUser'])?$_SESSION['nameUser']:'';
    }
    
    public static function getLastName():string{
        return isset($_SESSION['lastName'])?$_SESSION['lastName']:'';
    }

    public static function getUserId():int{
        return isset($_SESSION['idUser'])?$_SESSION['idUser']:0;
    }
    
    public static function getColorPage():string{
        return isset($_SESSION['color'])?$_SESSION['color']:'#5e72e4';
    }

    public static function getClanTag():string{
        return isset($_SESSION['tag']['clan'])?$_SESSION['tag']['clan']:'';
    }

    public static function getPlayerTag():string{
        return isset($_SESSION['tag']['player'])?$_SESSION['tag']['player']:'';
    }

    public static function getPlayer():array{
        return isset($_SESSION['player'])?$_SESSION['player']:null;
    }

    public static function isPrivilegedInClan():bool{
        return isset($_SESSION['role'])?(in_array(strtolower($_SESSION['role']), ['coleader', 'leader'])):false;
    }

    public static function getRole(){
        return isset($_SESSION['role'])?$_SESSION['role']:null; 
    }

    public static function logout(){
        unset($_SESSION);
        session_destroy();
    }
}