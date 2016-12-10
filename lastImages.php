<?php
session_start();
if (isset($_SESSION['login']) AND !empty($_SESSION['login']))
{
    ?>
    <div id="lastPics">
    <h3 style="color: black; padding-left: 4px; padding-right: 4px; font-family: Didot; font-style: italic;">Your last 5 pics</h3>
    <?php
    include("config/connect_db.php");
    try {
            $login = htmlentities($_SESSION['login']);
            $req = $db->prepare("SELECT * FROM images WHERE login = ? ORDER BY id DESC LIMIT 5");
            $req->execute(array($login));
            $data = $req->fetchAll();
            $req->closeCursor();
            foreach ($data as $name)
            {
                ?>
                <a href="image.php?id=<?php echo $name['id'] ?>">
                <img id="lastImg" style="margin-left: 4px; margin-right: 4px;" src="<?php echo $name['image'] ?>"/>
                </a>
                
            <?php
            }
        }
        catch (Exception $e) {
            echo "Error lastImages.php : ".$e->getMessage();
        }
}
else
{
    echo "Vous n'avez pas acces a cette page, veuillez retourner sur la page principale.";
    function redirect($location){
        echo "<script>window.location.href='".$location."'</script>";
    }
    redirect('connexion.php');
}
    ?>
</div>