<?php
session_start();
if (isset($_SESSION['login']) AND !empty($_SESSION['login'])) 
{
    include("header_deconnexion.php");
    include("config/connect_db.php");
?>

    <div class="empty">
    <?php
        function redirect($location){
            echo "<script>window.location.href='".$location."'</script>";
        }

        $id = htmlentities($_GET['id']);
        $login = htmlentities($_SESSION['login']);
        $req = $db->prepare("SELECT image FROM images WHERE id = ?");
        $req->execute(array($id));
        $result = $req->fetch();
        if (empty($result))
        {
            echo "Cette image n'existe pas!";
            redirect('gallery.php');
        }
        else
            $_SESSION['image'] = $result[0];
        $req->closeCursor();
    ?>
    <section id="comments" style="margin: auto;">
        <img id="img_gallery" src="<?php echo $result[0] ?>"/>
        <form method="" action="" name="form_like">
            <input type="hidden" name="image" value="<?php echo $id ?>"/>
            <input type="hidden" name="autor" value="<?php echo $login ?>"/>
            <input type="button" id="likebutton" name="like" value="like"/>
            <span id="nblike">
                <?php
                    $req = $db->prepare("SELECT COUNT(*) FROM likes WHERE image = ?");
                    $req->execute(array($_SESSION['image']));
                    $nb = $req->fetch();
                    $req->closeCursor();
                ?>
                    <span id="nb"><?php echo $nb[0]; ?></span>
                <?php
                    echo 'like(s)';
        
                ?>
            </span>
        </form>
        <br/>

        <!-- formulaire commentaire -->
        <form id="form_comment" action="comment.php" method="post">
            <textarea id='comment' name="comment" placeholder="Your comment..."></textarea><br/>
            <input id="send_comment" type="submit" value="send comment"/>
            <input type="hidden" name="id_img" value="<?php echo $id; ?>"/>
        </form>

        <!-- Box comment -->
        <br/>
        <div id="comment_box">
        <?php
            // Requete SQL pour savoir s'il y a des commentaires
            $req = $db->prepare("SELECT autor, comment, date_comment FROM comments WHERE image = ? ORDER BY id DESC");
            $req->execute(array($result[0]));
            while ($data = $req->fetch()) {
                    echo 'Posted by '.'<strong>'.$data['autor'].'</strong>'.' at '.$data['date_comment'].': '.'<br />';
                    echo '"'.$data['comment'].'"<br/><hr>';
            }
            $req->closeCursor();
        ?>

        </div>
    </section>
    <script type="text/javascript" src="image.js"></script>
    <?php
}
else
{
    function redirect($location){
        echo "<script>window.location.href='".$location."'</script>";
    }
    redirect('index.php');
	include("header.php");
    ?>
    <h3 style="color:#fcf3b3"> <?php echo 'Vous devez vous connecter pour acceder au contenu.';?></h3>
    <?php
}
?>
