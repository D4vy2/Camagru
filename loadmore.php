<?php
session_start();

if (isset($_SESSION['login']) AND !empty($_SESSION['login']))
{
    include("config/connect_db.php");
    try {
            if (!empty($_POST['compteur']))
                $end = $_POST['compteur'];
            else {
                $start = 6;
                $end = 6;
            }
            $start = 6;
            $start = intval($start);
            $end = intval($end);
            $req = $db->prepare('SELECT * FROM images ORDER BY id DESC LIMIT :start, :end');
            $req->bindValue('start', $start, PDO::PARAM_INT);
            $req->bindValue('end', $end, PDO::PARAM_INT);
            $req->execute();
            $data = $req->fetchAll();
            $req->closeCursor();
        
            foreach ($data as $name)
            {
                ?>
                <a href="image.php?id=<?php echo $name['id']; ?>">
                <img id="img_gallery" src="<?php echo $name['image']; ?>"/>
                </a>
                
            <?php
            }
        }
    catch (Exception $e) {
        echo "Error gallery.php : ".$e->getMessage();
    }
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