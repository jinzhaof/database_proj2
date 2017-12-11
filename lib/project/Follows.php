<?php
/**
 * Created by PhpStorm.
 * User: Zhaofeng
 * Date: 12/11/17
 * Time: 4:15 AM
 */

namespace project;


class Follows extends Table
{
    public function __construct(Site $site) {
        parent::__construct($site, "follow");
    }
    public function get($id) {
        $follows = array();
        $sql =<<<SQL
SELECT follow from $this->tableName
where follower=?
SQL;
        $pdo = $this->pdo();
        $statement = $pdo->prepare($sql);

        $statement->execute(array($id));
        if($statement->rowCount() === 0) {
            return null;
        }
        while($row = $statement->fetch(\PDO::FETCH_ASSOC)){
            array_push($follows,$row["follow"]);
        }
        return $follows;
    }
    public function add($follower,$follow,$ftime){
        // Add a record to the user table
        $sql = <<<SQL
INSERT INTO $this->tableName(follower,follow, ftime)
values(?, ?, ?)
SQL;

        $statement = $this->pdo()->prepare($sql);
        $statement->execute(array($follower,$follow,$ftime));
        return $this->exists($follower,$follow);
    }

    public function exists($follower,$follow){
        $sql =<<<SQL
SELECT ftime from $this->tableName
where follower=? and follow =?
SQL;
        $statement = $this->pdo()->prepare($sql);
        $statement->execute(array($follower,$follow));
        if($statement->rowCount() === 0) {
            return false;
        }else{
            return true;
        }
    }

    public function delete($follower,$follow){
        $sql = <<<SQL
DELETE FROM $this->tableName
WHERE follower=? and follow =?
SQL;
        $pdo = $this->pdo();
        $statement = $pdo->prepare($sql);
        $statement->execute(array($follower,$follow));
        if($this->exists($follower,$follow)){
            return false;
        }
        return true;
    }

}