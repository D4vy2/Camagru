<?php
session_start();
if (isset($_SESSION['login']) AND !empty($_SESSION['login'])) {
	include("header_deconnexion.php");
    include("config/connect_db.php");
    ?>
    <br/><br/>    
    <div class="myphotos">
    <section class="empty" name="myphotos">
    <br/>
    <br/>
    <form name="form_delete" action="" method="">
        <input type="submit" id="delete" style="background-color:red; display:none; margin: auto;" type="submit" value="supprimer" name="name" src=""/>
    </form>
    <br/>
    <?php
    $login = htmlentities($_SESSION['login']);
    $req = $db->prepare("SELECT COUNT(*) FROM images WHERE login = ? ");
    $req->execute(array($login));
    $array = $req->fetch();
    $req->closeCursor();
    if ($array[0] == 0)
        echo 'You have no picture yet !';
    else {
        try {
            $req = $db->prepare("SELECT * FROM images WHERE login = ? ORDER BY id DESC");
            $req->execute(array($login));
            $data = $req->fetchAll();
            $req->closeCursor();
            foreach ($data as $name)
            {
                ?>
                <img id="img_gallery" src="<?php echo $name['image'] ?>">
                 <?php
            }
        }
        catch (Exception $e) {
            echo "Error gallery.php : ".$e->getMessage();
        }
    }
}
else {
?>
    </section>
<?php
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
<script type="text/javascript" src="myphotos.js"></script>
</div>
<br/><br/><br/><br/><br/><br/>
<?php
    include "footer.html";
?>