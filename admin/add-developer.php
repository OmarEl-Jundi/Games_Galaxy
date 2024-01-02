<html>

<head>
    <link rel="stylesheet" href="../style.css">
    <link rel="stylesheet" href="style.css">
</head>
<?php
require 'connection.php';
session_start();
if ($_SESSION["user_role"] != 1) {
    header("location: index.php");
}
?>

<body>
    <div class="container">
        <h1>Add a new Developer to the Database</h1>

        <p>Name: <input type="text" id="name"></p>
        <p>Description: <input type="text" id="desc"></p>
        <p><button onclick="addDev()" name="sb">Insert</button></p>
        <p><input type="reset" value="clear all"></p>

        <div id="ajaxDiv"></div>
        <p><a href="list-games.php">Show all Games</a></p>
        <p><a href="admin-home.php">Go Back to Main Menu</a></p>
        <script>
            function addDev() {
                var ajaxRequest = new XMLHttpRequest();
                ajaxRequest.onreadystatechange = function() {
                    if (ajaxRequest.readyState == 4) {
                        var ajaxDisplay = document.getElementById('ajaxDiv');
                        ajaxDisplay.innerHTML = ajaxRequest.responseText;
                    }
                }
                var name = document.getElementById('name').value;
                var desc = document.getElementById('desc').value;
                if (name == "" || desc == "") {
                    alert("Please fill all fields");
                    return;
                } else {
                    var queryString = "?name=" + name + "&desc=" + desc;
                    ajaxRequest.open("GET", "add-dev-proccess.php" + queryString, true);
                    ajaxRequest.send(null);
                }
            }
        </script>
    </div>
</body>

</html>