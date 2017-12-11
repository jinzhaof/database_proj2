<?php
/**
 * Created by PhpStorm.
 * User: Zhaofeng
 * Date: 12/11/17
 * Time: 3:16 AM
 */

namespace project;


class Playlists extends Table
{
    /**
     * Constructor
     * @param $site The Site object
     */
    public function __construct(Site $site) {
        parent::__construct($site, "playlist");
    }

    public function get($id) {
        $sql =<<<SQL
SELECT * from $this->tableName
where pid=?
SQL;
        $pdo = $this->pdo();
        $statement = $pdo->prepare($sql);

        $statement->execute(array($id));
        if($statement->rowCount() === 0) {
            return null;
        }

        return new Playlist($statement->fetch(\PDO::FETCH_ASSOC));
    }
    public function getPlaylists($username) {
        $lists = array();
        $sql =<<<SQL
SELECT * from $this->tableName
where username=? ORDER BY releasedate DESC
SQL;
        $pdo = $this->pdo();
        $statement = $pdo->prepare($sql);

        $statement->execute(array($username));
        if($statement->rowCount() === 0) {
            return null;
        }
        while($row = $statement->fetch(\PDO::FETCH_ASSOC)){
            array_push($lists,new Playlist($row));
        }
        return $lists;
    }
    public function search($keyword) {
        $lists = array();
        $sql =<<<SQL
SELECT * from $this->tableName
where ptitle like ? ORDER BY releasedate DESC
SQL;
        $pdo = $this->pdo();
        $statement = $pdo->prepare($sql);

        $statement->execute(array($keyword));
        if($statement->rowCount() === 0) {
            return null;
        }
        while($row = $statement->fetch(\PDO::FETCH_ASSOC)){
            array_push($lists,new Playlist($row));
        }
        return $lists;
    }

    public function add(Playlist $playlist) {
        // Ensure we have no duplicate email address
        if($this->exists($playlist->getPid())) {
            return "Playlist already exists.";
        }
        // Add a record to the user table
        $sql = <<<SQL
INSERT INTO $this->tableName(pid, ptitle, releasedate,username)
values(?, ?, ?, ?)
SQL;

        $statement = $this->pdo()->prepare($sql);
        $statement->execute(array(
            $playlist->getPid(), $playlist->getPtitle(), $playlist->getReleasedate()),$playlist->getUser());
    }

    public function exists($pid) {
        $sql = <<<SQL
SELECT pid from $this->tableName where pid=?
SQL;
        $pdo = $this->pdo();
        $statement = $pdo->prepare($sql);

        $statement->execute(array($pid));
        if($statement->rowCount() === 0) {
            return false;
        }
        return true;

    }
}