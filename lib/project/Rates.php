<?php
/**
 * Created by PhpStorm.
 * User: Zhaofeng
 * Date: 12/11/17
 * Time: 4:59 AM
 */

namespace project;


class Rates extends Table
{
    public function __construct(Site $site) {
        parent::__construct($site, "rate");
    }
    public function get($username,$tid) {
        $likes = array();
        $sql =<<<SQL
SELECT score from $this->tableName
where username=? and TrackId = ?
SQL;
        $pdo = $this->pdo();
        $statement = $pdo->prepare($sql);

        $statement->execute(array($username,$tid));
        if($statement->rowCount() === 0) {
            return null;
        }
        $row = $statement->fetch(\PDO::FETCH_ASSOC);
        return $row['score'];

    }
//    public function add($username,$tid,$score,$rtime){
//        $sql = <<<SQL
//INSERT INTO $this->tableName(username,TrackId, score,rtime)
//values(?, ?, ?, ?)
//SQL;
//        $statement = $this->pdo()->prepare($sql);
//        $statement->execute(array($username,$tid,$score,$rtime));
//        return $this->exists($username,$tid);
//
//    }
    public function update($username,$tid,$score,$rtime){
        // Ensure we have no duplicate email address
        if($this->exists($username,$tid)) {
            $sql =<<<SQL
UPDATE $this->tableName
SET score = ?, rtime = ?
WHERE username=? and TrackId = ?
SQL;
            $statement = $this->pdo()->prepare($sql);
            $statement->execute(array($score,$rtime,$username,$tid));
            return true;
        }
        else{
            // Add a record to the user table
            $sql = <<<SQL
INSERT INTO $this->tableName(username,TrackId, score,rtime)
values(?, ?, ?,?)
SQL;
            $statement = $this->pdo()->prepare($sql);
            $statement->execute(array($username,$tid,$score,$rtime));

            return $this->exists($username,$tid);

        }




    }

    public function exists($username,$tid){
        $sql =<<<SQL
SELECT score from $this->tableName
where username=? and TrackId =?
SQL;
        $statement = $this->pdo()->prepare($sql);
        $statement->execute(array($username,$tid));
        if($statement->rowCount() === 0) {
            return false;
        }else{
            return true;
        }
    }


}