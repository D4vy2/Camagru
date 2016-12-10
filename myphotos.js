(function(){

        var imgAll = document.querySelectorAll('img')
        var del_button = document.getElementById('delete');

        function selectImage(elem){
                del_button.style.display = "block";
                for (var i = 0; i < imgAll.length; i++) {
                        imgAll[i].style.border = "none";
                }
                // put the image selected in the button value
                del_button.setAttribute('src', elem);
        }

        // Effet selection image
        for (var i = 0; i < imgAll.length; i++) {
                imgAll[i].addEventListener('click', function(ev){
                var test = this.getAttribute('src');
                selectImage(test);
                this.style.border = "solid red";
                }, false);
        }

        function deleteImage() {
                xhr = new XMLHttpRequest();
                var url = "delete_image.php";
                var imgToDel = del_button.getAttribute('src');
                var linkImg = "link="+imgToDel;
                xhr.open("POST", url, true);
                xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
                xhr.onreadystatechange = function(){
                        console.log(xhr);
                        if (xhr.readyState == 4 && xhr.status == 200)
                                console.log("Deleted Successfully!");
                }
                xhr.send(linkImg);
        }

        del_button.addEventListener('click', function(ev){
                deleteImage();
        }, false);
})();