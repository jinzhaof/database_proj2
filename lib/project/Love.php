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
SELECT ArtistId from $this->tableName
where username=?
SQL;
        $pdo = $this->pdo();
        $statement = $pdo->prepare($sql);

        $statement->execute(array($username));
        if($statement->rowCount() === 0) {
            return null;
        }
        while($row = $statement->fetch(\PDO::FETCH_ASSOC)){
            array_push($likes,$row['ArtistId']);
        }
        return $likes;
    }
    public function add($username,$id,$ltime){
        // Add a record to the user table
        $sql = <<<SQL
INSERT INTO $this->tableName(username,ArtistId, ltime)
values(?, ?, ?)
SQL;

        $statement = $this->pdo()->prepare($sql);
        $statement->execute(array($username,$id,$ltime));
        return $this->exists($username,$id);
    }

    public function exists($username,$id){
        $sql =<<<SQL
SELECT ltime from $this->tableName
where username=? and ArtistId =?
SQL;
        $statement = $this->pdo()->prepare($sql);
        $statement->execute(array($username,$id));
        if($statement->rowCount() === 0) {
            return false;
        }else{
            return true;
        }
    }

    public function delete($username,$id){
        $sql = <<<SQL
DELETE FROM $this->tableName
WHERE username=? and ArtistId = ?
SQL;
        $pdo = $this->pdo();
        $statement = $pdo->prepare($sql);
        $statement->execute(array($username,$id));
        if($this->exists($username,$id)){
            return false;
        }
        return true;
    }

    public function getRecent($username) {
        $result = array();
        $sql =<<<SQL
SELECT TrackId from love NATURAL JOIN artist JOIN track ON artist.ArtistTitle = track.TrackArtist
JOIN album ON track.TrackAlbum = album.AlbumId
where username= ? ORDER BY album.AlbumReleaseDate  DESC LIMIT 5
SQL;
        $pdo = $this->pdo();
        $statement = $pdo->prepare($sql);

        $statement->execute(array($username));
        if($statement->rowCount() === 0) {
            return null;
        }
        while($row = $statement->fetch(\PDO::FETCH_ASSOC)){
            array_push($result,$row["TrackId"]);
        }
        return $result;
    }

}