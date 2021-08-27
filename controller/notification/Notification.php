<?php

class Notification extends Connection
{
    private $table;
    private $tableView;

    public function __construct()
    {
        parent::__construct();
        $this->table = 'notification';
        $this->tableView = $this->table . 'view';

        if(!parent::tableExists($this->table)){
            parent::execNoQuery("CREATE TABLE $this->table(
                idNotification INTEGER(10) PRIMARY KEY AUTO_INCREMENT,
                titleNotification VARCHAR(100) NOT NULL,
                descriptionNotification VARCHAR(500) NOT NULL,
                toNotification VARCHAR(10) NOT NULL,
                dateNotification TIMESTAMP DEFAULT NOW()
            )");
        }

        if(!parent::tableExists($this->tableView)){
            parent::execNoQuery("CREATE TABLE $this->tableView(
                idView INTEGER(10) PRIMARY KEY AUTO_INCREMENT,
                idNotification INTEGER(10) NOT NULL,
                idUser INTEGER(10) NOT NULL
            )");
        }
    }

    public function setNotification(array $notification)
    {
        parent::execNoQuery(
            "INSERT INTO 
                $this->table(titleNotification,descriptionNotification,toNotification)
            VALUES(
                '{$notification['title']}',
                '{$notification['description']}',
                '{$notification['to']}'
            )"
        );
    }

    public function getNotifications()
    {
        $notification = [];
        $notification['notifications'] = parent::getData(
            "SELECT * FROM $this->table WHERE toNotification='"
                . Session::getUserId() . "'"
                . (Session::superAdmin() ? ' OR toNotification=\'sAdmin\'' : '')
                . " OR toNotification='ALL' ORDER BY idNotification DESC",
            "idNotification"
        );
        $viewNotification = parent::getData("SELECT * FROM $this->tableView WHERE idUser=" . Session::getUserId(), 'idView');
        $notification['toSee'] = count($notification['notifications']) - count($viewNotification);
        return $notification;
    }

    public function getNotificationSearch(string $search)
    {
        return parent::getData("SELECT 
                * 
            FROM 
                $this->table
            WHERE
                (toNotification='ALL' 
            OR
                toNotification='" . Session::getUserid() . "'" . (Session::superAdmin() ? ' OR toNotification=\'sAdmin\'' : '') . ")
            AND 
                (descriptionNotification LIKE '%$search%' 
            OR
                titleNotification LIKE '%$search%')
        ");
    }

    private function exists(array $data): bool
    {
        $sql = "SELECT * FROM $this->tableView WHERE idNotification={$data['idNotification']} AND idUser={$data['idUser']}";
        return count(parent::getData($sql, 'idView')) > 0;
    }

    public function setToSee(array $see)
    {
        foreach ($see as $value) {
            if (!$this->exists($value)) {
                parent::execNoQuery("
                    INSERT INTO 
                        $this->tableView(idNotification,idUser)
                    VALUES(
                        {$value['idNotification']},
                        {$value['idUser']}
                    )
                ");
            }
        }
    }
}
