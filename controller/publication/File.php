<?php

class FileDB extends Connection{
    private $table;

    public function __construct(){
        parent::__construct();
        $this->table = 'file';

        parent::execNoQuery("CREATE TABLE IF NOT EXISTS $this->table(
            idFile INTEGER(10) PRIMARY KEY AUTO_INCREMENT,
            idPublication INTEGER(10) NOT NULL,
            nameFile VARCHAR(150) NOT NULL,
            typeFile VARCHAR(20) NOT NULL
        )");
    }

    protected function setFile(array $files){
        foreach($files as $file){
            parent::execNoQuery("INSERT INTO 
                    $this->table(idPublication,nameFile,typeFile) 
                VALUES(
                    $this->lastID,
                    '{$file['name']}',
                    '{$file['type']}'
                )
            ");
        }
    }

    protected function getFiles(int $idPublication):array{
        return parent::getData("SELECT nameFile AS name, typeFile AS type FROM $this->table WHERE idPublication=$idPublication ORDER BY idFile DESC");
    }
}