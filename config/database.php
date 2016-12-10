<?php
	$DB_DSN = 'mysql:host=localhost;';
	$DB_USER = 'root';
	$DB_PASSWORD = 'root';

	try
	{
		$db = new PDO($DB_DSN, $DB_USER, $DB_PASSWORD);
		$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	}
	catch (Exception $e)
	{
		die ('Error config/database : '. $e->getMessage());
	}

?>
