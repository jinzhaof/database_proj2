<?php
require '../lib/site.inc.php';
/* Created by PhpStorm.
 * User: Zhaofeng
 * Date: 12/11/17
 * Time: 9:25 PM
 */
$include_table = new \project\Includes($site);
if(isset($_POST['add'])){
    $tid = $_POST['add'];
    if(isset($_POST['pid'])){
        $pid = $_POST['pid'];
        if(isset($_POST['key'])){
            $keyword = $_POST['key'];
        }
        if($include_table->exists($pid,$tid)){
            header("Location: ../addtrack.php?id=$pid&key=$keyword&e");
            exit;
        }
        else{
            if($include_table->add($pid,$_POST['add'])){
                header("Location: ../addtrack.php?id=$pid&key=$keyword");
                exit;
            }
        }

    }
}
else if(isset($_POST['s'])){
    $keyword = strip_tags($_POST['search']);
    if($keyword != null){
        header("Location: ../addtrack.php?id=$pid&key=$keyword");
        exit;
    }
    else{
        header("Location: ../addtrack.php?k");
        exit;
    }
}