<?php
require 'connection.php';
if ($_SERVER["REQUEST_METHOD"] == "GET") {
    $name = $_GET['name'];
    $desc = $_GET['desc'];

    $query = "INSERT INTO `Developer`(`name`, `description`) VALUES ('$name','$desc')";
    if (mysqli_query($con, $query)) {
        echo "The Developer $name is successfully added";
    } else {
        echo "Error executing query: " . mysqli_error($con);
    }
}
