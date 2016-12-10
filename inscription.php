<?php
session_start();
include("config/connect_db.php"); 
if (isset($_SESSION['login']))
	include("header_deconnexion.php");
else
	include("header.php");

if (isset($_POST['confirm_inscription']))
{

	if (!empty($_POST['login']) AND !empty($_POST['mail']) AND !empty($_POST['mdp']) AND !empty($_POST['mdp2']))
	{
		$login = htmlentities($_POST['login']);
		$mail = htmlentities($_POST['mail']);
		$mdp = $_POST['mdp'];
		$mdp2 = $_POST['mdp2'];
		if (strlen($login) <= 50 && strlen($mail) <= 50)
		{
			if (filter_var($mail, FILTER_VALIDATE_EMAIL))
			{
				$req_mail = $db->prepare("SELECT email FROM members WHERE email = ?");
				$req_mail->execute(array($mail));
				$mail_exist = $req_mail->rowCount();
				$req_mail->closeCursor();
				$req_login = $db->prepare("SELECT login FROM members WHERE login = ?");
				$req_login->execute(array($login));
				$login_exist = $req_login->rowCount();
				$req_login->closeCursor();
				if ($mail_exist == 0)
				{
					if ($login_exist == 0)
					{
						$letter = preg_match('#[A-Za-z]#', $mdp);
						$special = preg_match('/[#$!%@^`&*()+=\-\[\]\';,.\/{}|":<>?~\\\\]/', $mdp);
						$number = preg_match('#[0-9]#', $mdp);
						$error = array();
						if (strlen($mdp) < 8)
							$error['len'] = '<p>_ 8 caracteres.</p>';
						if (!$letter)
							$error['alpha'] = '<p>_ Une lettre (Majuscule ou minuscule).<p>';
						if (!$number)
							$error['digit'] = '<p>_ Un chiffre (01234456789).</p>';
						if (!$special)
							$error['special'] = '<p>_ Un caractere special.</p>';
						if (strlen($mdp) >= 8 && $letter && $special && $number)
						if (strlen($mdp) > 2)
						{
							$mdp_hash = hash("whirlpool", htmlentities($mdp));
							$mdp2_hash = hash("whirlpool", htmlentities($mdp2));
							if ($mdp_hash === $mdp2_hash)
							{
								$key = "";
								for ($i = 0; $i < 21; $i++)
									$key .= mt_rand(0,9);
								$insert_member = $db->prepare("INSERT INTO members(login, email, passwd, confirmkey) VALUES(?, ?, ?, ?)");
								$insert_member->execute(array($login, $mail, $mdp_hash, $key));
								$insert_member->closeCursor();
								$_SESSION['key'] = $key;
								$header = "From: \"Camagru\"<camagru_dea@42.fr>"."\n";
								$header .= "Reply-to: \"Camagru_dea\" <camagru_dea@42.fr>"."\n";
								$header .= 'MIME-Version: 1.0'."\n";
								$header .= 'Content-Type:text/html; charset="utf-8"'."\n";
								$header .= 'Content-Transfer-Encoding: 8bit';

								$mail_msg = '<p>Bonjour,</p>'.'<br /><p>Veuillez confirmer votre inscription en cliquant sur le lien ci-dessous:</p>'.'http://localhost:8080/camagru/confirmation.php?login='.urlencode($login).'&key='.$key;
								mail($mail, "Confirmation de compte", $mail_msg, $header);

								$message = '<h3 style="color: #fcf3b3;">Votre inscription en attente de validation.</h3>';
							}
							else
								$message = '<h3 style="color: #f84b4b;">Les mots de passe ne correspondent pas.</h3>';
						}
						else
							$message = '<h3 style="color: #f84b4b;">Votre mot de passe n\'est pas assez securise</h3>';

					}
					else
						$message = '<h3 style="color: #f84b4b;">Ce login existe deja.</h3>';
				}
				else
					$message = '<h3 style="color: #f84b4b;">Cette adresse email est deja utilisee.</h3>';
			}
			else
				$message = '<h3 style="color: #f84b4b;">Votre adresse email n\'est pas valide.</h3>';
		}
		else
			$message = '<h3 style="color: #f84b4b;">Votre login / email ne doit pas depasser 50 caracteres.</h3>';
	}
	else
		$message = '<h3 style="color: #f84b4b;">Tous les champs doivent etre completes.</h3>';
}
?>
<?php
if (!isset($_SESSION['login']))
{
	echo '
<br /><br />
<h2>Inscription</h2>
<br />
<br />
<br />
<br />
<br />
<br />
<br />
<form method="post" action="">
  <table class="mycenter">
    <tr>
	<td>
	  <label for="login">Login : </label>
	</td>
	<td>
	<input type="text" id ="login" name="login" placeholder="Votre login" value='.$login.'>
	</td>
    </tr>
    <tr>
	<td>
	  <label for="email">Email :</label>
	</td>
	<td>
	  <input type="email" id="email" name="mail" placeholder="Votre adresse mail" value='.$mail.'>
	</td>
    </tr>
    <tr>
	<td>
	  <label for="mdp">Mot de passe : </label>
	</td>
	<td>
	  <input type="password" id="mdp" name="mdp" placeholder="Votre mot de passe">
	</td>
    </tr>
    <tr>
	<td>
	  <label for="mdp2">Confirmation mot de passe : </label>
	</td>
	<td>
	  <input type="password" id="mdp2" name="mdp2" placeholder="Confirmation mot de passe">
	</td>
    </tr>
  </table>
  <input class="mycenter" id="confirm" type="submit" name="confirm_inscription" value="Je m\'inscris">
</form>
</body>
';
}
	?>

<?php
	if (isset($message))
		echo $message;
	if (isset($error) && !empty($error))
	{
		echo '<p>Votre mot de passe doit contenir au moins:</p>';
		foreach ($error as $value) {
			echo $value;
		}
	}

?>
<br/><br/><br/><br/><br/><br/>
<br/><br/><br/><br/><br/><br/>
<br/><br/><br/><br/><br/><br/>
<br/>
<?php
	include "footer.html";
?>
