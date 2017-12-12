<?php
/**
 * Created by PhpStorm.
 * User: Zhaofeng
 * Date: 12/11/17
 * Time: 3:31 AM
 */

namespace project;


class Includes extends Table
{
    public function __construct(Site $site) {
        parent::__construct($site, "include");
    }

    public function get($id) {
        $result = array();
        $tracks = new Tracks($this->site);
        $track_table = $tracks->getTableName();
        $sql =<<<SQL
SELECT TrackId, TrackName, TrackDuration, TrackArtist, TrackAlbum from $this->tableName natural join $track_table
where PlaylistId=?
SQL;
        $pdo = $this->pdo();
        $statement = $pdo->prepare($sql);

        $statement->execute(array($id));
        if($statement->rowCount() === 0) {
            return null;
        }
        while($row = $statement->fetch(\PDO::FETCH_ASSOC)){
            array_push($result,new Track($row));
        }
        return $result;
    }

    public function add($pid, $tid) {
        // Add a record to the user table
        $sql = <<<SQL
INSERT INTO $this->tableName(PlaylistId, TrackId)
values(?, ?)
SQL;

        $statement = $this->pdo()->prepare($sql);
        $statement->execute(array($pid, $tid));
        if($this->exists($pid, $tid)){
            return true;
        }
        else{
            return false;
        }


    }

    public function exists($pid, $tid) {
        $sql = <<<SQL
SELECT * from $this->tableName where PlaylistId = ? and TrackId = ?
SQL;
        $pdo = $this->pdo();
        $statement = $pdo->prepare($sql);

        $statement->execute(array($pid, $tid));
        if($statement->rowCount() === 0) {
            return false;
        }
        return true;

    }

    public function existsPlaylist($pid) {
        $sql = <<<SQL
SELECT * from $this->tableName where PlaylistId = ?
SQL;
        $pdo = $this->pdo();
        $statement = $pdo->prepare($sql);

        $statement->execute(array($pid));
        if($statement->rowCount() === 0) {
            return false;
        }
        return true;

    }

    public function delete($pid, $tid){
        $sql = <<<SQL
DELETE FROM $this->tableName
WHERE PlaylistId = ? and TrackId = ?
SQL;
        $pdo = $this->pdo();
        $statement = $pdo->prepare($sql);
        $statement->execute(array($pid, $tid));
        if($this->exists($pid, $tid)){
            return false;
        }
        return true;
    }

    public function deletePlaylist($pid){
        $sql = <<<SQL
DELETE FROM $this->tableName
WHERE PlaylistId = ?
SQL;
        $pdo = $this->pdo();
        $statement = $pdo->prepare($sql);
        $statement->execute(array($pid));
        if($this->existsPlaylist($pid)){
            return false;
        }
        return true;
    }

}