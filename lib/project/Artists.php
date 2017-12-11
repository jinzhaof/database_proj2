<?php
/**
 * Created by PhpStorm.
 * User: Zhaofeng
 * Date: 12/11/17
 * Time: 3:11 AM
 */

namespace project;


class Artists extends Table
{
    /**
     * Constructor
     * @param $site The Site object
     */
    public function __construct(Site $site) {
        parent::__construct($site, "artist");
    }

    public function get($name) {
        $sql =<<<SQL
SELECT * from $this->tableName
where ArtistTitle=?
SQL;
        $pdo = $this->pdo();
        $statement = $pdo->prepare($sql);

        $statement->execute(array($name));
        if($statement->rowCount() === 0) {
            return null;
        }

        return new \project\Artist($statement->fetch(\PDO::FETCH_ASSOC));
    }
    public function search($keyword) {

        $lists = array();
        $sql =<<<SQL
SELECT * from $this->tableName
where ArtistTitle like ? or ArtistDescription like ? ORDER BY ArtistTitle
SQL;
        $pdo = $this->pdo();
        $statement = $pdo->prepare($sql);

        $statement->execute(array($keyword,$keyword));
        if($statement->rowCount() === 0) {
            return null;
        }
        while($row = $statement->fetch(\PDO::FETCH_ASSOC)){
            array_push($lists,new \project\Artist($row));
        }
        return $lists;
    }
}