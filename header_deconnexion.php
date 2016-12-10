<?php
session_start();
if (!isset($_SESSION['login']) OR empty($_SESSION['login']))
{
    function redirect($location){
        echo "<script>window.location.href='".$location."'</script>";
    }
    redirect('connexion.php');
}

if(isset($_POST['deconnexion']))
{
	$_SESSION = array();
	session_destroy();
	header('Location: index.php');
	exit();
}
?>
<!DOCTYPE html>

<head>
  <title>Camagru</title>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <link rel="stylesheet" type="text/css" href="css/style.css">
</head>
<body>
  <a style="text-decoration:none;color: #fcf3b3;" href="index.php"><h1>Camagru</a> @ 42</h1>
  <br /><br />
  <table class="mycenter">
    <tr>
	<td>
	  <form method="post" name="form_deconnexion">
	  <input type="submit" name="deconnexion" value="Deconnexion"</td>
	  </form>
	</td>
    </tr>
  </table>
<div id="menuGallery">
<a href="gallery.php" id="gallery">Gallery</a>
</div>
<div id="menuPhotos">
<a href="myphotos.php" id="myphotos">My snap</a>
</div>
<a href="getstarted.php" id="getstarted">Get Started !</a>
