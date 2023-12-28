<?php
session_start();
require 'connection.php';

if (isset($_SESSION['user_id']) && isset($_POST['email'])) {
    $email = $_POST['email'];
    $user_id = $_SESSION['user_id'];

    $query = "SELECT * FROM user WHERE email = '$email'";
    $result = mysqli_query($con, $query);
    if (mysqli_num_rows($result) > 0) {
        http_response_code(400);
        die();
    } else {

        $query = "UPDATE user SET email = '$email' WHERE id = '$user_id'";
        $result = mysqli_query($con, $query);
        if ($result > 0) {
            http_response_code(200);
            exit();
        }
    }
} else {
    http_response_code(400);
    exit();
}
