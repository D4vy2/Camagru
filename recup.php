<!DOCTYPE html>
<html>
<head>
    <title>recup.php</title>
</head>
<body>

   <?php
   define('UPLOAD_DIR', 'images/');
	$img = $_POST['base64'];
	$img = str_replace('data:image/png;base64,', '', $img);
	$img = str_replace(' ', '+', $img);
	$data = base64_decode($img);
	$file = 'images/.result.png';
	$success = file_put_contents($file, $data);
	if (false == $success)
		echo 'Unable to save the file.';
	?>
  
</body>
</html>