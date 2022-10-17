function fetchTable() {
    var xhr = new XMLHttpRequest();

    xhr.addEventListener("load", function(event) {
        document.getElementById("tableDiv").innerHTML = event.target.responseText;
        //$("#theTable").DataTable( {
        //    "scrollX" : true
        //});

        $.getScript("actions/generateTable.php?idx="+String(document.getElementById("selectTable").value));
        
        num = $('input').length;

        // hopefully change each input to match the width of the column it is in
        for(var i=0;i<num;i++) {
            $('input').eq(i).width($('th').eq($('input').eq(i).index()).width()+20);
        }
    });

    xhr.addEventListener("error", function() {
        alert("something broke");
    });

    xhr.open("POST", "actions/generateTable.php");
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    xhr.send("activeOnly="+String(document.getElementsByName("activeOnly").value+"&idx="+String(document.getElementById("selectTable").value)));

}
