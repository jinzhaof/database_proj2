<?php
/**
 * Created by PhpStorm.
 * User: Zhaofeng
 * Date: 12/11/17
 * Time: 2:58 AM
 */

namespace project;


class Tracks extends Table
{
    public function __construct(Site $site) {
        parent::__construct($site, "track");
    }
    public function get($trackid) {
        $sql =<<<SQL
SELECT * from $this->tableName
where TrackId=?
SQL;
        $pdo = $this->pdo();
        $statement = $pdo->prepare($sql);

        $statement->execute(array($trackid));
        if($statement->rowCount() === 0) {
            return null;
        }

        return new Track($statement->fetch(\PDO::FETCH_ASSOC));
    }

    public function getTracks($aname) {
        $result = array();
        $sql =<<<SQL
SELECT * from $this->tableName
where TrackArtist=?
SQL;
        $pdo = $this->pdo();
        $statement = $pdo->prepare($sql);

        $statement->execute(array($aname));
        if($statement->rowCount() === 0) {
            return null;
        }
        while($row = $statement->fetch(\PDO::FETCH_ASSOC)){
            array_push($result,new Track($row));
        }
        return $result;
    }

    public function search($keyword) {

        $lists = array();
        $sql =<<<SQL
SELECT DISTINCT * from $this->tableName
where TrackName like ? order by TrackName
SQL;
        $pdo = $this->pdo();
        $statement = $pdo->prepare($sql);

        $statement->execute(array($keyword));
        if($statement->rowCount() === 0) {
            return null;
        }
        while($row = $statement->fetch(\PDO::FETCH_ASSOC)){
            array_push($lists,new Track($row));
        }
        return $lists;
    }

    public function addSearch($keyword) {

        $lists = array();
        $sql =<<<SQL
SELECT DISTINCT * from $this->tableName
where TrackName like ? or TrackArtist like ? order by TrackName
SQL;
        $pdo = $this->pdo();
        $statement = $pdo->prepare($sql);

        $statement->execute(array($keyword, $keyword));
        if($statement->rowCount() === 0) {
            return null;
        }
        while($row = $statement->fetch(\PDO::FETCH_ASSOC)){
            array_push($lists,new Track($row));
        }
        return $lists;
    }

}