<?php

class Connection{
    private $param;
    protected $lastID;

    function __construct(){
        $this->param = include 'param.php';
    }

    private function getConnection(){
        return mysqli_connect($this->param['host'], $this->param['username'], $this->param['password'], $this->param['dbname']);
    }

    protected function tableExists(string $table){
        $tables = $this->getData("SHOW TABLES");
        foreach($tables as $tableName){
            if(strtolower($tableName[0]) == strtolower($table)){
                return true;
            }
        }
        return false;
    }

    protected function execNoQuery($sql){
        $link = $this->getConnection();
        if(mysqli_query($link, $sql)){
            $this->lastID = mysqli_insert_id($link);
            mysqli_close($link);
        }else{
            echo mysqli_error($link) . '<br><br>';
        }
    }

    private function execQuery($sql){
        $link = $this->getConnection();
        $query = mysqli_query($link, $sql);
        if(mysqli_close($link)){
            return $query;
        }else{
            return null;
        }
    }
    
    protected function getValue($tableName, $nameParam1, $nameParam2, $valueSearh){
        $sql = "SELECT $nameParam1 FROM $tableName WHERE $nameParam2='$valueSearh'";
        $result = $this->execQuery($sql);
        return mysqli_fetch_array($result)[$nameParam1];
    }
    
    protected function getData($sql, $idColumn=null){
        $result = $this->execQuery($sql);
        $data = [];
        $cont = 0;
        while($row = mysqli_fetch_array($result)){
            if($idColumn == null){
                $data[$cont] = $row;
                $cont++;
            }else{
                $data[$row[$idColumn]] = $row;
            }
        }
        return $data;
    }
}