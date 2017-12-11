<?php
/**
 * Created by PhpStorm.
 * User: Zhaofeng
 * Date: 12/11/17
 * Time: 4:22 AM
 */

namespace project;


class Love extends Table
{
    public function __construct(Site $site) {
        parent::__construct($site, "love");
    }
    public function get($username) {
        $likes = array();
        $sql =<<<SQL
SELECT ArtistTitle from $this->tableName
where username=?
SQL;
        $pdo = $this->pdo();
        $statement = $pdo->prepare($sql);

        $statement->execute(array($username));
        if($statement->rowCount() === 0) {
            return null;
        }
        while($row = $statement->fetch(\PDO::FETCH_ASSOC)){
            array_push($likes,$row['ArtistTitle']);
        }
        return $likes;
    }
    public function add($username,$aname,$ltime){
        // Add a record to the user table
        $sql = <<<SQL
INSERT INTO $this->tableName(username,ArtistTitle, ltime)
values(?, ?, ?)
SQL;

        $statement = $this->pdo()->prepare($sql);
        $statement->execute(array($username,$aname,$ltime));
        return $this->exists($username,$aname);
    }

    public function exists($username,$aname){
        $sql =<<<SQL
SELECT ltime from $this->tableName
where username=? and ArtistTitle =?
SQL;
        $statement = $this->pdo()->prepare($sql);
        $statement->execute(array($username,$aname));
        if($statement->rowCount() === 0) {
            return false;
        }else{
            return true;
        }
    }

    public function delete($username,$aname){
        $sql = <<<SQL
DELETE FROM $this->tableName
WHERE username=? and ArtistTitle = ?
SQL;
        $pdo = $this->pdo();
        $statement = $pdo->prepare($sql);
        $statement->execute(array($username,$aname));
        if($this->exists($username,$aname)){
            return false;
        }
        return true;
    }

}