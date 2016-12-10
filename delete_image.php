<?php
session_start();
if (isset($_SESSION['login']) AND !empty($_SESSION['login']))
{
    include("config/connect_db.php");
    if (!empty($_POST['link']))
    {
        try {
        $link = htmlentities($_POST['link']);
        $login = $_SESSION['login'];
        $req = $db->prepare("DELETE FROM images WHERE image = ? AND login = ?");
        $req->execute(array($link, $login));
        $req->closeCursor();
        $req = $db->prepare("DELETE FROM comments WHERE image = ?");
        $req->execute(array($link));
        $req->closeCursor();
        }
        catch (Exeption $e) {
            echo 'Error delete_image.php : Please check it ! '.$e->getMessage();
        }
    }
    else {
        echo "Wrong page buddy!";
    }
}
else
{
    function redirect($location){
        echo "<script>window.location.href='".$location."'</script>";
    }
    redirect('connexion.php');
}
?>

