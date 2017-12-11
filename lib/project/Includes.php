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

}