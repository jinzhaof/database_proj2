<?php
/**
 * Created by PhpStorm.
 * User: Zhaofeng
 * Date: 12/11/17
 * Time: 3:01 AM
 */

namespace project;


class Track
{
    public function __construct($row) {
        $this->trackID = $row["TrackId"];
        $this->duration = $row["TrackDuration"];
        $this->trackName = $row["TrackName"];
        $this->artist = $row["TrackArtist"];
        $this->album = $row["TrackAlbum"];
    }

    /**
     * @return mixed
     */
    public function getTrackID()
    {
        return $this->trackID;
    }

    /**
     * @param mixed $trackID
     */
    public function setTrackID($trackID)
    {
        $this->trackID = $trackID;
    }

    /**
     * @return mixed
     */
    public function getTrackName()
    {
        return $this->trackName;
    }

    /**
     * @param mixed $trackName
     */
    public function setTrackName($trackName)
    {
        $this->trackName = $trackName;
    }

    /**
     * @return mixed
     */
    public function getDuration()
    {
        return $this->duration;
    }

    /**
     * @param mixed $duration
     */
    public function setDuration($duration)
    {
        $this->duration = $duration;
    }

    /**
     * @return mixed
     */
    public function getArtist()
    {
        return $this->artist;
    }

    /**
     * @param mixed $artist
     */
    public function setArtist($artist)
    {
        $this->artist = $artist;
    }

    /**
     * @return mixed
     */
    public function getAlbum()
    {
        return $this->album;
    }

    /**
     * @param mixed $album
     */
    public function setAlbum($album)
    {
        $this->album = $album;
    }

    private $trackID;
    private $trackName;
    private $duration;
    private $artist;
    private $album;
}