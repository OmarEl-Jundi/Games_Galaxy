<html>

<head>
    <link rel="stylesheet" href="style.css">
</head>
<?php
require 'connection.php';
session_start();
if ($_SESSION["user_role"] != 1) {
    header("location: index.php");
}
?>
<h1 align="center">List of Games</h1>
<p align="center"><a href="admin-home.php">Go Back to Main Menu</a></p>
<div id="scrollToTopBtn" class="scroll-to-top-button" onclick="scrollToTop()">&#8679; Scroll to Top</div>
<table border="1" width="50%" bgcolor="black" align="center">
    <tr style="color: aliceblue">
        <th>ID</th>
        <th>Name</th>
        <th>Price</th>
        <th>Category</th>
        <th>Developer</th>
        <th>Image</th>
    </tr>

    <?php
    $query = "SELECT * FROM `Games`";
    require 'connection.php';
    $result = mysqli_query($con, $query);
    $x = 0;
    while ($row = mysqli_fetch_array($result)) {
        if ($x % 2 == 0) {
            echo '<tr align=center bgcolor="#2a475e" >';
        } else {
            echo '<tr align=center bgcolor="#66c0f4" >';
        }
        echo "<td>" . $row['id'] . "</td>";
        echo "<td>" . $row['name'] . "</td>";
        echo "<td>" . $row['price'] . "</td>";
        echo "<td>" . $row['category'] . "</td>";
        echo "<td>" . $row['developer'] . "</td>";
        echo "<td><img width='150' height='200' src='../images/games/{$row['image']}'></td>";
        echo "</tr>";
        $x++;
    }
    mysqli_close($con);
    ?>
</table>
<style>
    table {
        margin: 0 auto;
    }

    .scroll-to-top-button {
        display: none;
        position: fixed;
        bottom: 20px;
        right: 20px;
        background-color: firebrick;
        color: #fff;
        border: none;
        border-radius: 50%;
        padding: 10px;
        font-size: 16px;
        cursor: pointer;
    }

    #scrollToTopBtn {
        background-color: #66c0f4;
        color: black;
    }
</style>

<script>
    // Function to check the scroll position and show/hide the button
    window.onscroll = function() {
        scrollFunction();
    };

    function scrollFunction() {
        if (document.body.scrollTop > 20 || document.documentElement.scrollTop > 20) {
            document.getElementById("scrollToTopBtn").style.display = "block";
        } else {
            document.getElementById("scrollToTopBtn").style.display = "none";
        }
    }

    // Function to scroll back to the top when the button is clicked
    function scrollToTop() {
        document.body.scrollTop = 0; // For Safari
        document.documentElement.scrollTop = 0; // For Chrome, Firefox, IE, and Opera
    }
</script>