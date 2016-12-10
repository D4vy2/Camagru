<?php
session_start();
if (isset($_SESSION['login']) AND !empty($_SESSION['login']))
{
    include("config/connect_db.php");
    $file = 'images/'.$_SESSION['login'].'_'.date("U").'.png';

    function imagecopymerge_alpha($destination, $source, $dst_x, $dst_y, $src_x, $src_y, $src_w, $src_h, $pct){ 
            // creating a cut resource 
            $cut = imagecreatetruecolor($src_w, $src_h); 
            // copying relevant section from background to the cut resource 
            imagecopy($cut, $destination, 0, 0, $dst_x, $dst_y, $src_w, $src_h); 
            // copying relevant section from watermark to the cut resource 
            imagecopy($cut, $source, 0, 0, $src_x, $src_y, $src_w, $src_h); 
            // insert cut resource to destination image 
            imagecopymerge($destination, $cut, $dst_x, $dst_y, 0, 0, $src_w, $src_h, $pct); 
        } 

    if (!empty($_POST['filter']))
    {
        $source = imagecreatefrompng($_POST['filter']);
        $destination = imagecreatefrompng("images/.result.png");
        $largeur_source = imagesx($source);
        $hauteur_source = imagesy($source);
        $largeur_destination = imagesx($destination);
        $hauteur_destination = imagesy($destination);
        imagecopymerge_alpha($destination, $source, 0, 0, 0, 0, 320, 240, 100);
        imagepng($destination, $file);
    }
    else
    {
        echo "Impossible d'acceder a la page de montage.";
    }
    // add image in database table "images"
    try
    {
        if (!empty($_POST['filter']))
        {
            if (file_exists($file))
            {
                $login = $_SESSION['login'];
                $req = $db->prepare("INSERT INTO images(login, image) VALUES(?, ?)");
                $req->execute(array($login, $file));
                $req->closeCursor();
            }
        }
    }
    catch (Exception $e)
    {
        echo 'Error upload image in database'.$e->getMessage();
    }
    $db = null;
}
else
{
    function redirect($location){
        echo "<script>window.location.href='".$location."'</script>";
    }
    echo "Vous n'avez pas acces a cette page, veuillez retourner sur la page principale.";
    redirect('connexion.php');
}
?>