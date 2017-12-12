<?php
namespace project;

/**
 * Manage users in our system.
 */
class Users extends Table {

    /**
     * Constructor
     * @param $site The Site object
     */
    public function __construct(Site $site) {
        parent::__construct($site, "user");
    }

    /**
     * Test for a valid login.
     * @param $email User email
     * @param $password Password credential
     * @returns User object if successful, null otherwise.
     */
    public function login($username, $password) {
        $sql =<<<SQL
SELECT * from $this->tableName
where username=? and password = ?
SQL;
        $pdo = $this->pdo();
        $statement = $pdo->prepare($sql);

        $statement->execute(array($username,$password));
        if($statement->rowCount() === 0) {
            return null;
        }

        $row = $statement->fetch(\PDO::FETCH_ASSOC);

        return new User($row);


    }

    /**
     * Get a user based on the id
     * @param $id ID of the user
     * @returns User object if successful, null otherwise.
     */
    public function get($username) {
        $sql =<<<SQL
SELECT * from $this->tableName
where username=?
SQL;
        $pdo = $this->pdo();
        $statement = $pdo->prepare($sql);

        $statement->execute(array($username));
        if($statement->rowCount() === 0) {
            return null;
        }

        return new User($statement->fetch(\PDO::FETCH_ASSOC));
    }

    /**
     * Modify a user record based on the contents of a User object
     * @param User $user User object for object with modified data
     * @return true if successful, false if failed or user does not exist
     */
    public function update(User $user) {
        $sql =<<<SQL
UPDATE $this->tableName
SET uname=?, email=?, city=?, password = ?
WHERE username=?
SQL;
        $pdo = $this->pdo();
        $statement = $pdo->prepare($sql);

        try {
            $ret = $statement->execute(array($user->getName(),
                $user->getEmail(),$user->getCity(), $user->getPassword(), $user->getUsername()));
        } catch(\PDOException $e) {
            return false;
        }
        $temp = $this->get($user->getUsername());
        if($temp === null){
            return false;
        }
        return true;

    }

    public function getUsers(){
        $users = array();
        $sql =<<<SQL
SELECT username, uname, email, city from $this->tableName
SQL;
        $statement = $this->pdo()->prepare($sql);
        $statement->execute();
        if($statement->rowCount() === 0) {
            return null;
        }
        while($row = $statement->fetch(\PDO::FETCH_ASSOC)){
            array_push($users,$row);
        }
        return $users;
    }




    /**
     * Determine if a user exists in the system.
     * @param $email An email address.
     * @returns true if $email is an existing email address
     */
    public function exists($username) {
        $sql = <<<SQL
SELECT username from $this->tableName where username=?
SQL;
        $pdo = $this->pdo();
        $statement = $pdo->prepare($sql);

        $statement->execute(array($username));
        if($statement->rowCount() === 0) {
            return false;
        }
        return true;

    }
    public function deleteUser($id){
        $sql = <<<SQL
DELETE FROM $this->tableName
WHERE id=?
SQL;
        $pdo = $this->pdo();
        $statement = $pdo->prepare($sql);

        $statement->execute(array($id));
    }

    /**
     * Create a new user.
     * @param User $user The new user data
     * @param Email $mailer An Email object to use
     * @return null on success or error message if failure
     */
    public function add(User $user) {
        // Ensure we have no duplicate email address
        if($this->exists($user->getUsername())) {
            return "User already exists.";
        }
        // Add a record to the user table
        $sql = <<<SQL
INSERT INTO $this->tableName(username, uname, password)
values(?, ?, ?)
SQL;

        $statement = $this->pdo()->prepare($sql);
        $statement->execute(array(
            $user->getUsername(), $user->getName(), $user->getPassword()));
    }

    public function changePassword($username, $password){
        $sql = <<<SQL
UPDATE $this->tableName SET password = ?
WHERE username = ?
SQL;
        $statement = $this->pdo()->prepare($sql);
        $statement->execute(array($password,$username));
    }

    /**
     * Set the password for a user
     * @param $userid The ID for the user
     * @param $password New password to set
     */
    public function setPassword($userid, $password) {
        $salt =$this->randomSalt();
        $pass = hash("sha256", $password . $salt);
        $sql = <<<SQL
UPDATE $this->tableName SET salt = ?, password = ?
WHERE id = ?
SQL;
        $statement = $this->pdo()->prepare($sql);
        $statement->execute(array($salt, $pass, $userid));


    }


}