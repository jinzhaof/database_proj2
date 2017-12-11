<?php
/**
 * Created by PhpStorm.
 * User: Zhaofeng
 * Date: 12/11/17
 * Time: 3:27 AM
 */

namespace project;


class Album
{
    public function __construct($row) {
        $this->albid = $row["AlbumId"];
        $this->albname = $row["AlbumName"];
        $this->releasedate = $row["AlbumReleaseDate"];
    }

    /**
     * @return mixed
     */
    public function getAlbid()
    {
        return $this->albid;
    }

    /**
     * @param mixed $albid
     */
    public function setAlbid($albid)
    {
        $this->albid = $albid;
    }

    /**
     * @return mixed
     */
    public function getAlbname()
    {
        return $this->albname;
    }

    /**
     * @param mixed $albname
     */
    public function setAlbname($albname)
    {
        $this->albname = $albname;
    }

    /**
     * @return mixed
     */
    public function getReleasedate()
    {
        return $this->releasedate;
    }

    /**
     * @param mixed $releasedate
     */
    public function setReleasedate($releasedate)
    {
        $this->releasedate = $releasedate;
    }

    private $albid;
    private $albname;
    private $releasedate;
}