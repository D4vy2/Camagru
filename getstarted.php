<?php
session_start();
if (isset($_SESSION['login']) AND !empty($_SESSION['login'])) {
	include("header_deconnexion.php");
	include("section.php");
}
else {
	include("header.php");?>
		<h3 style="color:#fcf3b3"> <?php echo 'Vous devez vous connecter pour acceder au contenu.';?></h3>
<br/><br/><br/><br/><br/><br/>
<br/><br/><br/><br/><br/><br/>
<br/><br/><br/><br/><br/><br/>
<br/><br/><br/><br/><br/><br/>
<br/><br/><br/><br/><br/><br/>
<?php
}
include("footer.html");
?>