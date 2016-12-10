<?php
session_start();
header( "refresh:0;url=connexion.php"); 
include("config/connect_db.php");

$autor = htmlentities($_SESSION['login']);
$image = htmlentities($_SESSION['image']);

$req = $db->prepare("SELECT * FROM likes WHERE autor = ? AND image = ?");
$req->execute(array($autor, $image));
$data = $req->fetch();
$req->closeCursor();
if (empty($data))
{
    $req = $db->prepare("INSERT INTO likes(autor, image) VALUES (?, ?)");
    $req->execute(array($autor, $image));
    $req->closeCursor();
    echo "SUCCESS";
}
else
    echo "ALREADY";

?>