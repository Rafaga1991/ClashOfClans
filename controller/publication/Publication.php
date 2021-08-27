<?php

class Publication extends FileDB
{
    private $table;
    private $tablelike;
    private $tablecomentary;
    private $locationIMG;

    public function __construct($locationIMG = null)
    {
        parent::__construct();

        $this->table = 'publication';
        $this->tablelike = "like$this->table";
        $this->tablecomentary = "commentary$this->table";
        $this->locationIMG = $locationIMG;

        if (!parent::tableExists($this->table)) {
            parent::execNoQuery("CREATE TABLE $this->table(
                idPublication INTEGER(10) PRIMARY KEY AUTO_INCREMENT,
                idUser INTEGER(10) NOT NULL,
                descriptionPublication VARCHAR(500),
                datePublication TIMESTAMP DEFAULT NOW(),
                clanTag VARCHAR(15) NOT NULL,
                deletePublication BOOLEAN DEFAULT FALSE
            )");
        }

        if (!parent::tableExists($this->tablelike)) {
            parent::execNoQuery("CREATE TABLE $this->tablelike(
                idLike INTEGER(10) PRIMARY KEY AUTO_INCREMENT,
                idUser INTEGER(10) NOT NULL,
                idPublication INTEGER(10) NOT NULL,
                dateLike TIMESTAMP DEFAULT NOW(),
                deleteLike BOOLEAN DEFAULT FALSE
            )");
        }

        if (!parent::tableExists($this->tablecomentary)) {
            parent::execNoQuery("CREATE TABLE $this->tablecomentary(
                id$this->tablecomentary INTEGER(10) PRIMARY KEY AUTO_INCREMENT,
                idUser$this->tablecomentary INTEGER(10) NOT NULL,
                idPublication$this->tablecomentary INTEGER(10) NOT NULL,
                $this->tablecomentary VARCHAR(500) NOT NULL,
                idRequest$this->tablecomentary INTEGER(10) DEFAULT 0,
                date$this->tablecomentary TIMESTAMP DEFAULT NOW()
            )");
        }
    }

    private function imagesProfile()
    {
        $dir = opendir($this->locationIMG);
        $files = "{";
        while ($file = readdir($dir)) {
            if (strlen($file) > 2) {
                $file = explode('.', $file);
                $fileName = $file[0];
                $ext = $file[count($file) - 1];
                $path = "./$this->locationIMG /$fileName.$ext";
                $path = str_replace('../', '', $path);
                $path = str_replace(' ', '', $path);
                $files .= "\"{$fileName}\":\"{$path}\",";
            }
        }
        $files = substr($files, 0, (strlen($files) - 1));
        $files .= "}";
        $files = json_decode(trim($files), true);
        $files = $files == NULL ? [] : $files;

        return $files;
    }

    public function getPublicationSearch(string $search)
    {
        return parent::getData("SELECT 
                * 
            FROM 
                $this->table
            WHERE
                descriptionPublication LIKE '%$search%'
            AND
                NOT deletePublication
            AND
                clanTag='" . Session::getClanTag() . "'
        ");
    }

    public function getComments(int $idPublication, int $idComentary)
    {
        $comments = [];
        $comments['comments'] = parent::getData("SELECT 
                $this->tablecomentary.id$this->tablecomentary, $this->tablecomentary.idRequest$this->tablecomentary,
                $this->tablecomentary.$this->tablecomentary, u.username, u.imageurl, $this->tablecomentary.idUser$this->tablecomentary,
                $this->tablecomentary.idPublication$this->tablecomentary, $this->tablecomentary.date$this->tablecomentary
            FROM 
                $this->tablecomentary 
            INNER JOIN 
                user AS u 
            ON 
                u.idUser = $this->tablecomentary.idUser$this->tablecomentary
            WHERE
                idPublication$this->tablecomentary = $idPublication AND idRequest$this->tablecomentary = $idComentary
        ");

        if ($this->locationIMG != null) {
            $files = $this->imagesProfile();
        }

        foreach ($comments['comments'] as $key => $comment) {
            if (isset($files)) {

                $comments['comments'][$key]['comments'] = intval(parent::getData("SELECT 
                        count(*) AS cant 
                    FROM 
                        $this->tablecomentary 
                    WHERE 
                        idRequest$this->tablecomentary = {$comment['idcommentarypublication']} 
                    AND 
                        idPublication$this->tablecomentary = {$comment['idPublicationcommentarypublication']}
                ")[0][0]);
                $comments['comments'][$key]["date$this->tablecomentary"] = date('h:i A | M j', strtotime($comments['comments'][$key]["date$this->tablecomentary"]));
                $comments['comments'][$key]["idUser$this->tablecomentary"] = md5($comments['comments'][$key]["idUser$this->tablecomentary"]);
                $comments['comments'][$key]['imageurl'] = $files[$comment['imageurl']];
            }
        }

        $comments['cant'] = parent::getValue($this->tablecomentary, "count(id$this->tablecomentary)", "idPublication$this->tablecomentary", $idPublication);

        return $comments;
    }

    public function getLink(string $text, string $search = '#', $url = './?view=search')
    {
        $text = explode(' ', $text);
        $acum = "<form action='$url' method='post' onclick='this.submit()'>";
        foreach ($text as $value) {
            if (strpos(' ' . $value, $search) > 0) {
                $val = substr($value, strpos($value, $search));

                $acum .= "<input type='hidden' name='search' value='" . str_replace($search, '', $val) . "'>"
                    . substr($value, 0, strpos($value, $search))
                    . "<strong><a style='text-decoration: none;color: blue;cursor: pointer;'>$val</a></strong> ";
            } else {
                $acum .= $value . ' ';
            }
        }
        trim($acum);
        $acum .= "</form>";
        return $acum;
    }

    public function getCommentarySearch(string $search)
    {
        return parent::getData("SELECT 
                $this->tablecomentary.id$this->tablecomentary, $this->tablecomentary.$this->tablecomentary,
                $this->tablecomentary.date$this->tablecomentary, u.imageurl, u.username
            FROM 
                $this->tablecomentary
            INNER JOIN 
                user 
            AS 
                u
            ON 
                $this->tablecomentary.idUser$this->tablecomentary = u.idUser
            WHERE
                $this->tablecomentary.$this->tablecomentary LIKE '%$search%'
        ");
    }

    public function setCommentary(int $idPublication, int $idComentary, string $commentary)
    {
        parent::execNoQuery("INSERT INTO 
            $this->tablecomentary(
                idUser$this->tablecomentary, 
                idPublication$this->tablecomentary,
                idRequest$this->tablecomentary,
                $this->tablecomentary
            ) VALUES(
                " . Session::getUserId() . ", $idPublication, $idComentary, '$commentary'
            )
        ");

        $commentary =  parent::getData("SELECT 
                $this->tablecomentary.id$this->tablecomentary, $this->tablecomentary.idRequest$this->tablecomentary,
                $this->tablecomentary.$this->tablecomentary, u.username, u.imageurl, $this->tablecomentary.idUser$this->tablecomentary,
                $this->tablecomentary.idPublication$this->tablecomentary, $this->tablecomentary.date$this->tablecomentary
            FROM 
                $this->tablecomentary 
            INNER JOIN 
                user AS u 
            ON 
                u.idUser = $this->tablecomentary.idUser$this->tablecomentary
            WHERE
                id$this->tablecomentary = $this->lastID
        ")[0];

        $files = $this->imagesProfile();

        $commentary["date$this->tablecomentary"] = date('h:i A | M j', strtotime($commentary["date$this->tablecomentary"]));
        $commentary["idUser$this->tablecomentary"] = md5($commentary["idUser$this->tablecomentary"]);
        $commentary['imageurl'] = $files[$commentary['imageurl']];

        return $commentary;
    }

    public function newPublication(array $publication)
    {
        parent::execNoQuery("INSERT INTO 
                $this->table(idUser,descriptionPublication,clanTag)
            VALUES (
                " . Session::getUserId() . ",
                '{$publication['description']}',
                '" . Session::getClanTag() . "'
            )
        ");

        if (count($publication['file']) > 0) {
            parent::setFile($publication['file']);
        }
    }

    public function getPublications(string $idUser = null, string $filter = null): array
    {
        if ($filter == null) {
            $publications = parent::getData("SELECT 
                idPublication,idUser,descriptionPublication as description,datePublication as date 
            FROM 
                $this->table 
            WHERE 
                NOT deletePublication " . (($idUser != null) ? 'AND md5(idUser)="' . $idUser . '"' : '') . "
            AND 
                clanTag='" . Session::getClanTag() . "'
            ORDER BY idPublication DESC
            ");
        } else {
            $publications = parent::getData("SELECT 
                $this->table.idPublication,
                $this->table.idUser,
                $this->table.descriptionPublication as description,
                $this->table.datePublication as date 
            FROM 
                $this->table INNER JOIN file AS f 
            WHERE 
                NOT $this->table.deletePublication " . (($idUser != null) ? "AND md5($this->table.idUser)='" . $idUser . "'" : '') . " AND f.typeFile='$filter' AND $this->table.idPublication=f.idPublication ORDER BY $this->table.idPublication DESC");
        }
        foreach ($publications as $key => $publication) {
            $publications[$key]['file'] = parent::getFiles($publication['idPublication']);
            if (count($publications[$key]['file']) > 0) {
                $publications[$key]['file'] = $publications[$key]['file'][0];
            }
            $publications[$key]['user'] = parent::getData("SELECT username,imageurl FROM user WHERE idUser={$publication['idUser']}")[0];
            $publications[$key]['like'] = count(parent::getData("SELECT * FROM $this->tablelike WHERE idUser=" . Session::getUserId() . " AND idPublication={$publication['idPublication']} AND NOT deleteLike")) > 0;
            $publications[$key]['likes'] = count(parent::getData("SELECT * FROM $this->tablelike WHERE idPublication={$publication['idPublication']} AND NOT deleteLike"));
            $publications[$key]['commentary'] = $this->getComments($publication['idPublication'], 0);
        }
        return $publications;
    }

    public function likePublication(array $id)
    {
        if (count($id) > 0) {
            $likes = count(parent::getData("SELECT * FROM $this->tablelike WHERE idUser={$id['user']} AND idPublication={$id['publication']}"));
            if ($likes == 0) {
                parent::execNoQuery("INSERT INTO $this->tablelike(idUser,idPublication) VALUES({$id['user']},{$id['publication']})");
            } else {
                parent::execNoQuery("UPDATE $this->tablelike SET deleteLike= NOT deleteLike WHERE idUser={$id['user']} AND idPublication={$id['publication']}");
            }
            return $likes == 0;
        }

        return false;
    }

    public function delPublication(int $id)
    {
        parent::execNoQuery("UPDATE $this->table SET deletePublication=TRUE WHERE idPublication=$id AND clanTag='" . Session::getClanTag() . "'");
    }

    public function getCantFileByUser(string $idUser)
    {
        $image = parent::getData("SELECT COUNT(*) AS cant FROM $this->table INNER JOIN file AS f WHERE $this->table.idPublication=f.idPublication AND f.typeFile='image' AND md5($this->table.idUser)='$idUser' AND NOT $this->table.deletePublication")[0]['cant'];
        $video = parent::getData("SELECT COUNT(*) AS cant FROM $this->table INNER JOIN file AS f WHERE $this->table.idPublication=f.idPublication AND f.typeFile='video' AND md5($this->table.idUser)='$idUser' AND NOT $this->table.deletePublication")[0]['cant'];
        return [
            'image' => $image,
            'video' => $video
        ];
    }
}
