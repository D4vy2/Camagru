<?php
	session_start();
	function redirect($location){
        echo "<script>window.location.href='".$location."'</script>";
  }
	if (isset($_SESSION['login']) AND !empty($_SESSION['login']))
  	redirect('index.php');
	include("header.php");
	include "config/connect_db.php";
?>
<?php

	function generate_passwd()
	{
					$passwd = "";
					$str = "abcdefghjkmnopqrstuvwxyzABCDEFGHJKLMNOPQRSTUVWXYZ0123456789+@!$%?&";
					$lower = "abcdefghjkmnopqrstuvwxyz";
					$upper = "ABCDEFGHJKLMNOPQRSTUVWXYZ";
					$num = "0123456789";
					$spe = "+@!$%?&";
					$len1 = strlen($lower);
					$len2 = strlen($upper);
					$len3 = strlen($num);
					$len4 = strlen($spe);
					for($i = 0; $i < 2; $i++)
					{
							$random1 = mt_rand(0, ($len1 - 1));
							$random2 = mt_rand(0, ($len2 - 1));
							$random3 = mt_rand(0, ($len3 - 1));
							$random4 = mt_rand(0, ($len4 - 1));
							$passwd .= $lower[$random1];
							$passwd .= $upper[$random2];
							$passwd .= $num[$random3];
							$passwd .= $spe[$random4];
					}
					$len = strlen($str);
					$random = mt_rand(0, ($len - 1));
					$passwd .= $str[$random];
					return $passwd;   
	}

	if (isset($_POST['reinit']))
	{
		$reinit_mail = htmlentities($_POST['reinit_mail']);
		if ($reinit_mail == "")
			$message = '<h3 style="color: #fcf3b3;">Please enter your email.</h3>';
		else
		{
			$req = $db->prepare('SELECT email FROM members WHERE email = ?');
			$req->execute(array($reinit_mail));
			$donnees = $req->fetch();
			$req->closeCursor();
			if ($donnees['email'] == $reinit_mail)
			{
				$passwd = generate_passwd();
				$mdpNew_hash = hash("whirlpool", htmlentities($passwd));
				$req = $db->prepare('UPDATE members SET passwd = ? WHERE email = ?');
				$req->execute(array($mdpNew_hash, htmlentities($reinit_mail)));$header = "From: \"Camagru\"<camagru_dea@42.fr>"."\n";
				$req->closeCursor();

				// Envoie du nouveau mot de passe genere aleatoirement
				$header .= "Reply-to: \"Camagru_dea\" <camagru_dea@42.fr>"."\n";
				$header .= 'MIME-Version: 1.0'."\n";
				$header .= 'Content-Type:text/html; charset="utf-8"'."\n";
				$header .= 'Content-Transfer-Encoding: 8bit';
				$mail_msg = '<p>Bonjour,</p>'.'<p>Vous avez demande un nouveau mot de passe.'.'<p>Votre nouveau mot de passe: '.$passwd.'</p'.'</p>';
				mail($reinit_mail, "Nouveau mot de passe", $mail_msg, $header);

				$message = '<h3 style="color: #7df640;">A new password has been sent!</h3>';
			}
			else
				$message = '<h3 style="color: #f84b4b;">Email account does not exist.</h3>';
		}
	}
?>
<br /><br />
<h2>R&eacute;initialisation du mot de passe</h2>
<br /><br />
<form method="post" action="">
  <table class="mycenter">
    <tr>
	<td>
	  <label for="email">Email :</label>
	</td>
	<td>
	  <input type="email" name="reinit_mail" id="email"  placeholder="Votre email">
	</td>
    </tr>
  </table>
<br />
<br />
  <input name="reinit" class="mycenter" id="confirm" type="submit" value="R&eacute;initialiser">
</body>

<?php
	if (isset($message))
		echo $message;
?>
