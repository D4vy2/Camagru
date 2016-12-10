(function() {

	var streaming 	 = false;
	var video        = document.querySelector('#video');
       	var cover        = document.querySelector('#cover');
        var canvas       = document.querySelector('#canvas');
        var photo        = document.querySelector('#photo');
        var startbutton  = document.querySelector('#startbutton');
        var savebutton  = document.querySelector('#savebutton');
		var uploadbutton = document.querySelector('#upload');
		var makebutton = document.querySelector('#makebutton');
        var width 	 = 320;
        var height 	 = 0;
	startbutton.disabled = true;
	makebutton.disabled = true;
	savebutton.disabled = true;

		var f1 = document.querySelector('#filter1');
		var f2 = document.querySelector('#filter2');
		var f3 = document.querySelector('#filter3');
		var f4 = document.querySelector('#filter4');
		var f5 = document.querySelector('#filter5');
		var f6 = document.querySelector('#filter6');

		function DisableFilters() {
			f1.disabled = true;
			f2.disabled = true;
			f3.disabled = true;
			f4.disabled = true;
			f5.disabled = true;
			f6.disabled = true;
		}

		function EnableFilters() {
			f1.disabled = false;
			f2.disabled = false;
			f3.disabled = false;
			f4.disabled = false;
			f5.disabled = false;
			f6.disabled = false;
		}

	if (!canvas) {
		alert("Impossible de recuperer le canvas!");
		return;
	}

	navigator.getMedia = ( navigator.getUserMedia ||
		navigator.webkitGetUserMedia ||
		navigator.mozGetUserMedia ||
		navigator.msGetUserMedia);

	// partie VIDEO
	var detect = navigator.userAgent;
	if (detect.match(/Firefox/g))
	{
		var constraints = {audio: false, video: true};

		navigator.mediaDevices.getUserMedia(constraints)
		.then(function(stream) {
		var video = document.querySelector('video');
		video.src = window.URL.createObjectURL(stream);
		video.onloadedmetadata = function(e) {
			video.play();
		};
		})
		.catch(function(err) {
		console.log(err.name + ": " + error.message);
		});
	}
	else
	{
		navigator.getMedia(
			{
				video: true,
				audio: false
			},
			function(stream) {
				if (navigator.mozGetUserMedia) {
					video.mozSrcObject = stream;
				} else {
					var vendorURL = window.URL || window.webkitURL;
					video.src = vendorURL.createObjectURL(stream);
				}
				video.play();
			},
			function(err) {
				console.log("An error occured! " + err);
			}
	);
}

	var localstream;
	video.addEventListener('canplay', function(ev){
			localstream = streaming;
		if (!streaming) {
			height = video.videoHeight / (video.videoWidth/width);
			video.setAttribute('width', width);
			video.setAttribute('height', height);
			canvas.setAttribute('width', width);
			canvas.setAttribute('height', height);
			streaming = true;
		}
	}, false);


	// Partie PHOTO
	function takepicture() {
		canvas.width = width;
		canvas.height = height;
		var filter = new Image();
		filter.src = checkFilter();
		//dessine dans canvas la photo sans filtre et le met dans img.src
		canvas.getContext('2d').drawImage(video, 0, 0, width, height);
		var data = canvas.toDataURL('image/png');
		document.getElementById('photo').value = data;
		var modified = canvas.toDataURL('image/png');
		photo.setAttribute('src', modified);
		photo.style.display = 'none';	
		postImage();
		// dessine dans canvas la photo AVEC filtre et le met dans canvas.src
		canvas.getContext('2d').drawImage(filter, 0, 0);			
		document.getElementById('canvas').value = data;
		canvas.setAttribute('src', data);
		// modifImage();
	}	

	function shoot() {
		// canvas.width = width;
		// canvas.height = height;
		var filter = new Image();
		filter.src = checkFilter();
		//dessine dans canvas la photo sans filtre et le met dans img.src
		var data = canvas.toDataURL('image/png');
		document.getElementById('photo').value = data;
		var modified = canvas.toDataURL('image/png');
		photo.setAttribute('src', data);
		postImage();
		// dessine dans canvas la photo AVEC filtre et le met dans canvas.src
	}	
	
	function postImage() {
		var hr = new XMLHttpRequest();
		var url = "recup.php";
		var base64 = document.getElementById("photo").src;
		var original_img = "base64="+base64;
		hr.open("POST", url, true);
		hr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
		hr.onreadystatechange = function() {
			console.log(hr);
			if(hr.readyState == 4 && hr.status == 200) {
				var return_data = hr.responseText;
				document.getElementById("status").innerHTML = return_data;
			}
		}
		hr.send(original_img);
		document.getElementById("status").innerHTML = "processing...";
	}

	function modifImage() {
		var hr = new XMLHttpRequest();
		var url = "montage.php";
		var filter = checkFilter();
		hr.open("POST", url, true);
		hr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
		hr.onreadystatechange = function() {
			console.log(hr);
			if(hr.readyState == 4 && hr.status == 200) {
				console.log("Image saved successfully!");
			}
		}
		hr.send("filter="+encodeURIComponent(filter));
	}

	function checkFilter() {
		var radios = document.getElementsByName("filter");	
		for(var i = 0; i < radios.length; i++) {
			if (radios[i].checked) {
				return "filters/"+radios[i].value+".png";			
			}
		}
	}

	function loadImage() {
		if (this.files && this.files[0]) {
			var reader = new FileReader();
			reader.onload = function(e) {
				var img = new Image();
				img.onload = function() {
					canvas.getContext("2d").drawImage(img, 0, 0, width, height);
				};
				img.src = e.target.result;
			};       
			reader.readAsDataURL(this.files[0]);
		}
		else {
			console.log("load");
		}
	}

// Pour refresh les 5 dernieres images prises par le user;
function reloadImages() {
         xhr = new XMLHttpRequest();
         var url = "lastImages.php";
         xhr.open("POST", url, true);
         xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
         xhr.onreadystatechange = function(){
            console.log(xhr);
            if (xhr.readyState == 4 && xhr.status == 200) {
                         console.log("Last Images load success!");
                         var data = xhr.responseText;
                        document.getElementById('lastPics').innerHTML = data;
            }
        }
        xhr.send();
    }

	// filters.addEventListener('click', function(ev){
	// 	startbutton.disabled = false;	
	// 	makebutton.disabled = false;
	// }, false);

	f1.addEventListener('click', function(ev){
		startbutton.disabled = false;	
		makebutton.disabled = false;
	}, false);

	f2.addEventListener('click', function(ev){
		startbutton.disabled = false;	
		makebutton.disabled = false;
	}, false);

	f3.addEventListener('click', function(ev){
		startbutton.disabled = false;	
		makebutton.disabled = false;
	}, false);

	f4.addEventListener('click', function(ev){
		startbutton.disabled = false;	
		makebutton.disabled = false;
	}, false);

	f5.addEventListener('click', function(ev){
		startbutton.disabled = false;	
		makebutton.disabled = false;
	}, false);

	f6.addEventListener('click', function(ev){
		startbutton.disabled = false;	
		makebutton.disabled = false;
	}, false);
	
	startbutton.addEventListener('click', function(ev){
		takepicture();
		savebutton.disabled = false;	
		ev.preventDefault();
	}, false);

	makebutton.addEventListener('click', function(ev){
		photo.style.display = "none";
		shoot();
		loadImage();

		modifImage();

		savebutton.disabled = true;	
		makebutton.disabled = true;	
		ev.preventDefault();
		reloadImages();
	}, false);

	savebutton.addEventListener('click', function(ev){					
		modifImage();
		reloadImages();
		savebutton.disabled = true
	}, false);

	uploadbutton.addEventListener("change", loadImage, false);
	uploadbutton.addEventListener("change", function(ev){
		makebutton.disabled = true;	
		video.pause();
		video.style.display = "none";
		startbutton.style.display = "none";
		makebutton.style.display = "inline";
		savebutton.style.display = "none";

	}, false);


})();
