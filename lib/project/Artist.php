<?php
/**
 * Created by PhpStorm.
 * User: Zhaofeng
 * Date: 12/11/17
 * Time: 6:42 AM
 */

namespace project;


class Artist
{
    public function __construct($row) {
        $this->artistId = $row["ArtistId"];
        $this->aname = $row["ArtistTitle"];
        $this->description = $row["ArtistDescription"];
    }

    /**
     * @return mixed
     */
    public function getArtistId()
    {
        return $this->artistId;
    }

    /**
     * @param mixed $artistId
     */
    public function setArtistId($artistId)
    {
        $this->artistId = $artistId;
    }

    /**
     * @return mixed
     */
    public function getAname()
    {
        return $this->aname;
    }

    /**
     * @param mixed $aname
     */
    public function setAname($aname)
    {
        $this->aname = $aname;
    }

    /**
     * @return mixed
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param mixed $decription
     */
    public function setDecription($decription)
    {
        $this->decription = $decription;
    }

    private $artistId;
    private $aname;
    private $description;
}