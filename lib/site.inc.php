<?php
/**
 * @file
 * A file loaded for all pages on the site.
 */
require __DIR__ . "/../vendor/autoload.php";

$site = new project\Site();
$localize = require 'localize.inc.php';
if(is_callable($localize)) {
    $localize($site);
}
// Start the session system
session_start();
$user = null;
if(isset($_SESSION['user'])) {
    $user = $_SESSION['user'];
}
// redirect if user is not logged in
if(!isset($open) && $user === null) {
    header("Location: index.php");
    exit;
}