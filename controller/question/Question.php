<?php

class Question extends Connection{
    private $table;

    public function __construct()
    {
        parent::__construct();
        $this->table = 'question';
        if(!parent::tableExists($this->table)){
            parent::execNoQuery("CREATE TABLE $this->table(
                id$this->table INTEGER(10) PRIMARY KEY AUTO_INCREMENT,
                $this->table VARCHAR(500) NOT NULL,
                answer$this->table VARCHAR(500),
                idUser$this->table INTEGER(10) NOT NULL,
                date$this->table TIMESTAMP DEFAULT NOW(),
                delete$this->table BOOLEAN DEFAULT FALSE
            )");
        }
    }

    public function newQuestion(string $question){
        parent::execNoQuery("INSERT INTO $this->table($this->table, idUser$this->table) VALUES('$question'," . Session::getUserId() . ")");
    }

    public function getQuestionSearch(string $text){
        return parent::getData("SELECT * FROM $this->table WHERE question LIKE '%$text%' OR answerquestion LIKE '%$text%'");
    }

    public function getQuestions(){
        return parent::getData("SELECT 
                $this->table.id$this->table, $this->table.$this->table, $this->table.answer$this->table, 
                $this->table.idUser$this->table, $this->table.date$this->table, u.imageurl, u.username
            FROM 
                $this->table 
            INNER JOIN user AS u
            ON $this->table.idUser$this->table = u.idUser
            WHERE 
                NOT delete$this->table
        ");
    }

    public function updateQuestion(int $idQuestion, string $answer){
        parent::execNoQuery("UPDATE $this->table SET answerquestion='$answer' WHERE idquestion=$idQuestion");
    }
}