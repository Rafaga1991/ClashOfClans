<?php

class Option extends Connection{
    private $table;

    public function __construct(){
        parent::__construct();
        $this->table = 'useroption';
        if(!parent::tableExists($this->table)){
            parent::execNoQuery("CREATE TABLE $this->table(
                id$this->table INTEGER(10) NOT NULL PRIMARY KEY AUTO_INCREMENT,
                idUser$this->table INTEGER(10) NOT NULL,
                clanTag$this->table VARCHAR(15) NOT NULL,
                playerTag$this->table VARCHAR(15) NOT NULL,
                colorPage$this->table VARCHAR(15) NOT NULL DEFAULT '#5e72e4',
                date$this->table TIMESTAMP DEFAULT NOW()
            )");
        }
    }

    public function setOption(int $idUser, array $tag){
        parent::execNoQuery("INSERT INTO $this->table(idUser$this->table,clanTag$this->table,playerTag$this->table) VALUES('$idUser', '{$tag['clan']}', '{$tag['player']}')");
    }

    public function getOption(string $idUser){
        return parent::getData("SELECT * FROM $this->table WHERE md5(idUser$this->table) = '$idUser'")[0];
    }

    public function upOption(array $option){
        parent::execNoQuery("UPDATE 
                $this->table 
            SET 
                clanTag$this->table='{$option['clanTag']}',
                colorPage$this->table='{$option['color']}',
                dateuseroption=NOW()
            WHERE idUser$this->table={$option['idUser']}
        ");
    }

    public function existsTag(string $tag):bool{
        return count(parent::getData("SELECT * FROM $this->table WHERE playerTaguseroption='$tag'")) > 0;
    }
}