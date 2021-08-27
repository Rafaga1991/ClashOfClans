<?php

class User extends Connection
{
    private $table;
    private $view;
    private $option;

    function __construct($option = null)
    {
        parent::__construct();
        $this->option = $option;
        $this->table = "user";

        if (!parent::tableExists($this->table)) {
            parent::execNoQuery("CREATE TABLE $this->table(
                idUser INTEGER(10) PRIMARY KEY AUTO_INCREMENT, 
                imageUrl VARCHAR(500) DEFAULT 'default',
                nameUser VARCHAR(30) NOT NULL,
                lastName VARCHAR(30) NOT NULL,
                email VARCHAR(30) NOT NULL,
                username VARCHAR(30) NOT NULL,
                passwordUser VARCHAR(50) NOT NULL,
                tocken VARCHAR(50),
                active BOOLEAN DEFAULT FALSE,
                privileges BOOLEAN DEFAULT FALSE,
                deleteUser BOOLEAN DEFAULT FALSE
            );");
        }

        if (!parent::tableExists('ipLocation')) {
            parent::execNoQuery("CREATE TABLE ipLocation(
                idIpLocation INTEGER(10) PRIMARY KEY AUTO_INCREMENT,
                ip VARCHAR(30) NOT NULL,
                idUser INTEGER(10) NOT NULL
            )");
        }

        /*$this->view = 'view_' . $this->table;

        if (!parent::tableExists($this->view)) {
            parent::execNoQuery("CREATE VIEW $this->view AS 
            SELECT 
                $this->table.idUser, $this->table.imageUrl, $this->table.nameUser, 
                $this->table.lastName, $this->table.email, $this->table.username, 
                $this->table.passwordUser, $this->table.tocken, $this->table.active, 
                $this->table.privileges, il.ip
            FROM 
                $this->table INNER JOIN ipLocation AS il
            ON
                $this->table.idUser = il.idUser
            WHERE
                NOT $this->table.deleteUser");
        }*/
    }

    public function getUserSearch(string $search)
    {
        return parent::getData("SELECT 
                * 
            FROM 
                $this->table
            WHERE
                (nameUser LIKE '%$search%' 
            OR
                lastName LIKE '%$search%' 
            OR
                email LIKE '%$search%' 
            OR
                username LIKE '%$search%')
            AND
                NOT deleteUser
        ");
    }

    public function isUser(string $username): bool
    {
        $sql = "SELECT * FROM $this->table WHERE username='$username' OR email='$username'";
        return count(parent::getData($sql, 'idUser')) > 0;
    }

    public function updateUser(array $user)
    {
        $sql = "UPDATE 
            $this->table 
        SET 
            nameUser='{$user['name']}',
            lastName='{$user['lastname']}',
            imageUrl=" . (empty($user['image']) ? 'imageUrl' : ("'" . $user['image'] . "'")) . ",
            passwordUser=" . (empty($user['password']) ? 'passwordUser' : ("'" . md5($user['password']) . "'")) . ",
            email='{$user['mail']}',
            username=" . (empty($user['username']) ? 'username' : ("'" . $user['username'] . "'")) . "
        WHERE md5(idUser)='{$user['id']}'";
        parent::execNoQuery($sql);
    }

    public function addUser(array $user)
    {
        $sql = "INSERT INTO $this->table(nameUser,lastName,email,username,passwordUser,tocken) VALUES('"
            . $user['name'] . "','"
            . $user['lastName'] . "','"
            . $user['email'] . "','"
            . $user['username'] . "','"
            . md5($user['password']) . "','"
            . $user['tocken'] . "')";
        parent::execNoQuery($sql);
        $sql = "INSERT INTO ipLocation(ip,idUser) VALUES('{$_SERVER['REMOTE_ADDR']}', $this->lastID)";
        $this->option->setOption(
            $this->lastID,
            [
                'clan' => $user['clanTag'],
                'player' => $user['playerTag']
            ]
        );
        parent::execNoQuery($sql);
    }

    private function change(string $id, string $columName)
    {
        $sql = "UPDATE $this->table SET __column__ = NOT __column__ WHERE MD5(idUser) = '$id'";
        $sql = str_replace('__column__', $columName, $sql);
        parent::execNoQuery($sql);
    }

    public function changeActive(string $id)
    {
        $this->change($id, 'active');
    }

    public function changeAdmin(string $id)
    {
        $this->change($id, 'privileges');
    }

    public function getUsers(): array
    {
        return parent::getData(
            "SELECT 
                $this->table.idUser, $this->table.imageUrl, $this->table.nameUser, 
                $this->table.lastName, $this->table.email, $this->table.username, 
                $this->table.passwordUser, $this->table.tocken, $this->table.active, 
                $this->table.privileges, il.ip
            FROM 
                $this->table INNER JOIN ipLocation AS il
            ON
                $this->table.idUser = il.idUser
            WHERE
                NOT $this->table.deleteUser",
            'idUser'
        );
    }

    public function getUser(string $id): array
    {
        $data = parent::getData("SELECT 
            $this->table.idUser, $this->table.imageUrl, $this->table.nameUser, 
            $this->table.lastName, $this->table.email, $this->table.username, 
            $this->table.passwordUser, $this->table.tocken, $this->table.active, 
            $this->table.privileges, il.ip
        FROM 
            $this->table INNER JOIN ipLocation AS il
        ON
            $this->table.idUser = il.idUser
        WHERE
            NOT $this->table.deleteUser AND md5($this->table.idUser)='$id'"
        );
        return (count($data) > 0 ? $data[0] : $data);
    }

    public function verification(string $code): bool
    {
        $sql = "UPDATE $this->table SET tocken='', active=TRUE WHERE tocken='" . md5($code) . "' OR tocken='$code'";
        $query = "SELECT * FROM $this->table WHERE tocken='$code' OR tocken='" . md5($code) . "'";
        if (count(parent::getData($query, 'idUser')) > 0) {
            parent::execNoQuery($sql);
            return true;
        } else {
            return false;
        }
    }

    public function gTocken(string $username): array
    {
        $tocken = md5($username . rand(0, 100));
        $sql = "UPDATE $this->table SET tocken='$tocken' WHERE username='$username' OR email='$username'";
        parent::execNoQuery($sql);
        $data = parent::getValue($this->table, 'nameUser', 'tocken', $tocken);
        return array(
            "name"      =>  $data,
            "tocken"    =>  $tocken
        );
    }

    public function changePass(string $tocken, string $password)
    {
        $password = md5($password);
        $sql = "UPDATE $this->table SET passwordUser='$password', tocken='' WHERE tocken='$tocken'";
        parent::execNoQuery($sql);
    }

    public function isTocken(string $tocken)
    {
        $sql = "SELECT * FROM $this->table WHERE tocken='$tocken'";
        return count(parent::getData($sql, 'idUser')) > 0;
    }

    public function isAccess(string $username, string $password): bool
    {
        $password = md5($password);
        $sql = "SELECT * FROM $this->table WHERE (username='$username' OR email='$username') AND passwordUser='$password'";
        $data = parent::getData($sql, 'idUser');
        if (count($data) == 1) {
            foreach ($data as $key => $value) {
                if ($value['active']) {
                    $_SESSION['idUser'] = $value['idUser'];
                    $_SESSION['image'] = $value['imageUrl'];
                    $_SESSION['username'] = $value['username'];
                    $_SESSION['email'] = $value['email'];
                    $_SESSION['privileges'] = $value['privileges'];
                    $_SESSION['lastName'] = $value['lastName'];
                    $_SESSION['nameUser'] = $value['nameUser'];
                    $_SESSION['tag']['clan'] = parent::getValue('useroption', 'clanTaguseroption', 'idUseruseroption', $value['idUser']);
                    $_SESSION['tag']['player'] = parent::getValue('useroption', 'playerTaguseroption', 'idUseruseroption', $value['idUser']);
                    $_SESSION['color'] = parent::getValue('useroption', 'colorPageuseroption', 'idUseruseroption', $value['idUser']);
                    $_SESSION['AUTH'] = true;
                } else {
                    $data = [];
                }
                break;
            }
        }
        return count($data) == 1;
    }
}
