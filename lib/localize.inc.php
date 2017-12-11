<?php
/**
 * Created by PhpStorm.
 * User: Zhaofeng
 * Date: 3/17/16
 * Time: 7:12 PM
 */

/**
 * Function to localize our site
 * @param $site The Site object
 */
return function(project\Site $site) {
    // Set the time zone
    date_default_timezone_set('America/Detroit');
    $site->setEmail('zj617@nyu.edu');
    $site->setRoot('/~database_proj2/index.php');
    $site->dbConfigure('mysql:host=localhost;dbname=project',
        'root',       // Database user
        'changjun090958',     // Database password
        'project');            // Table prefix

};