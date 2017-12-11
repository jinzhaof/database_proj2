<?php
/**
 * Created by PhpStorm.
 * User: Zhaofeng
 * Date: 12/11/17
 * Time: 5:15 AM
 */

namespace project;


class Play extends Table
{
    public function __construct(Site $site) {
        parent::__construct($site, "artist");
    }
    public function add($username,$tid) {
        // Add a record to the user table
        $sql = <<<SQL
INSERT INTO $this->tableName(username, TrackId, timestamp)
values(?, ?, ?)
SQL;

        $statement = $this->pdo()->prepare($sql);
        try {
            $statement->execute(array($username,$tid,time()));
        } catch(\PDOException $e) {
            return false;
        }
        return true;
    }

}