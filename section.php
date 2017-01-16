<br/>
<br/>
<br/>
<section class="center" id="section">

<label for="file" id="lbUpload">
<input type="file" id="upload" accept="image/*" name="upload"/>
<button id="preview">Preview</button>
<br/>
</label>
<div id="video-container">
	<video id="video"></video>
	<div id="overlay" style="display: none">
		<span id="nofilter" display: none; text-align: center;>	&bull;  No filter selected   &bull;</span>
		<img id="previewImage" src=""/>	
	</div>
</div>
<div id="lastPics">
<h3 style="color: black; font-family: Didot; font-style: italic;">Your last 5 pics</h3>
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
        echo "Error section.php : ".$e->getMessage();
    }
?>
</div>


<form name="filters" id="form_filter">
		<input type="radio" name="filter" id="filter1" value="filter1">
			<label for="filter1"><img src="filters/filter1.png" class="filter" alt="filter1" /></label>
		<input type="radio" name="filter" id="filter2" value="filter2">
			<label for="filter2"><img src="filters/filter2.png" class="filter" alt="filter2" /></label>	
		<input type="radio" name="filter" id="filter3" value="filter3">
			<label for="filter3"><img src="filters/filter3.png" class="filter" alt="filter3" /></label>
		<br/>
		<input type="radio" name="filter" id="filter4" value="filter4">
			<label for="filter4"><img src="filters/filter4.png" class="filter" alt="filter4" /></label>
		<input type="radio" name="filter" id="filter5" value="filter5">
			<label for="filter5"><img src="filters/filter5.png" class="filter" alt="filter5" /></label>
		<input type="radio" name="filter" id="filter6" value="filter6">
			<label for="filter6"><img src="filters/filter6.png" class="filter" alt="filter6" /></label>

</form>
<br/>
	<form name="imgform" method="" action="">
	<button type="submit" value="" id="startbutton" name="startbutton">Take it !</button>
	<button type="submit" value="" id="makebutton" name="makebutton" style="display: none;">Make it !</button>
	<input type="button" name="savebutton" id="savebutton" value="Save it!" style=""/>
	</form>
	<canvas id="canvas">
		<p>Your browser does not support the canvas, please update.</p>
	</canvas>
	<img style="width: 320px;" style="display: none;" id="photo">
	<div id="status"></div>
	<script type="text/javascript" src="webcam.js" ></script>
</section>