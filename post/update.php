<?php
require '../lib/site.inc.php';
$users = new \project\Users($site);
$playlist_table = new \project\Playlists($site);
$include_table = new \project\Includes($site);

$username = $_SESSION['user']->getUserName();
$password = strip_tags($_POST['password']);
$name = strip_tags($_POST['name']);
$city = strip_tags($_POST['city']);
$email = strip_tags($_POST['email']);

if(isset($_POST['cancel'])){
    header("Location: ../profile.php");
    exit;
}
else{
    if($password == null || $name == null){
        header("Location: ../update.php?m");
        exit;
    }
    else{
        $row = array("username" => $username, "password" => $password, "uname" => $name, "email" => $email, "city"=>$city);
        if(!isset($_SESSION))
        {
            session_start();
        }
        $user = new project\User($row);
        $result = $users->update($user);
        if($result){
            $_SESSION['user'] = $user;
            header("Location: ../profile.php");
            exit;
        }
    }
}

