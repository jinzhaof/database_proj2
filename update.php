<?php
require 'lib/site.inc.php';
$users = new project\Users($site);

$username = strip_tags($_POST['username']);
$password = strip_tags($_POST['password']);
$name = strip_tags($_POST['name']);
$city = strip_tags($_POST['city']);
$email = strip_tags($_POST['email']);
$row = array();

if(isset($_POST['s'])){
    $keyword = strip_tags($_POST['search']);
    if($keyword != null){
        header("Location: search.php?key=$keyword");
        exit;
    }
    else{
        header("Location: profile.php?k");
        exit;
    }
}


else if ($password == null || $name == null){
    header("Location: profile.php?m");
    exit;
}
else{
    $row = array("username" => $username, "password" => $password, "name" => $name, "email" => $email, "city"=>$city);
    if(!isset($_SESSION))
    {
        session_start();
    }
    $user = new project\User($row);
    $result = $users->update($user);
    if($result){
        $_SESSION['user'] = $user;
        header("Location: profile.php");
        exit;
    }
}