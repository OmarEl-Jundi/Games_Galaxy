<?php
session_start();
require 'connection.php';

if (isset($_SESSION['user_id']) && isset($_POST['username'])) {
    $username = $_POST['username'];
    $user_id = $_SESSION['user_id'];
    $query = "UPDATE user SET username = '$username' WHERE id = '$user_id'";
    $result = mysqli_query($con, $query);
    if ($result > 0) {
        http_response_code(200);
    }
} else {
    http_response_code(400);
}
