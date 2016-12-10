<?php
session_start();
header( "refresh:0;url=image.php?id=".$_POST['id_img']); 
include("config/connect_db.php");

$login = htmlentities($_SESSION['login']);
$image = htmlentities($_SESSION['image']);
$comment = htmlentities($_POST['comment']);
$req = $db->prepare("INSERT INTO comments(autor, image, comment, date_comment) VALUES (?, ?, ?, NOW())");
$req->execute(array($login, $image, $comment));
$req->closeCursor();

// requete pour retrouver le mail a partir du nom de l'image
$idImg = htmlentities($_POST['id_img']);
$req = $db->prepare("SELECT email from members m INNER JOIN images i ON m.login = i.login WHERE i.id = ?");
$req->execute(array($idImg));
$array = $req->fetch();
$req->closeCursor();
$mail = $array[0];

$_SESSION['image'] = "";

	$header = "From: \"Camagru\"<camagru_dea@42.fr>"."\n";
	$header .= "Reply-to: \"Camagru_dea\" <camagru_dea@42.fr>"."\n";
	$header .= 'MIME-Version: 1.0'."\n";
	$header .= 'Content-Type:text/html; charset="utf-8"'."\n";
	$header .= 'Content-Transfer-Encoding: 8bit';

	$mail_msg = '<p>Bonjour,</p>'.'<p>Vous avez recu un nouveau commentaire sur une de vos photos.</p>';
	mail($mail, "Nouveau commentaire", $mail_msg, $header);

?>