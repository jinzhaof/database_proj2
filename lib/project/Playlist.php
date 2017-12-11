<?php
/**
 * Created by PhpStorm.
 * User: Zhaofeng
 * Date: 12/11/17
 * Time: 3:20 AM
 */

namespace project;


class Playlist
{
    public function __construct($row) {
        $this->pid = $row["pid"];
        $this->ptitle = $row["ptitle"];
        $this->releasedate = $row["releasedate"];
        $this->user = $row["username"];
    }



    /**
     * @return mixed
     */
    public function getPid()
    {
        return $this->pid;
    }

    /**
     * @param mixed $pid
     */
    public function setPid($pid)
    {
        $this->pid = $pid;
    }

    /**
     * @return mixed
     */
    public function getPtitle()
    {
        return $this->ptitle;
    }

    /**
     * @param mixed $ptitle
     */
    public function setPtitle($ptitle)
    {
        $this->ptitle = $ptitle;
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

    /**
     * @return mixed
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * @param mixed $user
     */
    public function setUser($user)
    {
        $this->user = $user;
    }

    private $pid;
    private $ptitle;
    private $releasedate;
    private $user;

}