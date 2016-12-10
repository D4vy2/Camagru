<?php
	$DB_DSN = 'mysql:host=localhost;dbname=camagru_db';
	$DB_USER = 'root';
	$DB_PASSWORD = 'root';

	try
	{
		$db = new PDO($DB_DSN, $DB_USER, $DB_PASSWORD);
		$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	}
	catch (Exception $e)
	{
		die ('Error config/connect_db : '.' Please check if the dabatase exist. '.$e->getMessage());
	}

?>
