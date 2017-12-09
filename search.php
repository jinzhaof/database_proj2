<?php
$servername = "localhost:3306";
$username = "root";
$password = "";
$dbname = "hw3";


$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection

if(empty($_POST["Keyword"])){
    $keyword ="";
}else{
    $keyword = $_POST[Keyword];
}
if ($conn->connect_error) {
    die("connection fail: " . $conn->connect_error);
}

echo "<!DOCTYPE html>
<html>
<head>
    <meta http-equiv=\"Content-Type\" content=\"text/html; charset=iso-8859-1\">
    <link href=\"style.css\" type=\"text/css\" rel=\"stylesheet\">
    <title>Searching Results</title>
</head>
<body>
<header><h1>Searching Results</h1></header>
<article>";

$sql1="SELECT TrackName FROM Track t join Artist a WHERE a.ArtistId=t.TrackArtist and ArtistTitle LIKE '%$keyword%' or ArtistDescription like '%$keyword%'";


$result=  $conn->query($sql1);


if($result->num_rows > 0){

    "SELECT TrackName FROM Track t join Artist a WHERE a.ArtistId=t.TrackArtist and ArtistTitle LIKE '%$keyword%' or ArtistDescription like '%$keyword%'";

    $result=  $conn->query($sql2);

}

elseif( '%$keyword%' ==''){
    $sql3 ="select TrackName from Track";



    $result =  $conn->query($sql3);

}
else{

}



$res=array();


if ($result->num_rows > 0) {

    while($row = $result->fetch_array()) {
        echo " Name: " . $row["TrackName"]. "<br>";
    }
} else {
    echo "0 结果";
}

mysqli_close($conn);
?>

