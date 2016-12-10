(function(){

    var loadbutton = document.querySelector('#loadmore');
    var gallery = document.querySelector('.empty');
    var compteur = document.querySelector('#compteur');

    var divEmpty = document.querySelector('.empty');
    var children = divEmpty.childNodes;
    if (children.length === 7)
        loadbutton.style.display = 'none';

    function loadImage() {
         xhr = new XMLHttpRequest();
         var url = "loadmore.php";
         var nb = compteur.value;
         xhr.open("POST", url, true);
         xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
         xhr.onreadystatechange = function(){
            console.log(xhr);
            if (xhr.readyState == 4 && xhr.status == 200) {
                         console.log("Loadmore success!");
                         var data = xhr.responseText;
                         compteur.value = parseInt(nb) + 6;
                        document.getElementById('load').innerHTML = data;
            }
        }
        xhr.send("compteur="+(parseInt(nb)));
    }

    loadbutton.addEventListener('click', function(ev) {
        loadImage();
        ev.preventDefault();
    }, false);


})();