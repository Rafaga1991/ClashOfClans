<?php

class Activity extends Connection
{
    private $table;

    public function __construct()
    {
        parent::__construct();
        $this->table = 'activity';

        if (!parent::tableExists($this->table)) {
            parent::execNoQuery("CREATE TABLE $this->table(
                idActivity INTEGER(10) PRIMARY KEY AUTO_INCREMENT,
                titleActivity VARCHAR(100) NOT NULL,
                descriptionActivity VARCHAR(500) NOT NULL,
                actionActivity VARCHAR(50) NOT NULL,
                dateActivity TIMESTAMP DEFAULT NOW()
            )");
        }
    }

    public function getActivities(): array
    {
        $sql = "SELECT * FROM $this->table ORDER BY idActivity DESC";
        return parent::getData($sql, 'idActivity');
    }

    public function setActivity(array $activity)
    {
        $sql = "INSERT INTO $this->table(
            titleActivity,descriptionActivity,actionActivity
        ) VALUES(
            '{$activity['title']}',
            '{$activity['description']}',
            '{$activity['action']}'
        )";
        parent::execNoQuery($sql);
    }
}
