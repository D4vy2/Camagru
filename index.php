<?php
session_start();
include "config/connect_db.php";
if (isset($_SESSION['login']) AND ($_SESSION['confirmed'] == 1))
	include "header_deconnexion.php";
else
	include "header.php";
?>
<br/><br/><br/><br/><br/><br/>
<br/><br/><br/><br/><br/><br/>
<br/><br/><br/><br/><br/><br/>
<br/><br/><br/><br/><br/><br/>
<br/><br/><br/><br/><br/><br/>
<br/><br/><br/><br/>

<?php
	include ("footer.html");
?>