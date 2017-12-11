<?php
$open=true;
require 'lib/site.inc.php';
$users = new project\Users($site);

$username = strip_tags($_POST['username']);
$password = strip_tags($_POST['password']);
$user = $users->login($username, $password);

if ($user == null){
    header("Location: index.php?e");
    exit;
}
else{
    if(!isset($_SESSION))
    {
        session_start();
    }
    $_SESSION['user'] = $user;
    header("Location: profile.php");
    exit;
}


?>
