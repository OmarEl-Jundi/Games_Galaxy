<?php
session_start();
require 'connection.php';

$sql = "INSERT INTO wallet ( u_id, amount) VALUES ( '" . $_SESSION['user_id'] . "', '0')";
$result = mysqli_query($con, $sql);
if ($result) {
    http_response_code(200);
} else {
    echo "Error: " . $sql . "<br>" . mysqli_error($con);
}
