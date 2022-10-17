function sendData(id) {
    var xhr = new XMLHttpRequest();

    var formData = new FormData(document.getElementById(id));

    xhr.addEventListener("load", function(event) {
        console.log(id);
        document.getElementById(id+"Response").textContent = event.target.responseText;
    });

    xhr.addEventListener("error", function() {
        alert("something broke");
    });

    xhr.open("POST", "actions/" + id + ".php");


    xhr.send(formData);
}

//function showForm(id) {
//    document.getElementById("response").textContent = "";
//    document.getElementById("formSpace").innerHTML = document.getElementById(id).innerHTML;
//    var form = document.getElementsByTagName("form")[0];
//    form.addEventListener( "submit", function ( event ) {
//        event.preventDefault();
//    
//        sendData(id);
//    });
//}

$(document).ready(function() {
    $("form").submit(function(event) {
        event.preventDefault();

        sendData($(this).attr('id'));
    });

    $("#accordion").accordion({
        heightStyle : "content"
    });

});