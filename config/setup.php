<?php

	include ("database.php");

	// Creation de la base de donnee
	try
	{
		$db = new PDO($DB_DSN, $DB_USER, $DB_PASSWORD);
		$sql_database = "CREATE DATABASE IF NOT EXISTS camagru_db";
		$db->exec($sql_database);
		$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		echo '-> Database created successfully  ->  ';
	}
	catch (Exception $e)
	{
		die ('Error config/setup.php -> sql_database '. $e->getMessage());
	}
	$db = null;

	// Creation table members
	try
	{
		$db = new PDO($DB_DSN.'dbname=camagru_db', $DB_USER, $DB_PASSWORD);
		$sql_table = "CREATE TABLE members (
			id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
			login VARCHAR(50) NOT NULL,
			email VARCHAR(50),
			passwd TEXT,
			confirmkey VARCHAR(256),
			confirmed INT(1)
			)";
		$db->exec($sql_table);
		echo 'Table members created successfully ->  ';
	}
	catch (Exception $e)
	{
		die ('Error config/setup.php -> sql_table(members) : '. $e->getMessage());
	}
	$db = null;

	//Creation table images
	try
	{
		$db = new PDO($DB_DSN.'dbname=camagru_db', $DB_USER, $DB_PASSWORD);
		$sql_table = "CREATE TABLE images (
			id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
			login VARCHAR(50) NOT NULL,
			image VARCHAR(50)
		)";
		$db->exec($sql_table);
		echo 'Table images created successfully ->  ';
	}
	catch (Exception $e)
	{
		die ('Error config/setup.php -> sql_table(images) :'.$e->getMessage());
	}
	$db = null;

	//Creation table comments
	try
	{
		$db = new PDO($DB_DSN.'dbname=camagru_db', $DB_USER, $DB_PASSWORD);
		$sql_table = "CREATE TABLE comments (
			id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
			autor VARCHAR(50) NOT NULL,
			image VARCHAR(50),
			comment TEXT,
			date_comment DATETIME
		)";
		$db->exec($sql_table);
		echo 'Table comments created successfully! ->  ';
	}
	catch (Exception $e)
	{
		die('Error config/setup.php -> sql_table(comments) :'.$e->getMessage());
	}
	$db = null;

	//Creation table likes
	try
	{
		$db = new PDO($DB_DSN.'dbname=camagru_db', $DB_USER, $DB_PASSWORD);
		$sql_table = "CREATE TABLE likes (
			id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
			autor VARCHAR(50) NOT NULL,
			image VARCHAR(50)
		)";
		$db->exec($sql_table);
		echo 'Table likes created successfully!';
	}
	catch (Exception $e)
	{
		die('Error config/setup.php -> sql_table(likes) :'.$e->getMessage());
	}
	$db = null;

?>
