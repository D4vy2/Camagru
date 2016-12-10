(function() {

    var sendComment = document.querySelector('#send_comment');
    var textarea = document.querySelector('#comment');
    var likebutton = document.querySelector('#likebutton');
    var nblike = document.querySelector('#nblike');
    var nb = document.querySelector('#nb');
    
    sendComment.addEventListener('click', function(ev) {
        var comment = textarea.value;
        comment = comment.trim();
        if (!comment) {
            alert("Please write a comment before sending!");
            ev.preventDefault();
        }
    }, false);

    function likeImage() {
        var xhr = new XMLHttpRequest();
        var url = "like.php";
        xhr.open("POST", url, true);
        xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        xhr.onreadystatechange = function() {
			console.log(xhr);
            if (xhr.readyState == 4 && xhr.status == 200) {
                var data = xhr.responseText;
                if (data == "ALREADY") {
                    alert('You already liked this picture!');
                }
                else {
                    var total = parseInt(nb.innerHTML) + 1;
                    likebutton.value = "liked";
                    nb.innerHTML = total;
                }   
            }
        }
        xhr.send();
        var resp = xhr.responseText;
        console.log(resp);
    }

    likebutton.addEventListener('click', function(ev){
        likeImage();
        likebutton.disabled = true;
    }, false);


})();