<?php
$servername = "localhost:3306";
$username = "root";
$password = "";
$dbname = "hw3";


$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
    die("connection fail: " . $conn->connect_error);
}

echo "<!DOCTYPE html>
<html>
<head>
    <meta http-equiv=\"Content-Type\" content=\"text/html; charset=iso-8859-1\">
    <link href=\"style.css\" type=\"text/css\" rel=\"stylesheet\">
    <title>Track Set</title>
</head>
<body>
<header><h1>Track Set</h1></header>
<article>";

$sql="select TrackName from Artist a join Track t where a.ArtistId=t.TrackArtist and a.ArtistId =$_GET[ArtistId])";

$result =  $conn->query($sql);


if ($result->num_rows > 0) {

    while($row = $result->fetch_array()) {
        echo " Name: " . $row["TrackName"]. "- Cid: " . $row["cid"]."- Rid" . $row["rid"]."- Time: " . $row["btime"]. "- Quantity: " . $row["quantity"]. "<br>";
    }
} else {
    echo "0 结果";
}

$conn->close();
?>