<?php
session_start();
include("config/connect_db.php"); 
if (isset($_POST['confirm_connexion']))
{
	$login_connect = htmlentities($_POST['login_connect']);
	$password_connect = hash("whirlpool", htmlentities($_POST['password_connect']));
	if (empty($login_connect) || empty($password_connect))
		$message = '<h3 style="color: #fcf3b3;">Please enter your email and your password.</h3>';
	else
	{
		$req = $db->prepare('SELECT * FROM members WHERE login = ? AND passwd = ?');
		$req->execute(array($login_connect, $password_connect));
		$login_exist = $req->rowCount($req);
		if ($login_exist == 1)
		{
			$user_info = $req->fetch();
			$_SESSION['id'] = $user_info['id'];
			$_SESSION['login'] = $user_info['login'];
			$_SESSION['password'] = $user_info['passwd'];
			if ($user_info['confirmed'] == 0)
				$message = '<h3 style="color:#f84b4b;">Votre compte est en attente de validation.</h3>';
			else
			{
				$_SESSION['confirmed'] = 1;
				header('Location: profil.php?id='.$_SESSION['id']);
				exit();
			}
		}
		else
			$message = '<h3 style="color:#f84b4b;">Identifiants incorrects.</h3>';
		$req->closeCursor();
	}
}
?>
<?php 
if (isset($_SESSION['login']) AND ($_SESSION['confirmed'] == 1))
	include "header_deconnexion.php";
else
{
	include "header.php";
	// si je ne suis pas connecte, le formulaire de connexion apparait.
	echo'
	<br /><br />
	<h2>Connexion</h2>
	<br />
	<br />
	<br />
	<br />
	<br />
	<form method="post" action="">
	  <table class="mycenter">
	    <tr>
		<td><label for="login">Login :</label></td>
		<td><input type="text" name="login_connect" id="login"  placeholder="Votre login"></td>
	    </tr>
	    <tr>
		<td><label for="password">Mot de passe : </label></td>
		<td><input type="password" name="password_connect" id="password" placeholder="Votre mot de passe"></td>
	    </tr>
	    <tr>
		<td></td>
		<td><a style="color: grey; text-decoration: none" href="reset_password.php">Mot de passe oubli&eacute;?</a></td>
	    </tr>
	  </table>
	  <input name="confirm_connexion" action="profil.php" class="mycenter" id="confirm" type="submit" value="Se connecter">
	</form>
	</body>';
}?>
<?php
if(isset($message))
	echo $message;
?>

<br/><br/><br/><br/><br/><br/>
<br/><br/><br/><br/><br/><br/>
<br/><br/><br/><br/><br/><br/>
<br/><br/>
<?php
	include "footer.html";
?>
