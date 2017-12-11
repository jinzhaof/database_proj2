<?php
$open=true;
require 'lib/site.inc.php';
$users = new project\Users($site);

$username = strip_tags($_POST['username']);
$password1 = strip_tags($_POST['password1']);
$password2 = strip_tags($_POST['password2']);
$name = strip_tags($_POST['name']);
if(!isset($_SESSION))
{
    session_start();
}
if($users->exists($username)){
    header("Location: signup.php?u");
    exit;
}
else if ($password1 != $password2){
    header("Location: signup.php?p");
    exit;
}
else if ($username == null || $password1 == null || $password2 == null || $name == null){
    header("Location: signup.php?m");
    exit;
}
else{
    $row = array("username" => $username, "password" => $password1, "name" => $name);
    $user = new \project\User($row);
    $users->add($user);
    $_SESSION['user'] = $user;
}


?>