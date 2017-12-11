<?php
/**
 * Created by PhpStorm.
 * User: Zhaofeng
 * Date: 3/18/16
 * Time: 11:36 PM
 */

namespace project;


class User
{
    const SESSION_NAME = 'user';
    /**
     * Constructor
     * @param $row Row from the user table in the database
     */
    public function __construct($row) {
        $this->username = $row["username"];
        $this->name = $row["name"];
        $this->email = $row["email"];
        $this->city = $row["city"];
        $this->password = $row["password"];
    }
    /**
     * @return mixed
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * @return mixed
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }



    /**
     * @return mixed
     */
    public function getCity()
    {
        return $this->city;
    }


    /**
     * @param mixed $id
     */
    public function setUsername($username)
    {
        $this->username = $username;
    }

    /**
     * @param mixed $email
     */
    public function setEmail($email)
    {
        $this->email = $email;
    }

    /**
     * @param mixed $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }
    public function setPassword($password)
    {
        $this->password = $password;
    }
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * @param mixed $phone
     */
    public function setCity($city)
    {
        $this->city = $city;
    }



    private $username;		///< The internal ID for the user
    private $email;		///< Email address
    private $name; 		///< Name as last, first
    private $city;
    private $password;
}