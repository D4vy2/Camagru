<?php
session_start();

if (isset($_SESSION['login']) AND !empty($_SESSION['login'])) 
{
    include("header_deconnexion.php");
    include("config/connect_db.php");
?>

    <div class="empty" name="gallery">
    <br/>
    <?php
    $compteur = htmlentities(6);
    $req = $db->prepare("SELECT COUNT(*) FROM images");
    $req->execute();
    $array = $req->fetch();
    $req->closeCursor();
    if ($array[0] == 0)
        echo 'The Galerie is empty';
    else
    {
        try {
            $req = $db->prepare("SELECT * FROM images ORDER BY id DESC LIMIT $compteur");
            $req->execute();
            $data = $req->fetchAll();
            $req->closeCursor();
            foreach ($data as $name)
            {
                ?>
                <a href="image.php?id=<?php echo $name['id'] ?>">
                <img id="img_gallery" src="<?php echo $name['image'] ?>"/>
                </a>
                
            <?php
            }
        }
        catch (Exception $e) {
            echo "Error gallery.php : ".$e->getMessage();
        }
    }
?>
    <div id="load">
    </div>
    <form method="" name="" action="">
        <input type="hidden" id="compteur" name="compteur" value="<?php echo $compteur; ?>"/>
        <input type="button" id="loadmore" value="Load more"/>
    </form>
    </div>
    <div id="hide">
    </div>
    <br/><br/><br/><br/><br/><br/>
    <br/><br/><br/><br/><br/><br/>
    <br/><br/><br/><br/><br/><br/>
    <?php
    include "footer.html";
}
else 
{
    function redirect($location){
        echo "<script>window.location.href='".$location."'</script>";
    }
    redirect('connexion.php');
	include("header.php");
    ?>
    <h3 style="color:#fcf3b3"> <?php echo 'Vous devez vous connecter pour acceder au contenu.';?></h3>
    <?php
}
?>
<script type="text/javascript" src="gallery.js"></script>


