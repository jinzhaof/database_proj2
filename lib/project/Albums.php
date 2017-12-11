<?php
/**
 * Created by PhpStorm.
 * User: Zhaofeng
 * Date: 12/11/17
 * Time: 3:23 AM
 */

namespace project;


class Albums extends Table
{
    public function __construct(Site $site) {
        parent::__construct($site, "album");
    }

    public function get($id) {
        $sql =<<<SQL
SELECT * from $this->tableName
where AlbumId=?
SQL;
        $pdo = $this->pdo();
        $statement = $pdo->prepare($sql);

        $statement->execute(array($id));
        if($statement->rowCount() === 0) {
            return null;
        }

        return new Album($statement->fetch(\PDO::FETCH_ASSOC));
    }

}