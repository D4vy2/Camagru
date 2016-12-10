<?php
session_start();
include("config/connect_db.php"); 
if (isset($_GET['login']) AND isset($_GET['key']) AND !empty($_GET['login']) AND !empty($_GET['key']))
{
	$login = htmlentities($_GET['login']);
	$key = htmlentities($_GET['key']);
	print_r($_SESSION);
	if ($_SESSION['key'] == $key)
	{
		$req = $db->prepare("SELECT * FROM members WHERE login = ? ");
		$req->execute(array($login));
		$login_exist = $req->rowCount();
		if ($login_exist == 1)
		{
			$login_exist = $req->fetch();
			$req->closeCursor();
			if ($login_exist['confirmed'] == 0)
			{
				$req_confirm = $db->prepare("UPDATE members SET confirmed = '1' WHERE login = ? AND confirmkey = ?");
				$req_confirm->execute(array($login, $key));
				$req_confirm->closeCursor();
				$_SESSION['confirmed'] = 1;
				$message = '<h3 style="color: #7df640;">Inscription confirmee! Vous pouvez maintenant vous connecter.</h3>';
			}
			else
				$message = '<h3 style="color: #f84b4b;">Ce compte a deja ete confirme.</h3>';
	
	
		}
		else
			$message = '<h3 style="color: #f84b4b;">L\'utilisateur n\'existe pas!.</h3>';
	}
	else
		$message = '<h3 style="color: #f84b4b;">Vous n\'avez pas acces a cette page.</h3>';
}
else
	$message = '<h3 style="color: #f84b4b;">Vous n\'avez pas acces a cette page.</h3>';

include("header.php");

if (isset($message) AND !empty($message))
	echo $message;
?>

