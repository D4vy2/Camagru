<?php
session_start();
include("config/connect_db.php");
if (isset($_GET['id']) AND $_GET['id'] > 0 AND !empty($_SESSION['id']))
{
	include("header_deconnexion.php");
	$getid = intval($_GET['id']);?>
	<h3 style="color:#7df640; font-style:italic;"> <?php echo 'Welcome '.$_SESSION['login'].' !';?></h3>
<?php
}

else
{
?>
<!DOCTYPE html>
<head>
  <title>Camagru</title>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <link rel="stylesheet" type="text/css" href="css/style.css">
</head>
<body>
  <h1>Camagru @ 42</h1>
  <br /><br />
  <table class="mycenter">
    <tr>
	<td>
	  <form method="post" action="connexion.php">
	  <input type="submit" name="connexion" value="Connexion">
	  </form>
	<td>
    </tr>
  </table>
	<h3 style="color:#fcf3b3"> <?php echo 'Vous devez vous connecter pour acceder au contenu.';?></h3>
<?php
}
?>
<br/><br/><br/><br/><br/><br/>
<br/><br/><br/><br/><br/><br/>
<br/><br/><br/><br/><br/><br/>
<br/><br/>
<?php
	include "footer.html"
?>

