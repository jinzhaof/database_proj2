<?php
/**
 * Created by PhpStorm.
 * User: Zhaofeng
 * Date: 12/12/17
 * Time: 6:09 AM
 */

namespace project;


class Preview extends Table
{
    public function __construct(Site $site) {
        parent::__construct($site, "preview");
    }

    public function get($id) {
        $sql =<<<SQL
SELECT * from $this->tableName
where TrackId=?
SQL;
        $pdo = $this->pdo();
        $statement = $pdo->prepare($sql);

        $statement->execute(array($id));
        if($statement->rowCount() === 0) {
            return null;
        }

        $row = $statement->fetch(\PDO::FETCH_ASSOC);
        return $row["url"];
    }
}